<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = \App\Models\User::find(Auth::id());

        return view('profile.edit', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->name = $request->name;
        $user->postal_code = $request->postal_code;
        $user->address = $request->address;
        $user->building = $request->building;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        $user->save();

        Auth::setUser($user);

        if ($request->from === 'mypage') {
            return redirect()->route('mypage.index')->with('success', 'プロフィールを更新しました');
        }

        return redirect('/')->with('success', 'プロフィールを更新しました');
    }
}
