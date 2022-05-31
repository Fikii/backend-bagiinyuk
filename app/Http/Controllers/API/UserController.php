<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Fortify\PasswordValidationRules;
use Exception;
use App\Models\User;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use PasswordValidationRules;

    public function login(Request $request){
        try {
            //Validasi input            
            $request->validate([
                'email' => 'email|required',
                'password' => 'required',
                'roles' => 'required',
            ]);

            //Mengecek credentials (login)
            $credentials = request(['email','password', 'roles']);
            if(!Auth::attempt($credentials)){
                return ResponseFormatter::error([
                    'message' => 'Unautorized'
                ], 'Authentication Failed', 500);
            }

            //Jika user tidak sesuai maka jangan izinkan masuk (beri errror)
            $user = User::where('email', $request->email)->first();
            if(!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }

            //Jika berhasil maka loginkan
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Authenticated');

        } catch(Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], 'Authentication Error', 500);
        }
    }

    public function register(Request $request){
        try {
            $request->validate([
                'name' => ['required','string','max:255'],
                'email' => ['required','string', 'email','max:255', 'unique:users'],
                'password' => $this->passwordRules(),
                'address' => ['required','string', 'max:255'],
                'phoneNumber' => ['required','numeric','min:10'],
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'phoneNumber' => $request->phoneNumber,
                'district' => $request->district,
                'desc' => $request->desc,
                'password' => Hash::make($request->password),
            ]);

            $user = User::where('email', $request->email)->first();

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ]);

        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], 'Authentication Failed', 500);
        }
    }

    public function logout(Request $request){
        $token = $request->user()->currentAccessToken()->delete();
        return ResponseFormatter::success($token, 'Token Revoked');
    }

    public function fetch(Request $request){
        return ResponseFormatter::success($request->user(), 'Data profile user berhasil diambil');
    }

    public function updateProfile(Request $request){
        $data = $request->all();

        $user = Auth::user();
        $user->update($data);

        return ResponseFormatter::success($user, 'Profile Updated'); 
    }

    public function updatePhoto(Request $request){
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|max:8192',
        ]);

        if($validator->fails())
        {
            return ResponseFormatter::error([
                'error' => $validator->errors()
            ], 'Update photo fail', 401 );
        }

        if($request->file('file'))
        {
            $file = $request->file->store('assets/user', 'public');
        
            //simpan url foto ke db
            $user = Auth::user();
            $user->profile_photo_path = $file;
            $user->update();

            return ResponseFormatter::success([$file], 'File uploaded');
        }
    }

    public function panti(Request $request){
        $id = $request->input('id');
        $roles = $request->input('roles');
        $limit = $request->input('limit', 10);

        if($id){
            $user = User::find($id);
        
            if($user){
                return ResponseFormatter::success(
                    $user, 'Data Panti berhasil diambil'
                );
            }
            else{
                return ResponseFormatter::error(
                    null, 
                    'tidak ada data',
                    404
                );
            }
        
        }

        $user = User::where('roles', '=', "PANTI");

        return ResponseFormatter::success(
            $user->paginate($limit),
            'Data list berhasil diambil'
        );
    }

    public function orphanage(Request $request, $id){
        $user = User::findOrFail($id);

        if($user){
            return ResponseFormatter::success(
                $user, 'Data Panti Asuhan Berhasil Diambil'
            );
        }else{
            return ResponseFormatter::error(
                null, 
                'Data Tidak Ditemukan', 
                404
            );
        }
    }
}
