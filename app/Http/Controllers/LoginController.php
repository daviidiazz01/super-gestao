<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Corrigido o namespace para o modelo User

class LoginController extends Controller
{
    public function index(Request $request) {
        $erro = '';
        
       if ($request->get('erro') ==1) {
            $erro= 'Usuário e senha não existe';
        };


        return view('site.login', ['titulo' => 'Login', 'erro => $erro']);
    }

    public function autenticar(Request $request){
        $regras = [
            'usuario' => 'required|email',
            'senha' => 'required'
        ];

        $feedback = [
            'usuario.required' => 'O campo usuário (e-mail) é obrigatório',
            'usuario.email' => 'O campo usuário deve ser um endereço de e-mail válido',
            'senha.required' => 'O campo Senha é obrigatório'
        ];

        $request->validate($regras, $feedback);

        $email = $request->get('usuario');
        $password = $request->get('senha');

        echo "Usuário: $email | Senha: $password";
        echo '<br>';

        $user = new User();

        $existe = $user->where('email', $email)->where('password', $password)->first();

        if (isset($existe->name)) {
            echo 'Usuário existe';
        } else {
            return redirect()->route('site.login', ['erro => 1']);
           
        }

    
    }
}