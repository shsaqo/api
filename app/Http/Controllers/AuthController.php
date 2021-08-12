<?php

namespace App\Http\Controllers;

use App\Http\Requests\AllUserRequest;
use App\Http\Requests\ChangePermissionRequest;
use App\Http\Requests\InvitationRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterAdminInvitationRequest;
use App\Http\Requests\UserChangeRequest;
use App\Http\Resources\GetResource;
use App\Http\Traits\ResponseJson;
use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return ResponseJson::response([], 422, 'Email or password is incorrect');
        }
        return ResponseJson::response(Auth::user()->createToken(Auth::user()->email)->accessToken);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        return ResponseJson::response();
    }

    public function changeUser(UserChangeRequest $request)
    {
        $user = auth()->user();

        if (isset($request->password)) {
            if (!Hash::check($request->current_password, $user->password)) {
                return ResponseJson::response([], 422, 'password is incorrect');
            }
            if ($user->id === 1) {
                $user->update($request->except('password') + ['password' => Hash::make($request->password)]);
            } else {
                $user->update($request->only('name') + ['password' => Hash::make($request->password)]);
            }
            return ResponseJson::response($user->createToken($user->email)->accessToken);

        } else {
            if ($user->id === 1) {
                $user->update($request->all());
            } else {
                $user->update($request->only('name'));
            }
            return ResponseJson::response($user);
        }
    }

    public function invitation(InvitationRequest $request)
    {
        $user = User::create($request->all() + ['password' => Hash::make('12Password21')]);
        Mail::to($user->email)->send(new SendMail($request));
        return new GetResource($user);
    }

    public function registerInvitation(Request $request)
    {
        if (User::where('email', $request->email)->count()) {
            return new GetResource([]);
        } else {
            return ResponseJson::response([], 400, 'Not found email');
        }
    }

    public function registerAdminInvitation(RegisterAdminInvitationRequest $request)
    {
        if (!$user = User::where('email', $request->email)->first()) return ResponseJson::response([], 400, 'User email not found');
        $user->update($request->except('email', 'password_confirmation', 'password') + ['password' => Hash::make($request->password), 'status' => 1]);
        return ResponseJson::response($user->createToken($user->email)->accessToken);
    }

    public function getAllUser(AllUserRequest $request)
    {
        return new GetResource(User::all());
    }

    public function changePermission(ChangePermissionRequest $request)
    {
        User::where('id', $request->id)->update($request->only('product_permission', 'special_permission', 'domain_permission', 'position'));
        return new GetResource([]);
    }

    public function deleteUser(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) return ResponseJson::response([], 400, 'User not found');
        $user->delete();
        return new GetResource([]);
    }


    public function userInfo()
    {
        return new GetResource(auth()->user());
    }
}
