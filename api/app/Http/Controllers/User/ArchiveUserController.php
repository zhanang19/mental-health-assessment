<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\User;
use Illuminate\Http\Request;

class ArchiveUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserResource::collection(
            User::onlyTrashed()->get()
        );
    }

    /**
     * Restores the deleted resource from archive.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        if ( $user->restore() ) {
            return response()->json([
                'message' => 'A user has been restored.'
            ]);
        }
        
        abort(400, 'A user was not restored.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        if ( $user->forceDelete() ) {
            return response()->json([
                'message' => 'A user has been deleted permanently.'
            ]);
        }
        
        abort(400, 'A user was not deleted.');
    }
}
