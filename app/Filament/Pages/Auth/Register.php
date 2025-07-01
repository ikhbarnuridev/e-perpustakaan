<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Register as BaseRegister;

class Register extends BaseRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getNisFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getNisFormComponent(): Component
    {
        return TextInput::make('nis')
            ->label(__('NIS'))
            ->required()
            ->length(10)
            ->numeric()
            ->unique($this->getUserModel());
    }

    protected function mutateFormDataBeforeRegister(array $data): array
    {
        $data['username'] = $data['nis'];

        return $data;
    }
}
