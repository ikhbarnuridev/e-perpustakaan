<?php

namespace App\Filament\Pages;

use App\Filament\Resources\MemberResource;
use App\Models\Book;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;

class BookCollectionPage extends Page implements HasTable
{
    use HasPageShield, InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static string $view = 'filament.pages.book-collection-page';

    protected static ?string $slug = 'book-collection';

    public static function getNavigationSort(): ?int
    {
        return MemberResource::getNavigationSort() + 1;
    }

    public static function getNavigationLabel(): string
    {
        return __('Book Collection');
    }

    public function getTitle(): string|Htmlable
    {
        return __('Book Collection');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(fn () => Book::query())
            ->columns([
                Grid::make([
                    'default' => 1,
                    'xl' => 2,
                ])
                    ->schema([
                        ImageColumn::make('cover')
                            ->label(__('Cover'))
                            ->height(158)
                            ->width(128)
                            ->circular(false)
                            ->alignCenter()
                            ->getStateUsing(fn ($record) => $record->cover ?: asset('assets/images/no-image.svg')),
                        Stack::make([
                            TextColumn::make('title')
                                ->label(__('Title'))
                                ->weight(FontWeight::Bold)
                                ->searchable(),
                            TextColumn::make('author')
                                ->label(__('Author'))
                                ->size(TextColumnSize::ExtraSmall)
                                ->searchable()
                                ->formatStateUsing(function ($state, $record) {
                                    return "{$state} ({$record->year_published})";
                                }),
                        ])
                            ->extraAttributes(['class' => 'my-4']),
                    ]),
            ])
            ->contentGrid([
                'md' => 3,
                'xl' => 3,
            ])
            ->actions([
                Action::make('detail')
                    ->label(__('See Detail'))
                    ->icon('heroicon-o-eye')
                    ->color(Color::Cyan)
                    ->button()
                    ->extraAttributes(['class' => 'w-full'])
                    ->modal()
                    ->modalHeading(__('Book Detail'))
                    ->modalWidth(MaxWidth::Large)
                    ->modalSubmitAction(false),
                Action::make('borrow')
                    ->label(__('Borrow'))
                    ->icon('heroicon-o-bookmark')
                    ->button()
                    ->extraAttributes(['class' => 'w-full'])
                    ->requiresConfirmation(),
            ]);
    }
}
