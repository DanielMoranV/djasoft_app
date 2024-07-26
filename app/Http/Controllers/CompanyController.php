<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseHelper;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Interfaces\CompanyRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    private CompanyRepositoryInterface $companyRepositoryInterface;

    public function __construct(CompanyRepositoryInterface $companyRepositoryInterface)
    {
        $this->companyRepositoryInterface = $companyRepositoryInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->companyRepositoryInterface->getAll();
        return ApiResponseHelper::sendResponse(CompanyResource::collection($data), '', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = $this->companyRepositoryInterface->getById($id);
        return ApiResponseHelper::sendResponse(new CompanyResource($company), '', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        $data =
            [
                'id' => $request->id,
                'company_name' => $request->companyName,
                'ruc' => $request->ruc,
                'address' => $request->address,
                'email' => $request->email,
                'phone' => $request->phone,
                'status' => $request->status,
                'logo_path' => $request->logoPath,
                'sol_user' => $request->solUser,
                'sol_pass' => $request->solPass,
                'cert_path' => $request->certPath,
                'client_id' => $request->clienteId,
                'client_secret' => $request->clientSecret,
                'production' => $request->production,
            ];
        DB::beginTransaction();
        try {
            $company = $this->companyRepositoryInterface->store($data);
            DB::commit();
            return ApiResponseHelper::sendResponse(new CompanyResource($company), 'Record create succesful', 201);
        } catch (\Exception $ex) {
            DB::rollBack();
            return ApiResponseHelper::rollback($ex);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCompanyRequest $request, string $id)
    {
        $data =
            [
                'id' => $request->id,
                'company_name' => $request->companyName,
                'ruc' => $request->ruc,
                'address' => $request->address,
                'email' => $request->email,
                'phone' => $request->phone,
                'status' => $request->status,
                'logo_path' => $request->logoPath,
                'sol_user' => $request->solUser,
                'sol_pass' => $request->solPass,
                'cert_path' => $request->certPath,
                'client_id' => $request->clienteId,
                'client_secret' => $request->clientSecret,
                'production' => $request->production,
            ];
        DB::beginTransaction();
        try {
            $this->companyRepositoryInterface->update($data, $id);
            DB::commit();
            return ApiResponseHelper::sendResponse(null, 'Record updated succesful', 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return ApiResponseHelper::rollback($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->companyRepositoryInterface->delete($id);
        return ApiResponseHelper::sendResponse(null, 'Record deleted succesful', 200);
    }
}
