<?php

namespace App\Filament\Widgets;

use App\Filament\Pages\BookCollectionPage;
use App\Filament\Resources\BorrowingResource;
use App\Filament\Resources\MemberResource;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    use HasWidgetShield;

    protected function getHeading(): ?string
    {
        return __('Stats Overview');
    }

    protected function getStats(): array
    {
        return [
            Stat::make(
                label: __('Member'),
                value: User::query()
                    ->whereRelation('roles', 'name', 'Member')
                    ->count()
            )
                ->icon('heroicon-o-users')
                ->url(MemberResource::getUrl()),
            Stat::make(
                label: __('Book Collection'),
                value: Book::count(),
            )
                ->icon('heroicon-o-book-open')
                ->url(BookCollectionPage::getUrl()),
            Stat::make(
                label: __('Borrowing'),
                value: Borrowing::count()
            )
                ->icon('heroicon-o-archive-box')
                ->url(BorrowingResource::getUrl()),
        ];
    }
}
