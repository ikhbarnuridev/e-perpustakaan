<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AnnouncementWidget;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Dashboard;
use Filament\Widgets\AccountWidget;
use Illuminate\Contracts\Support\Htmlable;

class HomePage extends Dashboard
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $routePath = 'home';

    protected static ?string $slug = 'home';

    protected static string $view = 'filament.pages.home-page';

    public static function getNavigationLabel(): string
    {
        return __('Home');
    }

    public function getTitle(): string|Htmlable
    {
        return __('Home');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->hasRole('Member');
    }

    public function getColumns(): int|string|array
    {
        return 1;
    }

    public function getWidgets(): array
    {
        $widgets = [
            AccountWidget::class,
            AnnouncementWidget::class,
        ];

        return $widgets;
    }
}
