<?php

namespace App\Http\Controllers\Api;

use App\Models\Supplier;
use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Repositories\SupplierRepository;
use App\Services\SupplierService;
use Illuminate\Http\Request;

class ApiSupplierController extends ApiController {

    private $supplierService;
    private $supplierRepository;

    public function __construct(SupplierService $supplierService, SupplierRepository $supplierRepository) {
        $this->supplierService = $supplierService;
        $this->supplierRepository = $supplierRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $options = $request->query('options', []);
        $searchFields = ['name'];
        $suppliers = $this->supplierRepository->get($options, $searchFields);
        return $this->apiPaginateResponse($suppliers, SupplierResource::class);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request) {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier) {
        //
    }
}
