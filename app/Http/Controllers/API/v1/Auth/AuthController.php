<?php

namespace App\Http\Controllers\API\v1\Auth;

use Auth;
use App\Models\User;
use App\Models\AppUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $this->validate(
            $request,
            [
                'email' => 'required_without:phone',
                'phone' => 'required_without:email'
            ]
        );


        $coupon = File::get(storage_path('app\public\coupons.txt'));

        $contents = explode(',', $coupon);




        if (!empty($request->email)) {
            $user = AppUser::where('email', $request->email)->first();
            if ($user) {
                AppUser::where('email', $request->email)->update([
                    'device_id' => $request->device_id,
                ]);
            }
        }
        if (!empty($request->phone)) {
            $user = AppUser::where('contact', $request->phone)->first();
            if ($user) {
                AppUser::where('contact', $request->phone)->update([
                    'device_id' => $request->device_id,
                ]);
            }
        }

        if ($user) {

            return response(['user' => $user, 'token' => $user->createToken('app-user')->plainTextToken, 'type' => 'old']);
        } else {
            $referred_by = null;
            if (!empty($request->email)) {

                if (!empty($request->referred_by)) {
                    $referred_by = AppUser::where('referral_code', $request->referred_by)->first(['id']);
                }

                $user =   AppUser::create([
                    'email' => $request->email,
                    'name' => $request->name,
                    'referred_by' => $referred_by,
                    'device_id' => $request->device_id,
                    'referral_code' => strtoupper($contents[0]),
                    'image' => 'images/profile/placeholder.jpg',
                ]);
            } else {

                if (!empty($request->referred_by)) {
                    $referred_by = AppUser::where('referral_code', $request->referred_by)->first(['id']);
                }

                $user = AppUser::create([
                    'contact' => $request->phone,
                    'name' => $request->name,
                    'device_id' => $request->device_id,
                    'referred_by' => $referred_by,
                    'referral_code' => strtoupper($contents[0]),
                    'image' => 'images/profile/placeholder.jpg',
                ]);
            }

            unset($contents[0]);
            file_put_contents(storage_path('app\public\coupons.txt'), implode(',', array_unique($contents)));
            return response(['user' => $user, 'token' => $user->createToken('app-user')->plainTextToken, 'type' => 'new']); // Auth::login($user);
        }
    }
}
