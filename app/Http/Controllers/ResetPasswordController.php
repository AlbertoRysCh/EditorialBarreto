<?php

namespace App\Http\Controllers;


use App\Http\Controllers\SendNotification;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Helpers\LogSystem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Exception;
//Request
use Illuminate\Http\Request;
// use App\Http\Requests\Password\PasswordRequest;
//Model
use App\User;
use App\PasswordReset;

class ResetPasswordController extends Controller
{
    // const MENSAJE = 'mensajeSuccess';

    public function showFormReset()
    {
        $array_obj  = [

        ];
        return View::make('auth.passwords.form', $array_obj);
    }
    public function emailReset(Request $request)
    {
        $this->validateEmail($request);

        DB::beginTransaction();
        try {
        // TOKEN
        $str_random = Str::random(50);
        $bytes = bin2hex(random_bytes(16));
        $token = $str_random.$bytes;


        $user = User::where('email',$request->email)->first();

            if ($user == null) {
                return redirect()->back()->withInput()->with('email_exist', 'Correo no existe verifique de nuevo.');
            }
            PasswordReset::where('email',$request->email)->delete();
            SendNotification::sendLinkResetPassword($user, $token);

            DB::table('password_resets')->insert([
                'token' => $token,
                'email' => $request->email,
                'created_at' => Carbon::now(),
            ]);
            DB::commit();
            LogSystem::addLog('Usuario solicito cambio de contraseña.',1,$user);
            return redirect(route('login.principal'))->with('email_success', 'Se ha enviado un enlace a su correo para recuperar su cuenta.');

        } catch (Exception $e) {
            DB::rollback();
        }
    }

    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    }

    public function showResetPassword($token)
    {
        $resetPassword = PasswordReset::whereToken($token)->first();
        $array_obj  = [
            'resetPassword' =>$resetPassword
        ];
        return View::make('auth.passwords.form-reset', $array_obj);
    }

    public function resetPassword(Request $request)
    {
        $consultaToken = PasswordReset::where(['email' => $request->email,'token' => $request->token])->first();
        $verificarToken = $request->token;
        if($consultaToken != null){

        if ($consultaToken->token == $verificarToken) {
            $user = User::where('email',$request->email)->first();

            // Validar si la contraseña es igual a la anterior
            // if (Hash::check($request->password, $user->password)) {
            //     return redirect()->back()->withInput()->with('msj_password_error', 'La nueva contraseña debe ser diferente a la contraseña actual.');
            // }

            if ($request->password != $request->confirm_password) {
                return redirect()->back()->withInput()->with('msj_password_error', 'Las contraseñas no coinciden.');
            }
            PasswordReset::where(['email' => $request->email,'token' => $request->token])->delete();

            $attributes = array_map('trim', $request->all());
            $data = array('password' => Hash::make($request->password));
            $data_merge = array_merge($attributes, $data);
            $updatePass = User::whereEmail($request->email)->first();
            $updatePass->update($data_merge);

            SendNotification::changePasswordSuccess($user);
            LogSystem::addLog('Usuario cambio la clave.',1,$user);
            return redirect(route('login.principal'))->with('msj_password_success', 'Contraseña cambiada con éxito.');

        }else{
            return redirect()->back()->withInput()->with('msj_password_error', 'Enlace inválido, por favor contacte con soporte.');
        }

        }else{
            return redirect()->back()->withInput()->with('msj_password_error', 'Enlace fue utilizado o ha expirado.');
        }

    }



}
