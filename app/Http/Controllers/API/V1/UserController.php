<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function profileStatus(Request $request)
    {

    $user = $request->user();

    return response()->json([
        'profile_complete' => $user->isProfileComplete(),
        'message' => $user->isProfileComplete() 
            ? '✅ Donor profile already exists.'
            : '⛔ Please complete donor profile.',
        'user' => $user
    ]);

    }
}
