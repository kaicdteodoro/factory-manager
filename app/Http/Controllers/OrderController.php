<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\DataTableRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    private OrderService $service;

    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    public function orders(DataTableRequest $request): JsonResponse
    {
        try {
            $response = $this->service->orders($request->safe()->only(['page', 'perPage']));
            return response()->json([
                'success' => true,
                'data' => $response,
                'message' => 'Orders Sent Successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function chartMonth(): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $this->service->chartMonth(),
                'message' => 'Chart by Month Sent Successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function status(): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $this->service->status(),
                'message' => 'Orders Sent Successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function numbers(): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $this->service->numbers(),
                'message' => 'Orders Sent Successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function create(Request $request): JsonResponse
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'sample_id' => 'required|int',
                    'order_status_id' => 'required|int',
                    'observation' => 'string',
                    'quantities' => 'required|array'
                ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 400);
            }

            return response()->json([
                'success' => true,
                'data' => $this->service->create($request->only(['sample_id', 'order_status_id', 'observation']), $request->get('quantities')),
                'message' => 'Order Created Successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function update(int $id, Request $request): JsonResponse
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'sample_id' => 'required|int',
                    'order_status_id' => 'required|int',
                    'observation' => 'nullable|string',
                    'quantities' => 'required|array'
                ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 400);
            }

            return response()->json([
                'success' => true,
                'data' => $this->service->update($id, $request->only(['sample_id', 'order_status_id', 'observation']), $request->get('quantities')),
                'message' => 'Order Updated Successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $this->service->delete($id),
                'message' => 'Order Deleted Successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
