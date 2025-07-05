<?php

namespace App\Filament\Pages;

use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Resources\BorrowingResource;
use App\Models\Borrowing;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;

class ReportingPage extends Page implements HasTable
{
    use HasPageShield, InteractsWithTable;

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

    public function table(Table $table): Table
    {
        return $table
            ->query(fn () => Borrowing::query())
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
