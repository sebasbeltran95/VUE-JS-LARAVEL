<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index()
    {
        return view('usuarios');
    }
    
    public function consultarUsuarios(Request $request)
    {
        $search = $request->input('search');
        $users = User::orderBy('id', 'DESC')
                    ->when($search, function($query, $search) {
                        return $query->where('name', 'like', "%$search%")
                                     ->orWhere('email', 'like', "%$search%")
                                     ->orWhere('rol', 'like', "%$search%");
                    })
                    ->paginate(5);
    
        return response()->json($users);
    }

    public function crearUsuario(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
            'rol' => 'required|string',
        ], [
            'name.required' => 'El campo Nombre es obligatorio',
            'name.string' => 'El campo Nombre recibe solo cadena de texto',
            'name.max' => 'El campo Nombre debe contener maximo 255 caracteres',
            'email.required' => 'El campo Email es obligatorio',
            'email.string' => 'El campo Email recibe solo cadena de texto',
            'email.email' => 'El campo Email le falta el @',
            'password.required' => 'El campo Password es obligatorio',
            'password.string' => 'El campo Password recibe solo cadena de texto',
            'password.min' => 'El campo Nombre debe contener minimo 6 caracteres',
            'rol.required' => 'El campo Rol es obligatorio',
            'rol.string' => 'El campo Rol recibe solo cadena de texto'
        ]);

        $user = new User();
        $user->name =  $request->name;
        $user->email =  $request->email;
        $user->password = Hash::make($request->password);
        $user->rol = $request->rol;
        $user->save();
        
        return response()->json(['message' => 'Usuario creado exitosamente'], 201);
    }

    public function editarUsuario(Request $request, $id){

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->rol = $request->rol;
        $user->save();
    
        return response()->json(['message' => 'Usuario actualizado exitosamente'], 201);
    }

    public function editarContraseña(Request $request, $id){
        $user = User::find($id);
        $user->password = $request->password;
        $user->save();
    
        return response()->json(['message' => 'Usuario actualizado exitosamente'], 201);
    }

    public function eliminarUsuario($id){
        User::where('id',$id)->first()->delete();
        return response()->json(['message' => 'Usuario eliminado con éxito.']);
    }
}
