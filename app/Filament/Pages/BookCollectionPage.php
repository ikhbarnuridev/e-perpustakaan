<?php

namespace App\Filament\Pages;

use App\Filament\Resources\MemberResource;
use App\Models\Book;
use App\Models\Borrowing;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Infolists;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
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
use Filament\Tables\Filters\SelectFilter;
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
                            ->getStateUsing(fn ($record) => $record->cover ?: asset('assets/images/no-image.svg'))
                            ->extraAttributes(['class' => 'mb-2']),
                        Stack::make([
                            TextColumn::make('title')
                                ->label(__('Title'))
                                ->weight(FontWeight::Bold)
                                ->limit(40)
                                ->searchable(),
                            TextColumn::make('author')
                                ->label(__('Author'))
                                ->size(TextColumnSize::ExtraSmall)
                                ->searchable()
                                ->formatStateUsing(function ($state, $record) {
                                    return "{$state} ({$record->year_published})";
                                }),
                            TextColumn::make('categories.name')
                                ->label(_('Category'))
                                ->badge()
                                ->getStateUsing(fn ($record) => $record->categories->pluck('name')->take(2))
                                ->extraAttributes(['class' => 'mt-2']),
                        ]),
                    ]),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label(__('Category'))
                    ->relationship('categories', 'name')
                    ->multiple()
                    ->preload()
                    ->optionsLimit(5)
                    ->searchable(),
            ])
            ->contentGrid([
                'md' => 2,
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
                    ->modalAlignment('center')
                    ->modalWidth(MaxWidth::Large)
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false)
                    ->infolist([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                ImageEntry::make('cover')
                                    ->label(__('Cover'))
                                    ->hiddenLabel()
                                    ->columnSpanFull()
                                    ->height(420)
                                    ->width('100%')
                                    ->alignCenter()
                                    ->getStateUsing(fn ($record) => $record->cover ?: asset('assets/images/no-image.svg')),
                                TextEntry::make('title')
                                    ->label(__('Title')),
                                TextEntry::make('author')
                                    ->label(__('Author')),
                                TextEntry::make('publisher')
                                    ->label(__('Publisher')),
                                TextEntry::make('year_published')
                                    ->label(__('Year Published')),
                                TextEntry::make('stock')
                                    ->label(__('Available Stock')),
                                TextEntry::make('categories.name')
                                    ->label(__('Category'))
                                    ->badge(),
                            ]),
                    ]),
                Action::make('borrow')
                    ->label(function ($record) {
                        if ($record->availableStock() <= 0) {
                            return __('Out of Stock');
                        }

                        if ($record->isBorrowedBy(auth()->user())) {
                            return __('Already Borrowed');
                        }

                        return __('Borrow');
                    })
                    ->icon('heroicon-o-bookmark')
                    ->button()
                    ->extraAttributes(['class' => 'w-full'])
                    ->requiresConfirmation()
                    ->disabled(fn ($record) => ! $record->canBeBorrowed())
                    ->extraAttributes(['class' => 'w-full'])
                    ->form([
                        DatePicker::make('borrowed_at')
                            ->label(__('Borrowed At'))
                            ->default(now())
                            ->readOnly(),
                        Select::make('duration')
                            ->label(__('Borrowing Duration'))
                            ->options([
                                '3' => '3 Hari',
                                '7' => '1 Minggu',
                                '14' => '2 Minggu',
                            ])
                            ->required()
                            ->native(false),
                    ])
                    ->action(function ($record, array $data) {
                        try {
                            Borrowing::create([
                                'user_id' => auth()->user()->id,
                                'book_id' => $record->id,
                                'borrowed_at' => $data['borrowed_at'],
                                'due_date' => now()->addDays((int) $data['duration']),
                            ]);

                            Notification::make()
                                ->title(__('Borrowing request submitted successfully'))
                                ->success()
                                ->send();
                        } catch (\Throwable $e) {
                            Notification::make()
                                ->title(__('Failed to submit borrowing request'))
                                ->danger()
                                ->send();
                        }
                    })
                    ->visible(fn () => auth()->user()->can('borrow_book')),
            ])
            ->paginated([12])
            ->defaultSort('id', 'desc');
    }
}
