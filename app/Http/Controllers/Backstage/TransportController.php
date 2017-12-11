<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/10/26
 * Time: 下午11:03
 */

namespace App\Http\Controllers\Backstage;


use App\Models\ConsignResult;
use App\Models\Transport;
use App\User;
use App\Utility\OrderNoHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TransportController
{

    public function add(Request $request){
        $cr = new ConsignResult();

        $car_model = $request->input("car_model",'');
        $vin_no = $request->input("vin_no",'');
        $owner = $request->input("owner",'');
        $owner_phone = $request->input("owner_phone",'');
        $from = $request->input("from",'');
        $to = $request->input("to",'');
        $charge = $request->input("charge",'');
        $st_charge = $request->input("st_charge",0);
        $lt_charge = $request->input("lt_charge",0);
        $payment_method = $request->input("payment_method",'');
        $payment_status = $request->input("payment_status",'');
        $salesman_id = $request->input("salesman_id",'');
        $is_transfer = $request->input("is_transfer",false);
        $sendee_name = $request->input("sendee_name",'');
        $sendee_phone = $request->input("sendee_phone",'');

        $transport = new Transport();
        $transport->car_model = $car_model;
        $transport->vin_no = $vin_no;
        $transport->owner = $owner;
        $transport->owner_phone = $owner_phone;
        $transport->from = $from;
        $transport->to = $to;
        $transport->sendee_name = $sendee_name;
        $transport->sendee_phone = $sendee_phone;
        $transport->charge = $charge;
        $transport->payment_method = $payment_method;
        $transport->payment_status = $payment_status;
        $transport->salesman_id = $salesman_id;
        $transport->is_transfer = $is_transfer;
        $transport->order_id = OrderNoHelper::GetOrderNo();
        $transport->created_by = Auth::id();
        $transport->st_charge = $st_charge;
        $transport->lt_charge = $lt_charge;
        $transport->transport_status = 1;
        $transport->ordered_date = date("Y-m-d H:i:s",time());
        $transport->order_date = date("Y-m-d H:i:s",time());
        if ($transport->save()){
            $cr->status = 0;
            $cr->message = '添加成功';
            return $cr->toJson();
        }
        else{
            $cr->status = 1;
            $cr->message = '添加失败';
            return $cr->toJson();
        }
    }

    public function getLists(Request $request){
        $payment_status = $request->input('payment_status','');
        $vin_no = $request->input('vin_no','');


        if ($vin_no != ''){
            Log::info($vin_no);
            $transports = Transport::where('vin_no', $vin_no)->orderBy('id','desc')->paginate(10);
        }
        else if($payment_status != '' && $payment_status != '-1'){
            $transports = Transport::where('payment_status', $payment_status)->orderBy('id','desc')->paginate(10);
        }else{
            $transports = Transport::orderBy('id','desc')->paginate(10);
        }

        foreach ($transports as $transport){
            $transport->payment_status_desc = $transport->getPaymentStatus();
            $transport->payment_method_desc = $transport->getPaymentMethod();
        }
        return response()->json($transports);
    }

    public function get(Request $request){

        $id = $request->input('id', '');
        if ($id != ''){
            $transport = Transport::find($id);
            $transport->payment_status_desc = $transport->getPaymentStatus();
            $transport->payment_method_desc = $transport->getPaymentMethod();
            $user = User::find($transport->salesman_id);
            if ($user != null){
                $transport->salesmanName = $user->name;
            }
            else{
                $transport->salesmanName = 'unknown';
            }
            return response()->json($transport);
        }
    }

    public function payment(Request $request){
        $cr = new ConsignResult();
        $id = $request->input('id', '');
        if ($id != '') {
            $transport = Transport::find($id);
            $transport->payment_status = 1;
            if ($transport->save()){
                $cr->status = 0;
                $cr->message = '付款成功';
                return $cr->toJson();
            }
            else{
                $cr->status = 1;
                $cr->message = '付款失败,请稍后再试';
                return $cr->toJson();
            }
        }
    }

    public function updateCharge(Request $request){
        $cr = new ConsignResult();
        $id = $request->input('id', '');
        $newCharge = $request->input('new_charge','');
        if ($id != '') {
            $transport = Transport::find($id);
            $transport->charge = $newCharge;
            if ($transport->save()){
                $cr->status = 0;
                $cr->message = '修改成功';
                return $cr->toJson();
            }
            else{
                $cr->status = 1;
                $cr->message = '修改失败,请稍后再试';
                return $cr->toJson();
            }
        }
    }

    public function updateStCharge(Request $request){
        $cr = new ConsignResult();
        $id = $request->input('id', '');
        $newCharge = $request->input('new_charge','');
        if ($id != '') {
            $transport = Transport::find($id);
            $transport->st_charge = $newCharge;
            if ($transport->save()){
                $cr->status = 0;
                $cr->message = '修改成功';
                return $cr->toJson();
            }
            else{
                $cr->status = 1;
                $cr->message = '修改失败,请稍后再试';
                return $cr->toJson();
            }
        }
    }

    public function updateLtCharge(Request $request){
        $cr = new ConsignResult();
        $id = $request->input('id', '');
        $newCharge = $request->input('new_charge','');
        if ($id != '') {
            $transport = Transport::find($id);
            $transport->lt_charge = $newCharge;
            if ($transport->save()){
                $cr->status = 0;
                $cr->message = '修改成功';
                return $cr->toJson();
            }
            else{
                $cr->status = 1;
                $cr->message = '修改失败,请稍后再试';
                return $cr->toJson();
            }
        }
    }
}