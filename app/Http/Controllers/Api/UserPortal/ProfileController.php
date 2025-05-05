<?php

namespace App\Http\Controllers\Api\UserPortal;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserPortal\ProfileResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile()
    {
        $auth_user =  Auth::guard('users_api')->user();
        return ResponseService::success(new ProfileResource($auth_user));
    }
}
