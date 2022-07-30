<?php

namespace App\Services\Users;

use App\Models\User;

class CreateUserPermissionService
{
    public function handle($model, array $permissions)
    {
        $user = User::where('email', $permissions['email'])->first();

        if (!$user) {
            $user = User::create(['email' => $permissions['email'], 'is_active' => false]);
        }

        $modelPermission = $model->permissions()->where('user_id', $user->id)->first();

        return $modelPermission ?? $this->createUserPermission($model, $user, $permissions);
    }

    protected function createUserPermission($model, User $user, array $permissions)
    {
        return $model->permissions()->create([
            'user_id' => $user->id,
            'admin' => $permissions['admin'],
            'write' => $permissions['admin'] || $permissions['write'],
            'read' => $permissions['admin'] || $permissions['write'] || $permissions['read'],
        ]);
    }
}
