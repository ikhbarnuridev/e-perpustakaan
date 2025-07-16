<?php

namespace App\Filament\Widgets;

use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class MemberTable extends BaseWidget
{
    public function getTableQuery(): Builder
    {
        return User::query()->whereRelation('roles', 'name', 'Member');
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
                Tables\Columns\TextColumn::make('name')
                    ->label(__('models/user.columns.name.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('username')
                    ->label(__('models/user.columns.username.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('models/user.columns.email.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('nis')
                    ->label(__('models/user.columns.nis.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('models/user.columns.created_at.name'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('models/user.columns.updated_at.name'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->headerActions([
                FilamentExportHeaderAction::make('export')
                    ->label(__('Export'))
                    ->withHiddenColumns()
                    ->modalHeading(__('Export Member Records')),
            ])
            ->paginated([5, 10, 25])
            ->defaultSort('id', 'desc')
            ->heading(__('Member Records'));
    }
}
