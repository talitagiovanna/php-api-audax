<?php


/*
            
CRUD 
*/
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;



class UserController extends Controller

  {
    public function createUser(Request $request)
    {
      $this->validate($request, [
        'username' => 'required|min:3|max:150|unique:users',
        'password' => 'required|min:8'
    ]);
      $hashed = Hash::make($request->input('password'), ['rounds' => 12
]);
      $user = User::create(['username' => $request->input('username'), 'password' => $hashed, 'uuid' => User::newUniqueId()
      ]);
      $user->save();
      return response()->json([
      'uuid' => $user['uuid'],
      'username' => $user['username'],
      'registeredAt' => $user['created_at'],
]);  
    }
    
    public function getAllUsers()
    {
      $users = User::all();
      return response()->json($users);
    }
    
    public function getUser($userUuid)
    {
      $getUser = User::where('uuid', $userUuid)->take(1)->get();
      return response()->json($getUser);
    }
    public function updateUser(Request $request, $userUuid)
    {
      $this->validate($request, [
        'username' => 'required|min:3|max:150',
        'password' => 'required|min:8'
    ]);
      $hashed = Hash::make($request->input('password'), ['rounds' => 12
]);
      $updateUser = User::where('uuid', $userUuid)->update(['username' => $request->input('username'), 'password' => $hashed]);
      $returnUser = User::where('uuid', $userUuid)->take(1)->get();
      return response()->json($returnUser);
    }

    public function deleteUser($userUuid)
    {
     $searchArticlesUsers = DB::table('articles')->where('uuid', $userUuid)->count();
      if ($searchArticlesUsers === 0){
        User::where('uuid', $userUuid)->delete();
        return response()->json("Usuário apagado com sucesso");
      }
      else{
        return response()->json("Recurso não encontrado");
      }
    }
  }


