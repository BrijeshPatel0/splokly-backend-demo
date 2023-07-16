<?php

namespace App\Interfaces;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Laravel\Socialite\Two\User as SocialiteUser;

interface UserRepositoryInterface
{
    public function getUserByEmail(string $email): User;
    public function createUserOrUpdate(array $userData): User;
    public function getUserOrCreate(SocialiteUser $userData): User;
    public function updateUserRole(int $user_id, string $role): void;
    public function getRoleByEmail(string $email): Role|null;
}
