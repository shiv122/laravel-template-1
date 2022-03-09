<?php

namespace App\Http\Controllers\API\v1;

use Carbon\Carbon;
use App\Models\Order;
use Razorpay\Api\Api;
use App\Models\AppUser;
use App\Models\Package;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\WorkshopTransaction;
use App\Http\Controllers\Controller;
use App\Models\WorkshopRegistration;
use App\Models\SubscriptionTransaction;

class PaymentController extends Controller
{
    public function gen_order(Request $request)
    {
        $workshop = null;
        $package = null;


        // return $request;
        $this->validate($request, [
            'name' => 'required|string',
            'mobileno' => 'required|numeric',
            'totalamount' => 'required|numeric',
            'type' => 'required|string',
            'used_wallet_amount' => 'required',
            'user_id' => 'required',
            // 'form_data' => 'required:required_without:package',
            'package' => 'required_without:workshop',
            'workshop' => 'required_without:package',

        ]);

        if ($request->type == 'workshop') {
            $workshop = Workshop::find($request->workshop);
        } else {
            // aka subscription
            $package = Package::find($request->package);
        }


        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $orderData = [
            'receipt'         => $request->mobileno,
            'amount'          => $request->totalamount * 100, //  rupees in paise
            'currency'        => 'INR',
            'payment_capture' => 1, // auto capture
            'notes'        => [
                "name"           => "$request->name",
                "mobile" => "$request->mobileno"
            ]

        ];

        $razorpayOrder = $api->order->create($orderData);
        $razorpayOrderId = $razorpayOrder['id'];

        Order::create([
            'order_id' => $razorpayOrderId,
            'type' => $request->type,
            'app_user_id' => $request->user_id,
            'workshop' => $workshop,
            'package' => $package,
            'wallet_used' => $request->used_wallet_amount,
            'form_data' => $request->form_data,
        ]);



        return response(['order_id' => $razorpayOrderId], 200);
    }

    public function fetch(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));



        $payment = $api->order->fetch($request->order_id);
        $tr_id = '';
        if ($payment->status == 'paid') {
            $order = Order::where('order_id', $request->order_id)->first();
            $transaction = $api->order->fetch($request->order_id)->payments()->toArray();
            foreach ($transaction['items'] as $key => $value) {
                if ($value['captured']) {
                    $tr_id = $value['id'];
                    break;
                }
            }
            if ($order->status == 'created') {
                if ($order->type == 'workshop') {
                    $workshop = json_decode($order->workshop, true)['id'];
                    WorkshopRegistration::create([
                        'app_user_id' => $order->app_user_id,
                        'workshop_id' => $workshop,
                        'form_data' => $order->form_data,
                    ]);
                    WorkshopTransaction::create([

                        'workshop' => $order->workshop,
                        'app_user_id' => $order->app_user_id,
                        'transaction_id' => $tr_id,
                        'order_id' => $order->id,
                    ]);
                    if ($order->wallet_used > 0) {
                        AppUser::where('id', $order->app_user_id)->decrement('wallet', $order->wallet_used);
                    }
                } else {

                    $pack = json_decode($order->package, true);

                    $exp = Carbon::now()->addDays($pack['duration']);

                    SubscriptionTransaction::create([
                        'app_user_id' => $order->app_user_id,
                        'transaction_id' => $tr_id,
                        'package' => $order->package,
                        'order_id' => $order->id,
                    ]);

                    AppUser::where('id', $order->app_user_id)->update([
                        'package' => $order->package,
                        'expiration' => $exp,
                        'wallet' => DB::raw("wallet-$order->wallet_used")
                    ]);
                }
                $order->status = 'inserted';
                $order->save();
                return response(['message' => 'Payment Successful'], 200);
            } else {
                return response(['message' => 'Already Processed'], 200);
            }
        } else {
            $order =  Order::where('order_id', $request->order_id)->first();
            $order->status = 'failed';
            $order->save();
            return response(['status' => 'failed'], 200);
        }
    }
}
