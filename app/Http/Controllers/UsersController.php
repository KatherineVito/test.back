<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Hash;
use Auth;
class UsersController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show all admin users in DESC order.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index() {
        $users = \DB::table('users')
                ->select('users.*')
                ->where('users.rol','admin')
                ->orderBy('id', 'DESC')
                ->get();
        return view('users')->with('users', $users);
    }

    /**
     * Add user
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) {

        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3|max:20',
            'email' => 'required|min:3|email',
            'pass1' => 'required|min:3|required_with:pass2|same:pass2',
            'pass2' => 'required|min:3'
        ]);
        if($validator->fails()) {
           return back()
           ->withInput()
           ->with('ErrorInsert','Llenar la data')
           ->withErrors($validator);
        }else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'rol' => 'admin',
                'password' => Hash::make($request->pass1),
            ]);
            return back()->with('True', 'Se ha insertado el usuario admin correctamente');
        }
    }

    /**
     * Delete a specific user
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id) {
      $user = User::find($id);
      $user->delete();
      return back()->with('True','El registro se borró con éxito');
    }

    /**
     * Edit a specific user
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editUser(Request $request) {
        $user = User::find($request->id);
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3|max:20',
            'email' => 'required|min:3|email'
        ]);
        if($validator->fails()) {
            return back()
                ->withInput()
                ->with('ErrorEdit','Llenar la data')
                ->withErrors($validator);
        } else {
            $user->name = $request->name;
            $user->email = $request->email;
            $validator2 = Validator::make($request->all(),[
                'pass1' => 'required|min:3|required_with:pass2|same:pass2',
                'pass2' => 'required|min:3'
            ]);

            if(!$validator2->fails()) {
                $user->password = Hash::make($request->pass1);
            }

           // $user->save();
            $user->update();
            return back()->with('True', 'Se ha editado el usuario correctamente');
        }
    }

    public function show($id) {
        $result = Dni::select('dnis.*')
        ->orderBy('created_at', 'desc')
        ->where('dnis.dni_number_pet',$id)
        ->get();
        foreach($result as $data){
        $dni = [
         'dni_number_pet'=> $data->dni_number_pet,
         'lastname_pet'=>$data->lastname_pet,
         'name_pet'=>$data->name_pet,   
         'ip_extra_information' => $data->ip_extra_information,
         'birthday_pet' => $data->birthday_pet,
         'gender_pet' => $data->gender_pet,
         'name_owner' => $data->name_owner,
         'cellphone_owner' => $data->cellphone_owner,
         'email_owner' => $data->email_owner,
         'lastname_owner' => $data->lastname_owner,
         'specie_type_pet' => $data->specie_type_pet,
         'breed_pet' => $data->breed_pet,
         'dni_type_pet' => $data->dni_type_pet,
         'date_enrollment_pet' => $data->date_enrollment_pet,
        ];
    }

       return response()->json($dni);
    }
}
