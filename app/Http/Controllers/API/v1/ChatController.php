<?php

namespace App\Http\Controllers\API\v1;

use OneSignal;
use Carbon\Carbon;
use App\Models\AppUser;
use App\Models\Message;
use App\Models\ChatStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\Message as EventsMessage;

class ChatController extends Controller
{
    public function get($page)
    {
        $msg =  Message::select('messages.*', 'app_users.fullname as sender', 'app_users.image as uimage')->leftJoin('app_users', 'messages.from', '=', 'app_users.id')->with('reply')->orderBy('id', 'desc')->paginate(20, ['*'], 'page', $page);
        return $msg->getCollection();
    }
    public function status()
    {
        return response(ChatStatus::first('status'), 200);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'message' => 'required_without:image',
            'image' => 'required_without:message',
            'user_id' => 'required'
        ]);

        $img = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $destinationPath = 'images/chat';
            $req_image = 'image-' . sha1(time()) . "." . $image->getClientOriginalExtension();
            $img = $image->move($destinationPath, $req_image);
        }
        $replied_to_user = '';
        $replied_to_message = '';
        $message_data = "";
        $replied_to  = (!empty($request->replied)) ? $request->replied : null;
        $msg = Message::create([
            'from' =>  $request->user_id,
            'message' => $request->message,
            'attachment' => $img,
            'replied_to' => $replied_to,

        ]);

        if (!empty($request->replied)) {
            $message_data = Message::where('id', $request->replied)->first();
            $replied_to_user = $request->replied_to_name;
            $replied_to_message = $message_data->message;
        }
        $event = event(
            new EventsMessage(
                $request->name,
                (empty($request->message)) ? '' : $request->message,
                $request->user_id,
                (string)$img,
                (string)now()->toDateTimeString(),
                $msg->id,
                $replied_to_user,
                $replied_to_message,
            )
        );

        $users = AppUser::where('expiration', '>', Carbon::now())->whereNotNull('device_id')->get(['device_id']);
        foreach ($users as $u) {
            if ($u['device_id'] != "") {
                $ids[] = $u['device_id'];
            }
        }




        $this->sendSignal((empty($request->message)) ? '' : $request->message,
            $request->name,
            [
                'name' =>  $request->name,
                'msg' => $request->message,
                'id' => $request->user_id,
                'img' => (string)$img,
                'date' => (string)now()->toDateTimeString(),
                'msg_id' => $msg->id,
                'replied_to_user' => $replied_to_user,
                'replied_to_message' => $replied_to_message,
            ],
            $ids,
        );


        return response(['status' => 'success', 'event' => [
            'uname' => $request->name,
            'message' => $request->message,
            'user' => 'you',
            'file' => $img,
            'time' => now()->toDateTimeString(),
        ]], 200);
    }


    public function sendSignal($msg = "body", $headings = 'title', $d = array(), $userId = [])
    {


        $params = [];
        $params['include_player_ids'] = $userId;
        $contents = [
            "en" => $msg,
        ];
        $params['contents'] = $contents;
        $params['headings'] =  [
            "en" => $headings,
        ];
        $params['data'] =  $d;

        OneSignal::sendNotificationCustom($params);
    }
}
