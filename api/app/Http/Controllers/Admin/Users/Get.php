<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Queries\Users\UserQuery;
use Illuminate\Http\Request;

class Get extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, UserQuery $userQuery)
    {
        $isActive = $request->has('is_active') ? $request->boolean('is_active') : null;
        $email = $request->query('email');

        $users = $userQuery->email($email)->isActive($isActive)->get();

        return UserResource::collection($users);
    }
}
