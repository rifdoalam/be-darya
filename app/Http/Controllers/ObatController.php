<?php

namespace App\Http\Controllers;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $obat = Obat::all();
            return response()->json([
                'message' => 'Data Obat',
                'data' => $obat
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function create(
        Request $request
    )
    {
        try {
            $validated = $request->validate([
                'nama_obat' => 'required',
                'expired' => 'required',
                'stock' => 'required',
                'harga' => 'required',
                'jenis_obat' => 'required',
            ]);
            $obat = Obat::create([
                'nama_obat' => $request->nama_obat,
                'expired' => $request->expired,
                'stock' => $request->stock,
                'harga' => $request->harga,
                'jenis_obat' => $request->jenis_obat,
            ]);
            return response()->json([
                'message' => 'Obat created successfully',
                'data' => $obat
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function stockObat(){
        try {
            $obat = Obat::all();
            $stockRendah = [];
            $stockBanyak =[];
            foreach($obat as $o){
                if($o->stock < 10){
                    $stockRendah[] = $o;
                }else{
                    $stockBanyak[] = $o;
                }
            }
            return response()->json([
                'message' => 'Data Obat',
                'data'=>[
                    'stock_banyak' => $stockBanyak,
                    'stock_rendah' => $stockRendah
                ]
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function expiredObatData(){
        try {
            $obats = Obat::all();
            $expiredLessWeek= [];
            $expiredMoreWeek = []; // expired more than Week

            foreach($obats as $o){
                if($o->expired > now()->addWeek()){
                    $expiredLessWeek[] = $o;
                }else{
                    $expiredMoreWeek[] = $o;
                }
            }
                return response()->json([
                    'message' => 'Data Obat',
                    'data'=>[
                        'expired_less_week' => $expiredLessWeek,
                        'expired_more_week' => $expiredMoreWeek
                    ]
                ], 200);
  
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function delete($id){
        try {
            $obat = Obat::find($id);
            if (!$obat) {
                return response()->json([
                    'message' => 'Obat not found',
                ]);
            }
            $obat->delete();
            return response()->json([
                'message' => 'Obat deleted successfully',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    

    
}
