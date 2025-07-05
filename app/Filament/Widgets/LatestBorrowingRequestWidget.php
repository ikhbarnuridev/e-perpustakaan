<?php

namespace App\Filament\Widgets;

use App\Models\Borrowing;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\Support\Htmlable;

class LatestBorrowingRequestWidget extends BaseWidget
{
    use HasWidgetShield;

    protected function getTableHeading(): string|Htmlable|null
    {
        return __('Latest Borrowing Request');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Borrowing::query()->where('status', Borrowing::STATUS_PENDING)
            )
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('No')
                    ->rowIndex()
                    ->alignCenter()
                    ->width('1%'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('Member'))
                    ->searchable()
                    ->visible(fn () => auth()->user()->isAdmin()),
                Tables\Columns\TextColumn::make('book.title')
                    ->label(__('Book'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('borrowed_at')
                    ->label(__('Borrowed At'))
                    ->date()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('due_date')
                    ->label(__('Due Date'))
                    ->date()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'approved' => 'success',
                        'borrowed' => 'warning',
                        'returned' => 'info',
                        'rejected' => 'danger',
                    })
                    ->formatStateUsing(fn ($state) => ucfirst($state))
                    ->alignCenter(),
            ])
            ->paginated([5, 10, 25])
            ->defaultSort('id', 'desc');
    }
}
