<?php

namespace App\Filament\Pages;

use App\Filament\Resources\BorrowingResource;
use App\Filament\Widgets\BorrowingStatusChart;
use App\Filament\Widgets\BorrowingTable;
use App\Filament\Widgets\MemberTable;
use App\Filament\Widgets\MonthlyBorrowingChart;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class ReportingPage extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static string $view = 'filament.pages.reporting-page';

    protected static ?string $slug = 'reporting';

    public static function getNavigationSort(): ?int
    {
        return BorrowingResource::getNavigationSort() + 1;
    }

    public static function getNavigationLabel(): string
    {
        return __('Reporting');
    }

    public function getTitle(): string|Htmlable
    {
        return __('Reporting');
    }

    public function getBorrowingTable(): string
    {
        return BorrowingTable::class;
    }

    public function getMemberTable(): string
    {
        return MemberTable::class;
    }

    public function getHeaderWidgets(): array
    {
        $widgets = [
            BorrowingStatusChart::class,
            MonthlyBorrowingChart::class,
        ];

        return $widgets;
    }

    public function getHeaderWidgetsColumns(): int|string|array
    {
        return 2;
    }
}
