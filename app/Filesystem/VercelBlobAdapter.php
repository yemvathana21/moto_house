<?php

namespace App\Filesystem;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use League\Flysystem\Config;
use League\Flysystem\FileAttributes;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\UnableToCheckExistence;
use League\Flysystem\UnableToCopyFile;
use League\Flysystem\UnableToCreateDirectory;
use League\Flysystem\UnableToDeleteDirectory;
use League\Flysystem\UnableToDeleteFile;
use League\Flysystem\UnableToMoveFile;
use League\Flysystem\UnableToReadFile;
use League\Flysystem\UnableToRetrieveMetadata;
use League\Flysystem\UnableToSetVisibility;
use League\Flysystem\UnableToWriteFile;

class VercelBlobAdapter implements FilesystemAdapter
{
    private Client $http;

    public function __construct(
        private string $storeId,
        private string $token,
        private string $publicUrl,
        private string $endpoint,
        private string $apiUrl,
        ?Client $http = null,
    ) {
        $this->http = $http ?? new Client([
            'timeout' => 30,
            'connect_timeout' => 10,
        ]);
    }

    public function getUrl(string $path): string
    {
        return rtrim($this->publicUrl, '/') . '/' . ltrim($path, '/');
    }

    public function fileExists(string $path): bool
    {
        try {
            $response = $this->http->get(rtrim($this->apiUrl, '/') . '?url=' . urlencode($this->getUrl($path)), [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                    'x-vercel-blob-store-id' => $this->storeId,
                ],
                'http_errors' => false,
            ]);

            if ($response->getStatusCode() === 200) {
                $body = json_decode($response->getBody()->getContents(), true);
                return isset($body['url']);
            }

            return false;
        } catch (GuzzleException $e) {
            throw UnableToCheckExistence::forLocation($path, $e->getMessage());
        }
    }

    public function directoryExists(string $path): bool
    {
        return true;
    }

    public function write(string $path, string $contents, Config $config): void
    {
        try {
            $url = rtrim($this->endpoint, '/') . '/' . $this->storeId . '/' . ltrim($path, '/');
            $contentType = $config->get('Content-Type', 'application/octet-stream');

            $this->http->put($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                    'Content-Type' => $contentType,
                    'x-add-random-suffix' => 'false',
                ],
                'body' => $contents,
                'http_errors' => true,
            ]);
        } catch (GuzzleException $e) {
            throw UnableToWriteFile::atLocation($path, $e->getMessage());
        }
    }

    public function writeStream(string $path, $contents, Config $config): void
    {
        $content = stream_get_contents($contents);
        if ($content === false) {
            throw UnableToWriteFile::atLocation($path, 'Failed to read stream');
        }
        $this->write($path, $content, $config);
    }

    public function read(string $path): string
    {
        try {
            $response = $this->http->get($this->getUrl($path), [
                'http_errors' => true,
            ]);
            return $response->getBody()->getContents();
        } catch (GuzzleException $e) {
            throw UnableToReadFile::fromLocation($path, previous: $e);
        }
    }

    public function readStream(string $path)
    {
        try {
            $response = $this->http->get($this->getUrl($path), [
                'http_errors' => true,
                'stream' => true,
            ]);
            return $response->getBody()->detach();
        } catch (GuzzleException $e) {
            throw UnableToReadFile::fromLocation($path, previous: $e);
        }
    }

    public function delete(string $path): void
    {
        try {
            $response = $this->http->post(rtrim($this->apiUrl, '/') . '/delete', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                    'x-vercel-blob-store-id' => $this->storeId,
                    'Content-Type' => 'application/json',
                ],
                'json' => ['urls' => [$this->getUrl($path)]],
                'http_errors' => false,
            ]);

            if ($response->getStatusCode() !== 200) {
                throw UnableToDeleteFile::atLocation($path, $response->getBody()->getContents());
            }
        } catch (GuzzleException $e) {
            throw UnableToDeleteFile::atLocation($path, $e->getMessage());
        }
    }

    public function deleteDirectory(string $path): void
    {
    }

    public function createDirectory(string $path, Config $config): void
    {
    }

    public function setVisibility(string $path, string $visibility): void
    {
        throw UnableToSetVisibility::atLocation($path, 'Vercel Blob does not support per-file visibility');
    }

    public function visibility(string $path): FileAttributes
    {
        return new FileAttributes($path, visibility: 'public');
    }

    public function mimeType(string $path): FileAttributes
    {
        try {
            $response = $this->http->head($this->getUrl($path), [
                'http_errors' => false,
            ]);

            if ($response->getStatusCode() !== 200) {
                throw UnableToRetrieveMetadata::create($path, 'mimeType');
            }

            $contentType = $response->getHeaderLine('Content-Type') ?: 'application/octet-stream';
            return new FileAttributes($path, mimeType: $contentType);
        } catch (GuzzleException $e) {
            throw UnableToRetrieveMetadata::create($path, 'mimeType');
        }
    }

    public function lastModified(string $path): FileAttributes
    {
        try {
            $response = $this->http->head($this->getUrl($path), [
                'http_errors' => false,
            ]);

            if ($response->getStatusCode() !== 200) {
                throw UnableToRetrieveMetadata::create($path, 'lastModified');
            }

            $lastModified = $response->getHeaderLine('Last-Modified');
            $timestamp = $lastModified ? strtotime($lastModified) : time();
            return new FileAttributes($path, lastModified: $timestamp);
        } catch (GuzzleException $e) {
            throw UnableToRetrieveMetadata::create($path, 'lastModified');
        }
    }

    public function fileSize(string $path): FileAttributes
    {
        try {
            $response = $this->http->head($this->getUrl($path), [
                'http_errors' => false,
            ]);

            if ($response->getStatusCode() !== 200) {
                throw UnableToRetrieveMetadata::create($path, 'fileSize');
            }

            $size = (int) $response->getHeaderLine('Content-Length');
            return new FileAttributes($path, fileSize: $size);
        } catch (GuzzleException $e) {
            throw UnableToRetrieveMetadata::create($path, 'fileSize');
        }
    }

    public function listContents(string $path, bool $deep): iterable
    {
        return [];
    }

    public function move(string $source, string $destination, Config $config): void
    {
        try {
            $this->write($destination, $this->read($source), $config);
            $this->delete($source);
        } catch (GuzzleException $e) {
            throw UnableToMoveFile::fromLocationTo($source, $destination, $e);
        }
    }

    public function copy(string $source, string $destination, Config $config): void
    {
        try {
            $this->write($destination, $this->read($source), $config);
        } catch (GuzzleException $e) {
            throw UnableToCopyFile::fromLocationTo($source, $destination, $e);
        }
    }

    public function checksum(string $path, Config $config): string
    {
        throw UnableToRetrieveMetadata::create($path, 'checksum');
    }
}
