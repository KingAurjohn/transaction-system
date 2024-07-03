<?php

namespace App\Http\Controllers;

use App\Models\pullout_save;
use App\Models\Transaction_info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PDO;

class AdminController extends Controller
{
    public function fetch_transactions(){

        $result = Transaction_info::all();
        return response()->json($result);
    }

    public function add_transaction(Request $request){
        $transaction = new Transaction_info();
        $transaction->FUND_cluster = $request->fund_cluster;
        $transaction->BUR_number = $request->bur_number;
        $transaction->Supplier = $request->suppliername;
        $transaction->Description = $request->description;
        $transaction->Amount = $request->amount;
        $transaction->Target_Delivery = $request->target_delivery;
        $transaction->Office = $request->office;
    
        if($transaction->save()){
            $id = $transaction->id;
            $po_number = "$request->fund_cluster-2024-$id";
            
            $transaction->PO_number = $po_number;
            $transaction->save();
    
            Session::put('success', 'Added Successfully');
            $success= Session::get('success');
            return redirect()->route('enter_admin')->with('success',$success);
        } else {
            Session::put('error', 'Added Failed');
            $error = Session::get('error');
            return redirect()->route('enter_admin')->with('error',$error);
        }
    }

    public function pullout(Request $request){
        $data = $request->json()->all();
        $id = $data['id'];
        
        $this_data = Transaction_info::where('id',$id)->first();
        
        $transaction = new pullout_save();
        $transaction->PO_number = $this_data->PO_number;
        $transaction->FUND_cluster = $this_data->FUND_cluster;
        $transaction->BUR_number = $this_data->BUR_number;
        $transaction->Supplier = $this_data->Supplier;
        $transaction->Description = $this_data->Description;
        $transaction->Amount = $this_data->Amount;
        $transaction->Target_Delivery = $this_data->Target_Delivery;
        $transaction->Office = $this_data->Office;
       
        if($transaction->save()){
            $result = Transaction_info::find($data['id'])->delete();
            if($result){
                return response()->json(['status'=>'successful']);
            }else{
                return response()->json(['status'=>'failed']);
            }
        }

    }
    
    public function fetch_pulledOut(){
        $result = pullout_save::all();
        return response()->json($result);
    }

    public function delete1(Request $request){
        $data = $request->json()->all();
        $result = Transaction_info::find($data['id'])->delete();
        if($result){
            return response()->json(['status'=>'successful']);
        }else{
            return response()->json(['status'=>'failed']);
        }
    }

    public function delete2(Request $request){
        $data = $request->json()->all();
        $result = pullout_save::find($data['id'])->delete();
        if($result){
            return response()->json(['status'=>'successful']);
        }else{
            return response()->json(['status'=>'failed']);
        }
    }
}
