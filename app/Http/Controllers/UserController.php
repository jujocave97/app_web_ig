<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Comments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function registerView(){
        return view('user_views.register');
    }

    public function doRegister(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                "name"=>"required|string|max:20",
                "email"=> "required|email:rfc,dns|unique:App\Models\User,email",
                "password"=>"required|min:5|max:20|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/",
                "password_repeat"=>"required|same:password"
            ],[
                "password.min" => "La contraseña debe contener 5 carácteres mínimo",
                "password.max" => "La contraseña debe contener 20 carácteres máximo",
                "password.regex" => "La contraseña debe contener una minúscula, una mayúscula y un dígito",
            ]
        );

        // SI LOS DATOS SON INVÁLIDOS, DEVOLVER A LA PÁGINA ANTERIOR E IMPRIMIR LOS ERRORES DE VALIDACIÓN
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // SI LOS DATOS SON VÁLIDOS (SI EL REGISTRO SE HA REALIZADO CORRECTAMENTE) CARGAR LA VIEW DE LOGIN PARA PODER REALIZAR LOGIN
        $datosUsuario = $request->all();
        $user = new User();
        $user->name = $datosUsuario['name'];
        $user->email = $datosUsuario['email'];
        $user->password = $datosUsuario['password'];
        
        $user->save();
        return redirect()->route('user.showLogin');
        
    }

    public function showLogin(){
        return view('user_views.login');
    }

    public function doLogin(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                "email" => "required|email:rfc,dns|exists:App\Models\User,email",
                "password" => "required",
            ]
        );

        if ($validator->fails()) {
            return redirect()->route('user.showLogin')->withErrors($validator)->withInput();
        }

        $userEmail = $request->get('email');
        $userPassword = $request->get('password');
        
        $emailYPasswordUser = [
            'email' => $userEmail,
            'password' => $userPassword,
        ];
        if (Auth::attempt($emailYPasswordUser, true)) { // Auth::attempt busca al usuario en la base de datos y, si las credenciales son correctas, devuelve true y además crea una Session en la BD
            $request->session()->regenerate();

            $user = User::where('email', $userEmail)->first();
            $posts = Post::all();  
            return view('user_views.index', compact('user', 'posts')); // CARGA LA VIEW PRINCIPAL CON LA INFO DEL USUARIO
        } else {
            $validator->errors()->add('credentials', 'Credenciales incorrectas');
            return redirect()->route('user.showLogin')->withErrors($validator)->withInput();
        }
    }

     // Logout
     public function doLogout() {
        Auth::logout();
        return redirect()->route('user.showLogin');
    }

     // Show index
     public function showIndex($id) {
        
        if($id == "") {
            return redirect()->route('user.showLogin');
        }
        
        $user = User::findOrFail($id); // Buscar el usuario
        $posts = $posts = Post::withCount('comments')->get();// Obtener posts del usuario

        return view('user_views.index', compact('user', 'posts')); // CARGA LA VIEW PRINCIPAL CON LA INFO DEL USUARIO
    }

    // darse de baja
    public function unsubscribe($id) {
        $user = User::findOrFail($id);
    // Elimina todos los comentarios asociados al usuario
        Comments::where('user_id', $id)->delete();
    // Elimina todos los posts asociados al usuario
        Post::where('belongs_to', $id)->delete();
        $user->delete();
        Auth::logout();
       // Redirigir al login después de eliminar la cuenta
        return redirect()->route('login')->with('message', 'Tu cuenta ha sido eliminada correctamente.');


    }

    
}
