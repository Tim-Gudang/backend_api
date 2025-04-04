<?php

namespace App\Http\Controllers;

use App\Http\Requests\SatuanRequest;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SatuanController extends Controller
{
    public static function middleware(): array
    {
        return [
            'auth:api',
            new Middleware('permission:view_satuan', only: ['index', 'show']),
            new Middleware('permission:create_satuan', only: ['store']),
            new Middleware('permission:update_satuan', only: ['update']),
            new Middleware('permission:delete_satuan', only: ['destroy']),
        ];
    }
    protected $unitService;

    public function __construct(UnitService $unitService)
    {
        $this->unitService = $unitService;
    }

    public function index()
    {
        $units = $this->unitService->getAllUnits();
        return UnitResource::collection($units);
    }

    public function store(SatuanRequest $request)
    {
        $unit = $this->unitService->createUnit($request->validated());
        return new UnitResource($unit);
    }

    public function show($id)
    {
        $unit = $this->unitService->getUnitById($id);
        return new UnitResource($unit);
    }

    public function update(SatuanRequest $request, $id)
    {
        $unit = $this->unitService->updateUnit($id, $request->validated());
        return new UnitResource($unit);
    }

    public function destroy($id)
    {
        $this->unitService->deleteUnit($id);
        return response()->json(['message' => 'Unit deleted successfully'], 200);
    }

    public function restore($id)
    {
        $unit = $this->unitService->restoreUnit($id);
        return new UnitResource($unit);
    }

    public function forceDelete($id)
    {
        $this->unitService->forceDeleteUnit($id);
        return response()->json(['message' => 'Unit permanently deleted'], 200);
    }
}
