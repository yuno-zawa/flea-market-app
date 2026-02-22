<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {

  dd([
            'intended' => session()->get('url.intended'),
            'previous' => url()->previous(),
        ]);

        //return redirect()->intended(config('fortify.home'));
    }
}