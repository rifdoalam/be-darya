<?php

namespace App\Http\Controllers;
use App\Models\RequestObat;
use Illuminate\Http\Request;

use Illuminate\Validation\ValidationException;

use App\Models\Obat;

class RequestObatController extends Controller
{
    public function requestObatAction(Request $request){

        try {
            $validated = $request->validate([
                'obat_id' => 'required',
                'quantity' => 'required',
            ]);
            $findObat = Obat::find($request->obat_id);
            if (!$findObat) {
                return response()->json([
                    'message' => 'Obat not found',
                ]);
            }
            if($findObat->stock < $request->quantity){
               return response()->json([
                   'message' => 'Stock obat tidak mencukupi',
               ]);
            }
            $requestCreate = RequestObat::create([
                'obat_id' => $request->obat_id,
                'quantity' => $request->quantity,
                'user_id' => auth()->user()->id,
                'status' => 'pending',
                'request_date' => now()
            ]);
            return response()->json([
                'message' => 'Request Obat created successfully',
                'data' => $requestCreate
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }   
    public function responseAdmin(Request $request,$id){
        try {
            $validated = $request->validate([
                'status' => 'required',
            ]);
            $findRequest = RequestObat::find($id);
            if (!$findRequest) {
                return response()->json([
                    'message' => 'Request not found',
                ]);
            }
            if($findRequest->status != "pending"){
                return response()->json([
                    'message' => 'Status not pending', 
                ]);
            }
            $findRequest->status =  $request->status;
            $findRequest->save();
            $findObat = Obat::find($findRequest->obat_id);
            $findObat->stock = $findObat->stock - $findRequest->quantity;
            $findObat->save();
            return response()->json([
                'message' => 'Request Obat updated successfully',
                'data' => $findRequest
            ]);
        }catch (\Throwable $th) {
            throw $th;
        }
    }
    public function responseDistributor(Request $request,$id){
        try {

            $findRequest = RequestObat::find($id);
            if (!$findRequest) {
                return response()->json([
                    'message' => 'Request not found',
                ]);
            }
            if($findRequest->status == "rejected" || $findRequest->status == "pending") {
                return response()->json([
                    'message' => 'Status not approved Admin',
                ]);
            }
            if($findRequest->status != "approved_admin"){
                return response()->json([
                    'message' => 'Status not approved Admin', 
                ]);
            }
            if($findRequest->status == "approved_distributor"){
                return response()->json([
                    'message' =>  'Status already approved Distributor', 
                ]);
            }
            $findRequest->status =  "approved_distributor";
            $findRequest->save();
            return response()->json([
                'message' => 'Request Obat updated successfully',
                'data' => $findRequest
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function listRequest(){
        try {
            $request = RequestObat::with(['obat','user'])->get();
            return response()->json([
                'message' => 'Data Request Obat',
                'data' => $request
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function listObatDistributor(){
        try {
            $obat = RequestObat::with(['obat', 'user'])->get();
            $listObatApproveAdmin = [];
            foreach ($obat as $key => $value) {
                if($value->status == "approved_admin"){
                    $listObatApproveAdmin[] = $value;
                }
            }
            return response()->json([
                'message' => 'Data Obat',
                'data' => $listObatApproveAdmin
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function listObatExternal(){
        try {
            $user_id = auth()->user()->id;
            $obats = RequestObat::where('user_id', $user_id)->with(['obat'])->get();
            return response()->json([
                'message' => 'Data Obat',
                'data' => $obats
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
