<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseHelper;
use App\Http\Requests\DeleteRoleRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function assignRole(Request $request)
    {
        $request->validate([
            'dni' => 'required|exists:users,dni',
            'role_name' => 'required|string|exists:roles,name'
        ]);

        try {
            $user = $this->userRepository->findByDni($request->dni);
            $role = Role::where('name', $request->role_name)->firstOrFail();
            $user->assignRole($role);

            return ApiResponseHelper::sendResponse(['message' => 'Role assigned successfully']);
        } catch (\Exception $e) {
            return ApiResponseHelper::rollback($e);
        }
    }

    public function removeRole(Request $request)
    {
        $request->validate([
            'dni' => 'required|exists:users,dni',
            'role_name' => 'required|string|exists:roles,name'
        ]);

        try {
            $user = $this->userRepository->findByDni($request->dni);
            $role = Role::where('name', $request->role_name)->firstOrFail();
            $user->removeRole($role);

            return ApiResponseHelper::sendResponse(['message' => 'Role removed successfully']);
        } catch (\Exception $e) {
            return ApiResponseHelper::rollback($e);
        }
    }

    public function getRoles()
    {
        try {
            $roles = Role::all();
            return ApiResponseHelper::sendResponse($roles);
        } catch (\Exception $e) {
            return ApiResponseHelper::rollback($e);
        }
    }

    public function store(StoreRoleRequest $request)
    {
        try {
            $role = Role::create($request->validated());
            return ApiResponseHelper::sendResponse($role, 'Role created successfully', 201);
        } catch (\Exception $e) {
            return ApiResponseHelper::rollback($e);
        }
    }

    public function update(UpdateRoleRequest $request, $name)
    {
        try {
            // Buscar el rol por nombre en lugar de ID
            $role = Role::where('name', $name)->firstOrFail();
            // Actualizar el rol con los datos validados
            $role->update($request->validated());

            return ApiResponseHelper::sendResponse($role, 'Role updated successfully');
        } catch (\Exception $e) {
            return ApiResponseHelper::rollback($e);
        }
    }

    public function destroy(DeleteRoleRequest $request)
    {
        try {
            $role = Role::where('name', $request->name)->firstOrFail();
            $role->delete();

            return ApiResponseHelper::sendResponse(['message' => 'Role deleted successfully'], '', 204);
        } catch (\Exception $e) {
            return ApiResponseHelper::rollback($e);
        }
    }
}