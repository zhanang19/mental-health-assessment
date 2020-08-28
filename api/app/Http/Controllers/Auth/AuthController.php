<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignUpRequest;
use App\Repository\UserRepositoryInterface;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function register(SignUpRequest $request)
    {
        $user = $request->persist();

        return response()->json([
            'data' => $user,
            'message' => 'You have successfully registered an account with us!'
        ], 201);
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        validator(request()->all(), [
            'email' => 'sometimes|required|string|email',
            'username' => 'sometimes|required|string',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ])->validate();

        $credentials = request(['email', 'password']);

        if (request()->has('username')) {
            $user = User::whereUsername(
                request()->get('username')
            )->first();
            $credentials = [
                'email' => $user->email,
                'password' => request()->get('password')
            ];
        }

        if(!auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized.'
            ], 401);
        }

        // check if user is active
        // if not active then don't authenticate
        else {
            $user = auth()->user();

            if (! $user->is_active) {
                abort(403, "Your account is suspended.");
            }
        }

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out.'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user()
    {
        return response()->json(auth()->user());
    }

    /**
     * Update user's information.
     *
     * @return \Illimuniate\Http\Response
     */
    public function update()
    {
        // return response()->json(request('avatar'));

        validator(request()->all(),
        [
            'username' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email,'.auth()->user()->id,
            'time_zone' => 'required',
            'password' => 'sometimes|confirmed|min:8'
        ],
        [],
        [
            'first_name' => 'first name',
            'last_name' => 'last name',
            'time_zone' => 'time zone',
        ])->validate();

        auth()->user()->update(
            request([
                'username',
                'first_name',
                'middle_name',
                'last_name',
                'email',
                'time_zone',
                'password',
            ])
        );

        if (auth()->user()->avatar != request('avatar') && request()->has('avatar')) {
            auth()->user()->clearMediaCollection('avatar');
            auth()->user()->addMediaFromBase64(
                request()->get('avatar')
            )->toMediaCollection('avatar');
        }

        return response()->json([
            'message' => 'Your profile has been updated.'
        ]);
    }

    /**
     * Update user password.
     *
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|string|confirmed'
        ]);

        auth()->user()->update([
            'password' => $request->input('password'),
        ]);

        return response()->json([
            'message' => 'Your password has been updated.'
        ], 200);
    }

    /**
     * Checks if user's account is active.
     *
     * @return bool
     */
    private function isActive($email)
    {
        return User::whereEmail($email)->first()
            ? User::whereEmail($email)->first()->is_active
            : false;
    }
}
