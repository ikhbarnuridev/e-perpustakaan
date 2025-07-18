<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\LatestBorrowingRequestWidget;
use App\Filament\Widgets\StatsOverviewWidget;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Dashboard;
use Filament\Widgets\AccountWidget;
use Illuminate\Contracts\Support\Htmlable;

class DashboardPage extends Dashboard
{
    use HasPageShield;

    protected static ?int $navigationSort = 0;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static string $routePath = 'dashboard';

    protected static ?string $slug = 'dashboard';

    protected static string $view = 'filament.pages.dashboard-page';

    public static function getNavigationLabel(): string
    {
        return __('Dashboard');
    }

    public function getTitle(): string|Htmlable
    {
        return __('Dashboard');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return ! auth()->user()?->hasRole('Member');
    }

    public function getColumns(): int|string|array
    {
        return 1;
    }

    public function getWidgets(): array
    {
        $widgets = [
            AccountWidget::class,
            StatsOverviewWidget::class,
            LatestBorrowingRequestWidget::class,
        ];

        return $widgets;
    }
}
