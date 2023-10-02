<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 400);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 403);
            }

            $user = User::query()->where('email', $request->get('email'))->first();

            return response()->json([
                'success' => true,
                'data' => ['username' => $user->name],
                'message' => 'User Logged In Successfully',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function logout(): JsonResponse
    {
        try {
            Session::flush();
            $success = true;
            $message = 'Successfully logged out';
        } catch (QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        return response()->json(compact('success', 'message'));
    }

}
