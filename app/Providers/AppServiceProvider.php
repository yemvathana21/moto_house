<?php

namespace App\Providers;

use App\Filesystem\VercelBlobAdapter;
use Illuminate\Filesystem\FilesystemAdapter as LaravelFilesystemAdapter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem as Flysystem;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);

        Storage::extend('vercel-blob', function ($app, $config) {
            $storeId = $config['store_id'];
            $hash = strtolower(str_replace('store_', '', $storeId));
            $publicUrl = $config['public_url'] ?? "https://{$hash}.public.blob.vercel-storage.com";

            $adapter = new VercelBlobAdapter(
                storeId: $storeId,
                token: $config['token'],
                publicUrl: $publicUrl,
                endpoint: 'https://blob.vercel-storage.com',
                apiUrl: $config['api_url'] ?? 'https://vercel.com/api/blob',
            );

            return new LaravelFilesystemAdapter(new Flysystem($adapter), $adapter, $config);
        });
    }
}