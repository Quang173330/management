<?php

namespace App\Http\Controllers\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrganizationResource;
use App\Models\Organization;
use Illuminate\Http\Request;

class Store extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = array_merge($request->only(['name', 'description']), [
            'user_id' => $request->user()->id
        ]);
        
        $organization = Organization::create($data);

        return OrganizationResource::make($organization);
    }
}
