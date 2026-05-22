<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Products', Product::count())
                ->description('Motorcycle accessories')
                ->descriptionIcon('heroicon-o-shopping-bag')
                ->color('warning'),

            Stat::make('Total Orders', Order::count())
                ->description('All time sales')
                ->descriptionIcon('heroicon-o-truck')
                ->color('info'),

            Stat::make('Total Revenue', '$' . number_format(Order::sum('total'), 2))
                ->description('Total sales revenue')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success'),

            Stat::make('Customers', Customer::count())
                ->description('Registered customers')
                ->descriptionIcon('heroicon-o-users')
                ->color('gray'),
        ];
    }
}
