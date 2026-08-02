<?php
namespace App\Filament\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Schemas\Schema; // Gunakan Schema di v5
use Filament\Forms\Components\TextInput;

class Login extends BaseLogin
{
    /**
     * Mengubah field input 'email' menjadi 'username'
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->autocomplete('username'),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'username' => $data['username'],
            'password' => $data['password'],
        ];
    }
}
