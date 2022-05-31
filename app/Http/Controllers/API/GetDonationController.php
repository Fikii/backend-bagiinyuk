<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\GetDonate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetDonationController extends Controller
{
    public function all(Request $request){
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $user_id = $request->input('user_id');
        $donation_id = $request->input('donation_id');

        if($id){
            $getdonation = GetDonate::with(['user', 'donation'])->find($id);

            if($getdonation){
                return ResponseFormatter::success(
                    $getdonation, 'Data donasi berhasil diambil'
                );
            }
            else{
                return ResponseFormatter::error(
                    null,
                    'Data tidak ada',
                    404
                );
            }
        }

        // $getdonation = GetDonate::with(['user', 'donation'])->where('user_id', Auth::user()->id);
        $getdonation = GetDonate::with(['user', 'donation']);
        
        if($user_id){
            $getdonation->where('user_id', $user_id);
        }

        return ResponseFormatter::success(
            $getdonation->paginate($limit),
            'Data donasi berhasil diambil'
        );

    }
}
