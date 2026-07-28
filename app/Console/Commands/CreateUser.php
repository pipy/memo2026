<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUser extends Command
{
    protected $signature = 'app:create-user {email?}';

    protected $description = 'Create or update the login user without exposing the password';

    public function handle(): int
    {
        $email = (string) ($this->argument('email') ?: $this->ask('Email address'));
        $name = (string) $this->ask('Display name', 'Memo User');
        $password = (string) $this->secret('Password (at least 8 characters)');
        $confirmation = (string) $this->secret('Confirm password');

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $confirmation,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        User::updateOrCreate(
            ['email' => $email],
            ['name' => $name, 'password' => Hash::make($password)],
        );

        $this->info('Login user was created or updated.');

        return self::SUCCESS;
    }
}
