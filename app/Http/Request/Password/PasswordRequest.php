<?php
namespace App\Http\Request\Password;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            // 'password' => 'required|confirmed|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$&*_.-])(?=.*[0-9])[A-Za-z\d$@$!#*&_.-]{8,20}$/',
            'password' => 'required|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'password.confirmed' => 'Las contraseñas no coinciden, intenté de nuevo',
            // 'password.regex' => 'La contraseña no cumple con el formato. (8 Caracteres mínimo | 20 Caracteres máximo | Un carácter especial (!@#$&*_.-) | Un número | Una letra en mayúscula | Una letra en minúscula)',
        ];
    }
}
