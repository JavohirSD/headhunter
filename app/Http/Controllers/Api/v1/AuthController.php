<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Create a new user
     *
     * @param UserRegisterRequest $request
     *
     * @return JsonResponse
     */
    public function signup(UserRegisterRequest $request): JsonResponse
    {
        $user  = User::create($request->all());
        $token = $user->createToken(uniqid(true) . time())->plainTextToken;

        return $this->success(['user' => $user, 'token' => $token], 'Created', Response::HTTP_CREATED);
    }


    /**
     * Login user
     *
     * @param LoginRequest $request
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        // Check login existance
        $user = User::where('username', $request->input('username'))->first();

        // Check password matching
        if (!$user || !Hash::check($request->input('password'), $user->getAuthPassword())) {
            return $this->success([], 'Bad credentials', Response::HTTP_FORBIDDEN);
        }

        $token = $user->createToken(uniqid(true) . time())->plainTextToken;

        return $this->success(['user' => $user, 'token' => $token], 'Logged in');
    }

}
