<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;


class CustomerController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $q = $request->query('q');
        $perPage = (int) $request->query('per_page', 10);

        $query = Customer::query();

        if ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('client_name', 'like', "%{$q}%")
                    ->orWhere('supplier', 'like', "%{$q}%")
                    ->orWhere('retailer', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        $data = $query->orderBy('id', 'desc')->paginate($perPage);

        return response()->json($data);
    }

    /**
     * Store a newly created customer.
     */
    public function store(StoreCustomerRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $customer = Customer::create($validated);

        return response()->json([
            'message' => 'Customer created successfully.',
            'data' => $customer,
        ], 201);
    }

    /**
     * Display the specified customer.
     * findOrFail will throw ModelNotFoundException -> 404 response.
     */
    public function show($id): JsonResponse
    {
        $customer = Customer::findOrFail($id);

        return response()->json($customer);
    }

    /**
     * Update the specified customer.
     */
    public function update(UpdateCustomerRequest $request, $id): JsonResponse
    {
        $customer = Customer::findOrFail($id);

        $customer->update($request->validated());

        return response()->json([
            'message' => 'Customer updated successfully.',
            'data' => $customer,
        ]);
    }

    /**
     * Remove the specified customer.
     */
    public function destroy($id): JsonResponse
    {
        $customer = Customer::findOrFail($id);

        $customer->delete();

        return response()->json([
            'message' => 'Customer deleted successfully.'
        ]);
    }
}
