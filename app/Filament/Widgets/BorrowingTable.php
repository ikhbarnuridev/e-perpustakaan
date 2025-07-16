<?php

namespace App\Filament\Widgets;

use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Models\Borrowing;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class BorrowingTable extends BaseWidget
{
    public function getTableQuery(): Builder
    {
        return Borrowing::query();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('No')
                    ->rowIndex()
                    ->alignCenter()
                    ->width('1%'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('Member'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.nis')
                    ->label(__('NIS'))
                    ->searchable(),
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
                Tables\Columns\TextColumn::make('returned_at')
                    ->label(__('Returned At'))
                    ->date()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ->filters([])
            ->headerActions([
                FilamentExportHeaderAction::make('export')
                    ->label(__('Export'))
                    ->withHiddenColumns()
                    ->modalHeading(__('Export Borrowing Records')),
            ])
            ->paginated([5, 10, 25])
            ->defaultSort('id', 'desc')
            ->heading(__('Borrowing Records'));
    }
}
