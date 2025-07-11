<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getLabel(): ?string
    {
        return __('models/user.name.singular');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament-shield::filament-shield.nav.group');
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
                Select::make('roles')
                    ->label(__('models/user.columns.roles.name'))
                    ->relationship('roles', 'name', fn (Builder $query) => $query->where('name', '!=', 'Admin'))
                    ->required()
                    ->multiple()
                    ->preload(),
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
                fn (Builder $query) => $query->whereDoesntHave('roles', function ($subQuery) {
                    $subQuery->where('name', 'Admin');
                })
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
                Tables\Columns\TextColumn::make('email')
                    ->label(__('models/user.columns.email.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label(__('models/user.columns.roles.name'))
                    ->badge(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label(__('models/user.columns.email_verified_at.name'))
                    ->dateTime()
                    ->sortable(),
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
                Impersonate::make(),
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
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
