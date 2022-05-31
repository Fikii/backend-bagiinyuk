<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Fortify\PasswordValidationRules;
use Exception;
use App\Models\Orphanage;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class OrphanageController extends Controller
{
    // use PasswordValidationRules;

    // public function orlogin(Request $request){
    //     try {
    //         //Validasi input            
    //         $request->validate([
    //             'email' => 'email|required',
    //             'password' => 'required',
    //         ]);

    //         //Mengecek credentials (login)
    //         $credentials = request(['email','password']);
    //         if(!Auth::attempt($credentials)){
    //             return ResponseFormatter::error([
    //                 'message' => 'Unautorized'
    //             ], 'Authentication Failed', 500);
    //         }

    //         //Jika orphanage tidak sesuai maka jangan izinkan masuk (beri errror)
    //         $orphanage = Orphanage::where('email', $request->email)->first();
    //         if(!Hash::check($request->password, $orphanage->password, [])) {
    //             throw new \Exception('Invalid Credentials');
    //         }

    //         //Jika berhasil maka loginkan
    //         $tokenResult = $orphanage->createToken('authToken')->plainTextToken;
    //         return ResponseFormatter::success([
    //             'access_token' => $tokenResult,
    //             'token_type' => 'Bearer',
    //             'orphanage' => $orphanage
    //         ], 'Authenticated');

    //     } catch(Exception $error) {
    //         return ResponseFormatter::error([
    //             'message' => 'Something went wrong',
    //             'error' => $error
    //         ], 'Authentication Error', 500);
    //     }
    // }

    // public function orregister(Request $request){
    //     try {
    //         $request->validate([
    //             'name' => ['required','string','max:255'],
    //             'email' => ['required','string', 'email','max:255', 'unique:users'],
    //             'password' => $this->passwordRules()
    //         ]);

    //         Orphanage::create([
    //             'name' => $request->name,
    //             'email' => $request->email,
    //             'address' => $request->address,
    //             'phoneNumber' => $request->phoneNumber,
    //             'desc' => $request->desc,
    //             'password' => Hash::make($request->password),
    //         ]);

    //         $orphanage = Orphanage::where('email', $request->email)->first();

    //         $tokenResult = $orphanage->createToken('authToken')->plainTextToken;

    //         return ResponseFormatter::success([
    //             'access_token' => $tokenResult,
    //             'token_type' => 'Bearer',
    //             'orphanage' => $orphanage
    //         ]);

    //     } catch (Exception $error) {
    //         return ResponseFormatter::error([
    //             'message' => 'Something went wrong',
    //             'error' => $error
    //         ], 'Authentication Failed', 500);
    //     }
    // }
}
