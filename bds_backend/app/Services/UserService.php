<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function findbyID(int $id): ?User
    {
        return User::find($id);
    }

    public function update(int $id, array $data): bool
    {
        $user = User::find($id);
        return $user ? $user->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $user = User::find($id);
        return $user ? $user->delete() : false;
    }

    /**
     * Authenticate a user by email and password.
     */
    public function login(string $email, string $password): ?User
    {
        $user = User::where('email', $email)->first();

        if ($user && $user->verifyPassword($password)) {
            return $user;
        }

        return null;
    }

    /**
     * Register a new user with hashed password.
     */
    public function register(array $data): User
    {
        $user = new User($data);
        $user->setPassword($data['password']);
        $user->save();

        return $user;
    }
}
