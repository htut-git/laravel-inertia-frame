<?php
namespace App\Helpers;

use App\Models\User;

if (!function_exists('userCan()')) {
    function userCan(string $permission):bool {
        /** @var User $user */
        $user = auth()->user();
        return $user->can($permission);
    }
}

if (!function_exists('userHasRole()')) {
    function userHasRole(string $role):bool {
        /** @var User $user */
        $user = auth()->user();
        return $user->hasRole($role);
    }
}
