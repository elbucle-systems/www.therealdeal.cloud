<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show', ['user' => Auth::user()]);
    }

    public function updateUsername(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:50', 'unique:users,username,'.$user->id],
        ]);

        $oldUsername = $user->username;
        $newUsername = $request->input('username');

        $user->username = $newUsername;
        $user->save();

        if ($oldUsername !== $newUsername) {
            DB::table('match_predictions')
                ->where('username', $oldUsername)
                ->update(['username' => $newUsername]);
        }

        return back()->with('success_username', __('app.flash.username_updated'));
    }

    public function updatePassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
        ]);

        if (! Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => __('app.flash.current_password_incorrect')])->withInput();
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        return back()->with('success_password', __('app.flash.password_updated'));
    }
}
