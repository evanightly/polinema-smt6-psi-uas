<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use App\Http\Requests\Transaction\StoreTransactionRequest;
use App\Http\Requests\Transaction\UpdateTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Repositories\TransactionRepository;
use App\Services\TransactionService;

class ApiTransactionController extends ApiController {

    private $transactionService;
    private $transactionRepository;

    public function __construct(TransactionService $transactionService, TransactionRepository $transactionRepository) {
        $this->transactionService = $transactionService;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        $options = request()->query('options', []);
        $searchFields = ['buyer_name', 'price_total', 'user.name'];
        $relations = ['products', 'user'];
        $transactions = $this->transactionRepository->get($options, $searchFields, $relations);
        return $this->apiPaginateResponse($transactions, TransactionResource::class);
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
    public function store(StoreTransactionRequest $request) {
        $transaction = $this->transactionService->create($request->validated());
        return $this->apiPaginateResponse($transaction, TransactionResource::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction) {
        $this->transactionService->delete($transaction);
        return response()->noContent();
    }
}
