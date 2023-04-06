<?php

namespace Isoros\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Isoros\Controllers\Controller;
use Isoros\models\User;
use function Isoros\Controllers\bcrypt;
use function Isoros\Controllers\response;

class UserController extends Controller
{
    /**
     * Get a user by their ID.
     *
     * @param int $id
     * @return Response
     */
    public function getUserById($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }
        return response()->json($user, 200);
    }

    /**
     * Create a new user.
     *
     * @param Request $request
     * @return Response
     */
    public function createUser(Request $request)
    {
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();
        return response()->json($user, 201);
    }

    /**
     * Update a user's information.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->input('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();
        return response()->json($user, 200);
    }

    /**
     * Delete a user by their ID.
     *
     * @param int $id
     * @return Response
     */
    public function deleteUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted.'], 200);
    }
}
