<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    /**
     * Registering would create a user and return a token
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|max:55',
                'email' => 'email|required|unique:users',
                'password' => 'required|confirmed'
            ]);

            $validatedData['password'] = bcrypt($request->password);

            $user = User::create($validatedData);

            $accessToken = $user->createToken('authToken')->accessToken;

            return response(['user' => $user, 'access_token' => $accessToken]);
        } catch (ValidationException $exception) {
            return response(['message' => 'Validation Error: ' . $exception->getMessage()], 500);
        } catch (\Exception $errorException) {
            return response(['message' => 'Error detected'], 500);
        }

    }


    /**
     * Login would check user credentials and return a token if valid.
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        try {
            $loginData = $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            if (!auth()->attempt($loginData)) {
                return response(['message' => 'Invalid Credentials']);
            }


            $accessToken = auth()->user()->createToken('authToken')->accessToken;

            return response(['user' => auth()->user(), 'access_token' => $accessToken]);

        } catch (\Exception $errorException) {
            return response(['message' => 'Error detected'], 500);
        }
    }

    /**
     * getInfo would return basic info provided by the user when registered.
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getInfo(Request $request)
    {
        try {
            return response($request->user());
        } catch (\Exception $exception) {
            return response(['message' => 'Error detected.']);
        }
    }
}
