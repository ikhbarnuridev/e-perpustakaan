<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Models\Book;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function getLabel(): ?string
    {
        return __('Book');
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
                    ->label(__('Judul'))
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                FileUpload::make('cover')
                    ->label(__('Cover'))
                    ->image()
                    ->directory('book/covers')
                    ->imageEditor()
                    ->maxSize(2048)
                    ->columnSpanFull(),
                Select::make('categories')
                    ->label('Kategori')
                    ->multiple()
                    ->relationship('categories', 'name')
                    ->preload()
                    ->searchable()
                    ->columnSpanFull(),
                TextInput::make('author')
                    ->label(__('Author'))
                    ->required()
                    ->maxLength(255),
                Select::make('year_published')
                    ->options(array_combine(range(now()->year, 1900), range(now()->year, 1900)))
                    ->native(false)
                    ->searchable()
                    ->required(),
                TextInput::make('publisher')
                    ->label(__('Penerbit'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('stock')
                    ->label(__('Stok'))
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
                    ->searchable(),
                Tables\Columns\TextColumn::make('categories.name')   // Kategori
                    ->label('Kategori')
                    ->badge()
                    ->limitList(),
                Tables\Columns\TextColumn::make('author')
                    ->label(__('Author'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('year_published')
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('publisher')
                    ->label(__('Publisher'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('stock')
                    ->label(__('Stock'))
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('available_stock')
                    ->label(__('Available Stock'))
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
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBooks::route('/'),
        ];
    }
}
