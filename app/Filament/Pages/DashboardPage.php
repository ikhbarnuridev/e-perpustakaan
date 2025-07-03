<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard;
use Filament\Widgets\AccountWidget;

class DashboardPage extends Dashboard
{
    protected static ?int $navigationSort = 0;

    protected static ?string $title = 'Dashboard';

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static string $routePath = 'dashboard';

    protected static ?string $slug = 'dashboard';

    public function getColumns(): int|string|array
    {
        return 1;
    }

    public function getWidgets(): array
    {
        $widgets = [
            AccountWidget::class,
        ];

        return $widgets;
    }
}
