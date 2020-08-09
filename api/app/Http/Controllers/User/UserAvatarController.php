<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserAvatarController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        // return response()->json($request);
        
        $request->validate([
            'avatar' => 'max:2048'
        ]);

        if ($request->hasFile('avatar') 
            && $request->file('avatar')->isValid()
        ) {
            $user = User::findOrFail($id);
            $user->clearMediaCollection('avatar');
            $user->addMedia(
                $request->file('avatar')
            )->toMediaCollection('avatar');
            
            return response()->json([
                'message' => 'Updated user\'s avatar.'
            ]);
        }
    }
}
