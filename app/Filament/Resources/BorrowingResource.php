<?php

namespace App\Filament\Resources;

use App\Filament\Pages\BookCollectionPage;
use App\Filament\Resources\BorrowingResource\Pages;
use App\Models\Book;
use App\Models\Borrowing;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BorrowingResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Borrowing::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function getNavigationSort(): ?int
    {
        return BookCollectionPage::getNavigationSort() + 1;
    }

    public static function getLabel(): ?string
    {
        return __('models/borrowing.name.singular');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label(__('models/borrowing.columns.user_id.name'))
                    ->relationship(
                        name: 'user',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) => $query->whereHas('roles', fn ($q) => $q->where('name', 'Member'))
                    )->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} ({$record->nis})")
                    ->optionsLimit(5)
                    ->searchable(),
                Select::make('book_id')
                    ->label(__('models/borrowing.columns.book_id.name'))
                    ->searchable()
                    ->optionsLimit(5)
                    ->getSearchResultsUsing(function (string $search) {
                        return Book::where('title', 'like', "%{$search}%")
                            ->get()
                            ->filter(fn ($book) => $book->canBeBorrowed())
                            ->pluck('title', 'id');
                    })
                    ->getOptionLabelUsing(fn ($value): ?string => Book::find($value)?->title)
                    ->required(),
                DatePicker::make('borrowed_at')
                    ->label(__('models/borrowing.columns.borrowed_at.name'))
                    ->default(now())
                    ->readOnly(),
                DatePicker::make('due_date')
                    ->label(__('models/borrowing.columns.due_date.name'))
                    ->minDate(now()->tomorrow())
                    ->required(),
                Select::make('status')
                    ->label(__('models/borrowing.columns.status.name'))
                    ->options(Borrowing::STATUSES)
                    ->preload()
                    ->native(false)
                    ->required()
                    ->visible(fn ($context) => $context == 'edit' && auth()->user()->can('select_status_borrowing')),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        $canSelectStatus = auth()->user()->can('select_status_borrowing');

        $statusColumn = $canSelectStatus
            ? Tables\Columns\SelectColumn::make('status')
                ->label(__('models/borrowing.columns.status.name'))
                ->options(Borrowing::STATUSES)
                ->alignCenter()
            : Tables\Columns\TextColumn::make('status')
                ->label(__('models/borrowing.columns.status.name'))
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'pending' => 'gray',
                    'approved' => 'success',
                    'borrowed' => 'warning',
                    'returned' => 'info',
                    'rejected' => 'danger',
                })
                ->formatStateUsing(fn ($state) => ucfirst($state))
                ->alignCenter();

        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $user = auth()->user();

                if ($user->isMember()) {
                    $query->where('user_id', $user->id);
                }

                return $query;
            })
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('No')
                    ->rowIndex()
                    ->alignCenter()
                    ->width('1%'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('models/borrowing.columns.user_id.name'))
                    ->searchable()
                    ->visible(fn () => auth()->user()->isAdmin()),
                Tables\Columns\TextColumn::make('book.title')
                    ->label(__('models/borrowing.columns.book_id.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('borrowed_at')
                    ->label(__('models/borrowing.columns.borrowed_at.name'))
                    ->date()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('due_date')
                    ->label(__('models/borrowing.columns.due_date.name'))
                    ->date()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('returned_at')
                    ->label(__('models/borrowing.columns.returned_at.name'))
                    ->date()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
                $statusColumn,
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('approve')
                    ->label(__('Approve'))
                    ->icon('heroicon-o-check-circle')
                    ->color(Color::Green)
                    ->button()
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->isPending() && auth()->user()->can('approve_borrowing'))
                    ->extraAttributes(['class' => 'w-full'])
                    ->action(function ($record) {
                        try {
                            $record->approve();

                            Notification::make()
                                ->title(__('Borrowing has been approved successfully'))
                                ->success()
                                ->send();
                        } catch (\Throwable $e) {
                            Notification::make()
                                ->title(__('Failed to approve borrowing. Please try again later.'))
                                ->danger()
                                ->send();
                        }
                    }),
                Action::make('reject')
                    ->label(__('Reject'))
                    ->icon('heroicon-o-x-circle')
                    ->color(Color::Red)
                    ->button()
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->isPending() && auth()->user()->can('reject_borrowing'))
                    ->extraAttributes(['class' => 'w-full'])
                    ->action(function ($record) {
                        try {
                            $record->reject();

                            Notification::make()
                                ->title(__('Borrowing has been rejected successfully'))
                                ->success()
                                ->send();
                        } catch (\Throwable $e) {
                            Notification::make()
                                ->title(__('Failed to reject borrowing'))
                                ->danger()
                                ->send();
                        }
                    }),
                Action::make('confirm_pickup')
                    ->label(__('Confirm Pickup'))
                    ->icon('heroicon-o-check-circle')
                    ->color(Color::Yellow)
                    ->button()
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->isApporved() && auth()->user()->can('confirm_pickup_borrowing'))
                    ->extraAttributes(['class' => 'w-full'])
                    ->action(function ($record) {
                        try {
                            $record->confirmPickup();

                            Notification::make()
                                ->title(__('Borrowing pickup has been confirmed successfully'))
                                ->success()
                                ->send();
                        } catch (\Throwable $e) {
                            Notification::make()
                                ->title(__('Failed to confirm borrowing pickup'))
                                ->danger()
                                ->send();
                        }
                    }),
                Action::make('confirm_return')
                    ->label(__('Confirm Return'))
                    ->icon('heroicon-o-check-circle')
                    ->color(Color::Cyan)
                    ->button()
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->isBorrowed() && auth()->user()->can('confirm_return_borrowing'))
                    ->extraAttributes(['class' => 'w-full'])
                    ->action(function ($record) {
                        try {
                            $record->confirmReturn();

                            Notification::make()
                                ->title(__('Book return has been confirmed successfully'))
                                ->success()
                                ->send();
                        } catch (\Throwable $e) {
                            Notification::make()
                                ->title(__('Failed to confirm book return'))
                                ->danger()
                                ->send();
                        }
                    }),
                ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->modalWidth(MaxWidth::Medium),
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
            'index' => Pages\ManageBorrowings::route('/'),
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
            'select_status',
            'approve',
            'reject',
            'confirm_pickup',
            'confirm_return',
        ];
    }
}
