<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Repository\Eloquent\UserRepository;
use App\Repository\UserRepositoryInterface;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserResource::collection(
            $this->userRepository->all()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        validator(request()->all(),
            [
                'daycare_id' => 'required',
                'username' => 'required',
                'role' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users',
                'time_zone' => 'required',
                'password' => 'required|confirmed|min:8',
            ],
            [
                'daycare_id' => 'daycare',
                'first_name' => 'first name',
                'last_name' => 'last name',
                'middle_name' => 'middle name',
                'time_zone' => 'time zone',
            ])->validate();

        $user = User::create(
            $request->only([
                'daycare_id',
                'username',
                'first_name',
                'last_name',
                'middle_name',
                'email',
                'time_zone',
                'password',
            ])
        );

        $user->assignRole($request->get('role'));

        // avatar
        if (isNotEmpty($request->get('avatar'))) {
            $user->addMediaFromBase64(
                $request->get('avatar')
            )->toMediaCollection('avatar');
        }

        return response()->json([
            'message' => 'A user has been created.'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new UserResource(User::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrfail($id);

        $user->fill([
            'daycare_id' => $request->get('daycare_id'),
            'username' => $request->get('username'),
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'middle_name' => $request->get('middle_name'),
            'email' => $request->get('email'),
            'time_zone' => $request->get('time_zone'),
        ]);

        if ($request->has('role')
            && $request->get('role') != 'None') {
            $user->syncRoles($request->get('role'));
        }

        if ($request->has('password')) {
            $user->fill([
                'password' => bcrypt($request->get('password')),
            ]);
        }

        // avatar
        if ($request->hasFile('avatar')
            && $request->file('avatar')->isValid()
        ) {
            $user->addMedia(
                $request->file('avatar')
            )->toMediaCollection('avatar');
        }

        if (! $user->saveOrFail()) {
            abort(401, 'The system was not able to update the user.');
        }

        return response()->json([
            'message' => 'A user has been updated.'
        ], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->id == auth()->user()->id) {
            abort(403, "You cannot delete yourself.");
        }

        if ($user->delete()) {
            return response()->json([
                'message' => 'A user was deleted.'
            ]);
        }

        return response()->json([
            'message' => 'A user was not deleted.'
        ]);
    }
}
