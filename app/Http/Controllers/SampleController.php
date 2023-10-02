<?php

namespace App\Http\Controllers;

use App\Services\SampleService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\DataTableRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SampleController extends Controller
{

    private SampleService $service;

    public function __construct(SampleService $service)
    {
        $this->service = $service;
    }

    public function samples(DataTableRequest $request): JsonResponse
    {
        try {
            $response = $this->service->samples($request->safe()->only(['page', 'perPage']));
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

    public function values(): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $this->service->values(),
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
                    'code' => 'required|string',
                    'name' => 'required|string',
                    'value' => 'required|numeric'
                ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            return response()->json([
                'success' => true,
                'data' => $this->service->create($request->only(['code', 'name', 'value'])),
                'message' => 'Sample Created Successfully',
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
                    'code' => 'required|string',
                    'name' => 'required|string',
                    'value' => 'required|numeric'
                ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            return response()->json([
                'success' => true,
                'data' => $this->service->update($id, $request->only(['code', 'name', 'value'])),
                'message' => 'Sample Updated Successfully',
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
                'message' => 'Sample Deleted Successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
