<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //    
    /**
     * register
     *
     * @param  mixed $request
     * @return void
     */
    public function register(RegisterRequest $request)
    {
        try {
            $validate = $request->validated();
            $user = User::create($validate);
            return ApiResponse::success(["user" => ["name" => $user->name, "email" => $user->email, "created_at" => $user->created_at]]);
        } catch (\Throwable $th) {
            return ApiResponse::error($th);
        }
    }

    /**
     * login
     *
     * @param  mixed $request
     * @return void
     */
    public function login(LoginRequest $request)
    {
        try {
            $validate = $request->validated();
            if (Auth::attempt($validate)) {
                /** @var \App\Models\User */
                $user = Auth::user();
                $token = $user->createToken(env('SECRET'))->accessToken;
                return ApiResponse::success($token);
            }
            // if
        } catch (\Throwable $th) {
            return ApiResponse::error($th);
        }
    }
}
