<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Models\Book;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;

class BookResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function getLabel(): ?string
    {
        return __('models/book.name.singular');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Book Collection Management');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label(__('models/book.columns.title.name'))
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                FileUpload::make('cover')
                    ->label(__('models/book.columns.cover.name'))
                    ->image()
                    ->directory('book/covers')
                    ->imageEditor()
                    ->maxSize(2048)
                    ->columnSpanFull(),
                Select::make('categories')
                    ->label(__('models/category.name.plural'))
                    ->multiple()
                    ->relationship('categories', 'name')
                    ->preload()
                    ->searchable()
                    ->columnSpanFull(),
                TextInput::make('author')
                    ->label(__('models/book.columns.author.name'))
                    ->required()
                    ->maxLength(255),
                Select::make('year_published')
                    ->label(__('models/book.columns.year_published.name'))
                    ->options(array_combine(range(now()->year, 1900), range(now()->year, 1900)))
                    ->native(false)
                    ->searchable()
                    ->required(),
                TextInput::make('publisher')
                    ->label(__('models/book.columns.publisher.name'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('stock')
                    ->label(__('models/book.columns.stock.name'))
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('No')
                    ->rowIndex()
                    ->alignCenter()
                    ->width('1%'),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('models/book.columns.title.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('categories.name')   // Kategori
                    ->label(__('models/category.name.plural'))
                    ->badge()
                    ->limitList(),
                Tables\Columns\TextColumn::make('author')
                    ->label(__('models/book.columns.author.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('year_published')
                    ->label(__('Year Published'))
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('publisher')
                    ->label(__('models/book.columns.publisher.name'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('stock')
                    ->label(__('models/book.columns.stock.name'))
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('available_stock')
                    ->label(__('models/book.columns.available_stock.name'))
                    ->getStateUsing(fn ($record) => $record->availableStock())
                    ->alignCenter()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->paginated([5, 10, 25])
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBooks::route('/'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'restore',
            'restore_any',
            'replicate',
            'reorder',
            'delete',
            'delete_any',
            'force_delete',
            'force_delete_any',
            'borrow',
        ];
    }
}
