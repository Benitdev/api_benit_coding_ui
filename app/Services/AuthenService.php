<?php


namespace App\Services;


use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class AuthenService
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    function register($request)
    {
        try {
            $request['password'] = bcrypt($request['password']);
            $this->user::create($request);

            return true;
        } catch (Exception $e) {
            Log::error($e);

            return false;
        }
    }
}
