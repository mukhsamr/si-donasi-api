<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\HasTryCatch;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use HasTryCatch;

    public function index(Request $request)
    {
        return new UserResource($request->user());
    }

    public function update(Request $request)
    {
        $request->merge(['password' => bcrypt($request->password)]);

        $message = $this::execute(
            try: fn () => User::where('id', $request->id)
                ->update($request->only(['name', 'password'])),
            message: 'edit user'
        );

        return $message;
    }
}
