<?php

namespace App\Http\Controllers;

use App\Contracts\CustomerServiceContract;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function __construct(private CustomerServiceContract $customerService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->customerService->getAllCustomers());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        return response()->json($this->customerService->createCustomer($request->validated()), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return response()->json($customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        return response()->json($this->customerService->updateCustomer($customer, $request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        return response()->json($this->customerService->deleteCustomer($customer), 204);
    }
}
