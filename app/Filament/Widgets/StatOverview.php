<?php

namespace App\Filament\Widgets;

use App\Models\Measurement;
use App\Models\Recommendation;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pengguna', User::count())
                ->description('Total penggguna aktif')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make('Total Pengukuran', Measurement::count())
                ->description('7% decrease')
                ->descriptionIcon('heroicon-m-arrow-trending-down'),
            Stat::make('Penyakit Dikenali', Recommendation::count())
                ->description('3% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
        ];
    }
}
