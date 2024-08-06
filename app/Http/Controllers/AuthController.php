<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use App\Models\ForgetPassword;
use App\Models\MasterDosen;
use App\Models\Roles;
use App\Models\SocialAcount;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use DB, Hash;
use Exception;
use Validator;
use Mail;
use Redirect;
use Socialite;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','loginNeo','callBackNeo','register','verifyToken','verifyTokenGoogle','verifyEmail','submitForgetPasswordForm','submitResetPasswordForm','SocialSignup','callBack']]);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            $user = User::with('role')->where('id', Auth::user()->id)->first();
            return response()->json(
                [
                    'message' => 'Success!!',
                    'data' => $this->respondWithToken($token)->original,
                    'user' => $user,
                ], 200);
        }

        return response()->json(
            [
                'message' => 'Unauthorized',
                'data' => null,
            ], 401);
    }

    public function register(Request $request)
    {
        DB::beginTransaction();
        try {
            $validate = $this->validateStore($request);
            if($validate['result']) {
                $data = User::create([
                    'name' => $request->first_name.' '.$request->last_name,
                    'email' => $request->email,
                    'email_verified_at' => date('Y-m-d H:i:s'),
                    'password' => Hash::make($request->password),
                    'role_id' => '4f4f0c6b-a3bf-4fa0-9e14-7c3ce00693d1'
                ]);

                DB::commit();

                return response()->json(
                    [
                        'message' => 'Success!!',
                        'data' => null,
                    ], 200);
            } else {
                return response()->json(
                    [
                        'message' => $validate['message'],
                        'data' => null,
                    ], 401);
            }
        } catch (Exception $e){
            DB::rollback();
            return H_apiResError($e);
        }
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        $user = User::with('role','mahasiswa','mahasiswa.pendidikanTerakhir')->where('id', Auth::user()->id)->first();
        return response()->json(
            [
                'message' => 'Success!!',
                'data' => $user,
            ], 200);
    }
    
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
    
    public function validateStore($request) {
        try {
            $result = true;
            $message = '';

            $validator = Validator::make( $request->all(),
                [
                    'last_name' => 'required',
                    'first_name' => 'required',
                    'email' => 'unique:users|required',  
                    'password' => 'required|min:6',
                    'password_confirmation' => 'required_with:password|same:password|min:6'
                    // 'position' => 'required',  

                ],
                [
                    'last_name.required' => 'last_name is required',
                    'first_name.required' => 'first_name is required',
                    'email.required' => 'email is required',  

                ]
            );
            if ($validator->fails()) {
                $message = $validator->messages()->first();
                $result = false;
            }

            return [
                'result' => $result,
                'message' => $message,
            ];
        } catch (Exception $e){
            if(env('APP_DEBUG')) return H_apiResError($e);
            else {
                $msg = $e->getMessage();
                return H_apiResponse(null, $msg, 400);
            }
        }
    }
    public function verifyToken(Request $request)
    {
        $user = User::with('role','merchant')->where('id', Auth::user()->id)->first();
        return response()->json(
            [
                'message' => 'Success!!',
                'data' => $this->respondWithToken($request->token)->original,
                'user' => $user,
            ], 200);
    }
    public function verifyTokenGoogle(Request $request)
    {
        $user = User::with('role')->where('id', Auth::user()->id)->first();
        return response()->json(
            [
                'message' => 'Success!!',
                'data' => $this->respondWithToken($request->token)->original,
                'user' => $user,
            ], 200);
    }

    public function sendEmailReminder(Request $request)
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return response()->json(
                [
                    'message' => 'Email already verified!',
                    'data' => null,
                ], 400);
        }

        return response()->json(
            [
                'message' => 'Email verification link sent on your email id!',
                'data' => null,
            ], 200);
    }
    protected function verificationUrl($notifiable)
    {
        $verifyURL = URL::temporarySignedRoute(
            'verification.verify', Carbon::now()->addMinutes(60), ['id' => $notifiable->getKey()]
        );
        $verifyURL = explode("/", $verifyURL);
        return config('app.VUE_URL')."verify-email/" . end($verifyURL);
    }
    public function verifyEmail($user_id, Request $request) {
        if (!$request->hasValidSignature()) {
            return response()->json(
                [
                    'message' => 'Invalid/Expired url provided!',
                    'data' => null,
                ], 401);
        }
        $user = User::findOrFail($user_id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }
        return response()->json(
            [
                'message' => 'Email has verified!!',
                'data' => null,
            ], 200);
    }

    public function submitForgetPasswordForm(Request $request)
    {
        try {
            $payload = $request->all();
            $validator = Validator::make( $payload['data'],
                [
                    'email' => 'required|email|exists:users',
                ]
            );
            if ($validator->fails()) {
                $message = $validator->messages()->first();
                $result = false;
                return H_apiResponse(null, $message, 400);
            }else{
                $token = Str::random(64);

                $request = $payload['data'];
                $data = new ForgetPassword();
                $data->email = $request['email']; 
                $data->token = $token;
                $data->save();
                return response()->json(
                    [
                        'message' => 'Email telah terkirim!',
                        'data' => null,
                    ], 200);
            }
        } catch (Exception $e){
            if(env('APP_DEBUG')) return H_apiResError($e);
            else {
                $msg = $e->getMessage();
                return H_apiResponse(null, $msg, 400);
            }
        }
    }

    public function submitResetPasswordForm(Request $request)
    {
        try {
            $result = true;
            $message = '';
            $payload = $request->all();
            $validator = Validator::make( $payload['data'],
                [
                    'email' => 'required|email|exists:users',
                    'password' => 'required|string|min:6|confirmed',
                    'password_confirmation' => 'required'
                ]
            );
            if ($validator->fails()) {
                $message = $validator->messages()->first();
                $result = false;
                return H_apiResponse(null, $message, 400);
            }else{
                $request = $payload['data'];
                $updatePassword = ForgetPassword::where([
                                            'email' => $request['email'],
                                            'token' => $request['token']
                                        ])
                                        ->first();
                if(!$updatePassword){
                    return H_apiResponse(null, 'Invalid token or email!', 400);
                }
                $user = User::where('email', $request['email'])
                            ->update(['password' => Hash::make($request['password'])]);
                ForgetPassword::where('email', $request['email'])->delete();
                $msg = 'Password berhasil diubah';
                return H_apiResponse(null, $msg, 200);
            }
        } catch (Exception $e){
            if(env('APP_DEBUG')) return H_apiResError($e);
            else {
                $msg = $e->getMessage();
                return H_apiResponse(null, $msg, 400);
            }
        }
    }

    public function SocialSignup()
    {

        // Socialite will pick response data automatic
        $user = Socialite::driver('google')->redirect()->getTargetUrl();


        return $user;
    }

    public function callBack(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = Socialite::driver('google')->stateless()->user();
            $json = response()->json($user);
            $check_social = SocialAcount::where('email', $json->getData()->email)->first();
            if(!$check_social){
                $check_user = User::where('email', $json->getData()->email)->first();
                if ($check_user) {
                    $url = "https://pmb.univpancasila.ac.id/app/#/sign-in?failed=1";
                    return Redirect::to($url);
                }
                $save = new SocialAcount();
                $save->social_id = $json->getData()->id;
                $save->driver = "google";
                $save->name = $json->getData()->name;
                $save->email = $json->getData()->email;
                $save->token = $json->getData()->token;
                $save->save();

                $data = User::create([
                    'name' => $json->getData()->name,
                    'email' => $json->getData()->email,
                    'wa_no' => 0,
                    'password' => null,
                    'social_acount_id' => $save->id,
                    'role_id' => '1f9f9246-2b2d-4240-13213-db8f7e47c7f'
                ]);
                $data->markEmailAsVerified();
            }else{
                $save = SocialAcount::find($check_social->id);
                $save->token = $json->getData()->token;
                $save->save();

                $data = User::where('social_acount_id', $save->id)->first();
            }

            DB::commit();
            $token = auth()->login($data);
            if ($token) {
                $user = User::with('role','mahasiswa','mahasiswa.pendidikanTerakhir')->where('id', Auth::user()->id)->first();
            }

            $url = "https://pmb.univpancasila.ac.id/app/#/sign-in-google?token=".$token;
            return Redirect::to($url);
        } catch (Exception $e){
            DB::rollback();
            return H_apiResError($e);
        }
    }
}