<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 20);
        $user_id = $request->input('user_id');
        $status = $request->input('status');
    
        if($id){
            $donation = Donation::with(['user'])->find($id);
    
            if($donation){
                return ResponseFormatter::success(
                    $donation, 'Data donasi berhasil diambil'
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
    
        $donation = Donation::orderBy('created_at', 'desc')->with(['user']);
            
        if($user_id){
            $donation->where('user_id', $user_id);
        }
    
        if($status){
            $donation->where('status', $status);
        }
    
        return ResponseFormatter::success(
            $donation->paginate($limit),
            'Data donasi berhasil diambil'
        );
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request -> validate([
                'user_id' => 'required|exists:users,id',
                'type' => 'required',
                'name' => 'required',
                'desc' => 'required',
                'status' => 'required',
            ]);
    
            $donation = new Donation;
            $donation = Donation::create([
                'user_id' => $request->user_id,
                'type' => $request->type,
                'name' => $request->name,
                'desc' => $request->desc,
                'status' => $request->status,
            ]);
    
            $donation = Donation::with(['user'])->find($donation->id);
            return ResponseFormatter::success([$donation], 'Donasi berhasil dibuat');  
        
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], 'Authentication Failed', 500);
        }      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $userId)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 20);

        if($id){
            $donation = Donation::with(['user'])->find($id);
    
            if($donation){
                return ResponseFormatter::success(
                    $donation, 'Data donasi berhasil diambil'
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

        $donation = Donation::with(['user'])->where('user_id', '=', $userId);

        return ResponseFormatter::success(
            $donation->paginate($limit),
            'Data donasi berhasil diambil'
        );

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $donation = Donation::findOrFail($id);

        $donation->update($request->all());

        return ResponseFormatter::success([$donation], 'Donasi berhasil diambil');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|max:8192',
        ]);

        if($validator->fails()){
            return ResponseFormatter::error([
                'error' => $validator->errors()
            ], 'Update photo fail', 401 );
        }

        if($request->file('image'))
        {
            $image = $request->image->store('assets/donation', 'public');
        
            //simpan url foto ke db
            $donation = Donation::findOrFail($id);
            $donation->image = $image;
            $donation->update();

            return ResponseFormatter::success([$image], 'File uploaded');
        }

        // if($request)

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
