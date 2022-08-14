<?php

namespace App\Http\Controllers\Organizations\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organizations\Users\CreateOrganizationPermissionRequest;
use App\Http\Resources\OrganizationPermissionResource;
use App\Models\Organization;
use App\Services\Users\CreateUserPermissionService;
use Exception;

class Store extends Controller
{
    protected $createUserPermissionService;

    public function __construct(CreateUserPermissionService $createUserPermissionService)
    {
        $this->createUserPermissionService = $createUserPermissionService;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(CreateOrganizationPermissionRequest $request, Organization $organization)
    {
        try {
            $permission = $this->createUserPermissionService->handle($organization, $request->only(['email', 'admin', 'write', 'read']));

            return OrganizationPermissionResource::make($permission->load('user'));
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}
