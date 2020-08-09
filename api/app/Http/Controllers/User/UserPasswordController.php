<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserPasswordRequest;
use App\User;
use Illuminate\Http\Request;

class UserPasswordController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserPasswordRequest $request, int $id)
    {
        $user = User::findOrFail($id)
            ->fill([
                'password' => bcrypt($request->password),
            ]);

        if ($user->save()) {
            return response()->json([
                'message' => 'Updated user\'s password.'
            ]);
        }

        abort(403, 'Cannot update user\'s password.');
    }
}
