<?php
namespace App\Http\Controllers\ApiControllers;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\NewUserMail;
use App\Mail\UpdateUser;
use App\Models\User;
use App\Models\Rol;
use App\Models\Provincias;
class UserController extends Controller{
    //funcion para optener un listado de todos los usuarios
    public function getUsers(){
        $users = User::all();

        foreach($users as $user){
            $user->rol = $user -> Rol();
        }
        return response()-> json(["users"=>$users->toArray()]);
    }
    //funcion para crear un nuevo usuario
    public function create(Request $request){
        $validator = Validator::make($request->all(), ['name' => 'required','email' => 'required|email','id_role'=>'required']);

        if ($validator->fails()){
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg], 400);
        }

        $user = User::where('email',$request->email)->get();
        if(count($user)>0){
            return response()->json(['message' => 'El email ya se encuentra en uso'], 401);
        }

        $password =$request->password;
        $user = User::create([
            'name'=>$request-> name,
            'email'=>$request->email,
            'password'=>Hash::make($password),
            'id_role' =>$request -> id_role
        ]);

        try{
            Mail::to($request->email)->queue(new NewUserMail($user, $password));
            $message = 'Usuario creado exitosamente';
            $success = true;
        }catch(\Exception $e){
            $message = 'Usuario creado exitosamente pero no ha podido enviarse el correo electrónico. Por favor, pongase en contacto con su administrador de correos';
            $success = false;
        }

        return response()->json(['message' => $message, 'success' => $success]);
    }
    //funcion para eliminar el usuario seleccionado
    public function delete(Request $request){
        $user = User::find($request-> id);
        $user->delete();
        return response()->json($user, 200);
    }
    //funcion para obtener un listado de roles en la creacion de usuarios
    public function getRoles(){
        $rol = Rol::all();
        return response()-> json($rol->toArray());
    }
  
    //funcion para obtener un dato especifico de un usuario
    public function getUsuario($user_id){
        $user = User::find($user_id);
        
        return response()->json( $user );
      }

      ///funcion para modificar los datos del usuario
    public function updateUsuario(Request $request){
        $validator = Validator::make($request->all(), ['id'=>'required','name' => 'required','email' => 'required|email','id_role'=>'required']);

        if ($validator->fails()){
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'mensaje' => $msg], 400);
        }
        $user =  User::findOrFail($request->id);
        if($user == null){
            return response()->json(['message' => 'usuario no encontrado'], 401);
        }
        $user -> email =  $request -> email;
        $user -> name = $request -> name;
        $user -> id_role = $request -> id_role;
        $user->update();
        Mail::to($request->email)->queue(new UpdateUser($user));

      }
}