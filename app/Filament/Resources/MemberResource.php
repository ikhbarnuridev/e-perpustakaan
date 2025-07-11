<?php

namespace App\Filament\Resources;

use App\Filament\Pages\DashboardPage;
use App\Filament\Resources\MemberResource\Pages;
use App\Models\User;
use App\Policies\MemberPolicy;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class MemberResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getNavigationSort(): ?int
    {
        return DashboardPage::getNavigationSort() + 1;
    }

    public static function getLabel(): ?string
    {
        return __('Member');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('models/user.columns.name.name'))
                    ->required()
                    ->maxLength(255)
                    ->autofocus(),
                TextInput::make('username')
                    ->label(__('models/user.columns.username.name'))
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                TextInput::make('email')
                    ->label(__('models/user.columns.email.name'))
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                TextInput::make('nis')
                    ->label(__('models/user.columns.nis.name'))
                    ->required()
                    ->length(10)
                    ->numeric()
                    ->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->label(__('models/user.columns.password.name'))
                    ->password()
                    ->revealable(filament()->arePasswordsRevealable())
                    ->required(fn ($context) => $context == 'create')
                    ->rule(Password::default())
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->same('passwordConfirmation'),
                TextInput::make('passwordConfirmation')
                    ->label(__('models/user.columns.password_confirmation.name'))
                    ->password()
                    ->revealable(filament()->arePasswordsRevealable())
                    ->required(fn ($context) => $context == 'create')
                    ->dehydrated(false),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(
                fn (Builder $query) => $query->whereRelation('roles', 'name', 'Member')
            )
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
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ManageMembers::route('/'),
        ];
    }

    public static function canViewAny(): bool
    {
        return app(MemberPolicy::class)->viewAny(auth()->user());
    }

    public static function canView(Model $record): bool
    {
        return app(MemberPolicy::class)->view(auth()->user());
    }

    public static function canCreate(): bool
    {
        return app(MemberPolicy::class)->create(auth()->user());
    }

    public static function canEdit(Model $record): bool
    {
        return app(MemberPolicy::class)->update(auth()->user());
    }

    public static function canDelete(Model $record): bool
    {
        return app(MemberPolicy::class)->delete(auth()->user());
    }

    public static function canDeleteAny(): bool
    {
        return app(MemberPolicy::class)->deleteAny(auth()->user());
    }

    public static function canForceDelete(Model $record): bool
    {
        return app(MemberPolicy::class)->forceDelete(auth()->user());
    }

    public static function canForceDeleteAny(): bool
    {
        return app(MemberPolicy::class)->forceDeleteAny(auth()->user());
    }

    public static function canRestore(Model $record): bool
    {
        return app(MemberPolicy::class)->restore(auth()->user());
    }

    public static function canRestoreAny(): bool
    {
        return app(MemberPolicy::class)->restoreAny(auth()->user());
    }

    public static function canReplicate(Model $record): bool
    {
        return app(MemberPolicy::class)->replicate(auth()->user());
    }

    public static function canReorder(): bool
    {
        return app(MemberPolicy::class)->reorder(auth()->user());
    }
}
