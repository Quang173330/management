<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrganizationResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\UserResource;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MergeValue;

class WebInit extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResource
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();

        return JsonResource::make([
            $this->authUserData($user),
            'config' => config('web'),
            'messages' => session()->pull('messages', []),
            'extras' => session()->pull('extras', (object) []),
        ]);
    }

    protected function authUserData(?User $user)
    {
        if (!$user) {
            return new MergeValue([
                'user' => null,
            ]);
        }

        return new MergeValue([
            'user' => UserResource::make($user),
            'organization' => OrganizationResource::make($user->organizations()->first()),
            'projects' => ProjectResource::collection($user->projects),
        ]);
    }
}
