<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\AppUser;
use App\Models\Fno;
use App\Models\Package;
use App\Models\Slider;
use App\Models\Video;
use App\Models\Workshop;
use App\Models\WorkshopRegistration;
use Illuminate\Http\Request;

class BasicController extends Controller
{

    // for slider
    public function slider()
    {
        return response(Slider::get(), 200);
    }


    // for videos
    public function Videos()
    {

        $videos = Video::get();

        foreach ($videos as $key => $video) {
            $video->workshops;
        }

        return response($videos, 200);
    }

    // for package
    public function packages()
    {
        return response(Package::get(), 200);
    }


    // for profile
    public function profile(Request $request)
    {
        $token  = $request->header();

        $token = explode(' ', implode('', $token['authorization']))[1];
        return  response(AppUser::select('app_users.*')->leftJoin('personal_access_tokens', 'personal_access_tokens.tokenable_id', '=', 'app_users.id')->where('personal_access_tokens.id', $token)->first(), 200);
    }



    // for registered workshop
    public function registered_workshop(Request $request)
    {
        $token  = $request->header();

        $token = explode(' ', implode('', $token['authorization']))[1];
        $user = AppUser::select('app_users.id')->leftJoin('personal_access_tokens', 'personal_access_tokens.tokenable_id', '=', 'app_users.id')->where('personal_access_tokens.id', $token)->first();
        return response(WorkshopRegistration::where('app_user_id', $user->id)->with('workshops.hosts')->get(), 200);


        // return  response(WorkshopRegistration::where('app_user_id', $user->id)->with(['workshops.hosts' => function ($query) {
        //     $query->whereIn('hosts.id', explode(',', 'workshops.host_id'));
        // }, 'users'])->get(), 200);

        // return  response(WorkshopRegistration::select('workshops.*')->leftJoin('personal_access_tokens', 'personal_access_tokens.tokenable_id', '=', 'workshop_registrations.app_user_id')->leftJoin('workshops', 'workshops.id', '=', 'workshop_registrations.workshop_id')->where('personal_access_tokens.id', $token)->get(), 200);


    }




    // for all workshop 
    public function workshops(Request $request, $id = null)
    {
        $token  = $request->header();
        $token = explode(' ', implode('', $token['authorization']))[1];
        $user = AppUser::select('app_users.id')->leftJoin('personal_access_tokens', 'personal_access_tokens.tokenable_id', '=', 'app_users.id')->where('personal_access_tokens.id', $token)->first();
        if (empty($id)) {
            $workshops = Workshop::with(['hosts', 'registration' => function ($query) use ($user) {
                $query->where('app_user_id', $user->id);
            }])->get();
        } else {
            $workshops = Workshop::where('id', $id)->with(['hosts', 'registration' => function ($query) use ($user) {
                $query->where('app_user_id', $user->id);
            }])->first();
        }



        return response($workshops, 200);
    }


    public function update_user(Request $request)
    {
        $token  = $request->header();
        $token = explode(' ', implode('', $token['authorization']))[1];
        $user = AppUser::select('app_users.id')->leftJoin('personal_access_tokens', 'personal_access_tokens.tokenable_id', '=', 'app_users.id')->where('personal_access_tokens.id', $token)->first();

        $user->fullname = $request->fullname;
        $user->location = $request->location;

        if (!empty($request->file('image'))) {
            $image = $request->file('image');
            $destinationPath = 'images/profile/user-uploads';
            $req_image = 'slider-' . sha1(time()) . "." . $image->getClientOriginalExtension();
            $img = $image->move($destinationPath, $req_image);

            $user->image = $img;
        }
        $user->contact = $request->email;
        $user->contact = $request->contact;
        $user->save();

        return response(['messages' => 'success'], 200);
    }

    public function registerWorkshop(Request $request)
    {
        $this->validate($request, [
            'u_id' => 'required|numeric',
            'w_id' => 'required|numeric',
            'form_data'  => 'required',
        ]);

        $workshop = Workshop::where('id', $request->w_id)->first();

        if ($workshop->price_type == '0') {
            WorkshopRegistration::create([
                'app_user_id' => $request->u_id,
                'workshop_id' => $request->w_id,
                'form_data'  => $request->form_data,
            ]);
            return response(['message' => 'Registered successfully'], 200);
        } else {
            return response(['error' => 'this workshop is not free'], 200);
        }
    }


    public function fno(Request $request)
    {
        $this->validate($request, [
            'start' => 'required',
            'end' => 'required',
        ]);
        $fno = Fno::whereBetween('created_at', [$request->start, $request->end])->get(['title', 'amount', 'json', 'image', 'file', 'type', 'created_at', 'updated_at']);

        return response($fno, 200);
    }


    public function wallet(Request $request)
    {
    }


    public function workshop_free(Request $request)
    {
    }
}
