<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseHelper;
use App\Http\Resources\UnitResource;
use App\Interfaces\UnitRepositoryInterface;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    private UnitRepositoryInterface $unitRepositoryInterface;

    public function __construct(UnitRepositoryInterface $unitRepositoryInterface)
    {
        $this->unitRepositoryInterface = $unitRepositoryInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->unitRepositoryInterface->getAll();
        return ApiResponseHelper::sendResponse(UnitResource::collection($data), '', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $unit = $this->unitRepositoryInterface->getById($id);
        return ApiResponseHelper::sendResponse(new UnitResource($unit), '', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
