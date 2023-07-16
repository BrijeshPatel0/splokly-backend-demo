<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Hashing\BcryptHasher;
use Spatie\Permission\Models\Role;
use Laravel\Socialite\Two\User as SocialiteUser;


class UserRepository implements UserRepositoryInterface
{
    public function getUserByEmail(string $email): User
    {
        return User::where('email',  $email)->firstOrFail();
    }

    public function createUserOrUpdate(array $userData): User
    {
        return User::updateOrCreate(
            [
                'email' => $userData['email']
            ],
            [
                'password' => Hash::make($userData['password']),
                'name' => $userData['name']
            ]
        );
    }

    public function getUserOrCreate(SocialiteUser $user): User
    {
        return User::firstOrCreate(
            [
                'email' => $user->getEmail()
            ],
            [
                'email_verified_at' => now(),
                'name' => $user->getName()
            ]
        );
    }

    public function updateUserRole(int $user_id, string $role): void
    {
        User::find($user_id)->assignRole($role);
    }

    public function getRoleByEmail(string $email): Role|null
    {
        return User::where('email', $email)
            ->first()
            ->roles()
            ->first();
    }
}
