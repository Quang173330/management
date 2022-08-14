<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class Update extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, User $user)
    {
        abort_if($request->user()->id === $user->id && !$request->input('is_admin'), 403, 'You can not change your permission');

        $data = $request->only(['name', 'is_active', 'is_admin']);
        $user->update($data);

        return UserResource::make($user);
    }
}
