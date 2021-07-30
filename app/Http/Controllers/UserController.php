<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Vonage\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = User::all();
        return view('users.list',compact('users'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'role' => 'required',
            'telephone' => 'required',
            'email' => 'required|email',
            'password' => 'min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:6'
        ]);
        $is_active = 1;
        $is_admin = 0;
        $dataId =$request->id;
        $password = Hash::make($request->password);
        if ($request ->role == 'admin'){
            $is_admin = 1;
        }
        $user = User::updateOrCreate(
            [
                'id' => $dataId
            ],
            [
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>$password,
                'role'=>$request->role,
                'telephone'=>$request->telephone,
                'is_admin'=>$is_admin,
                'adresse'=>$request->adresse,
                'is_active'=>$is_active
            ]);

        if ($user) {
            session()->flash('message', 'Utilisateur Enregistré avec succès');
            return redirect()->route('compte')->with('success', 'Utilisateur enregistré avec succès!');
        }
        else {
            return redirect()->back()->with('danger', 'Error!');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit_users( Request $request)
    {

        $userid  = $request->route('id');
        if($userid){
            $user = User::find($userid);
            return view('users.add',compact('user'));
        }
        session()->flash('message', 'Utilisateur inconnu veillez le créer!');

        //dd($datas);
        return redirect()->route('compte.add')->with('danger', 'Utilisateur inconnu veillez le créer!');
    }


    public function delete(Request $request)
    {
//        $result = Client::where('id', $request->id)->delete();
//        $data = $this->destroy($request->id);
        $data ="";
        return Response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::where('id',$id)->delete();
        return $data;
    }
    public function doLogout()
    {
        Auth::logout(); // log the user out of our application
        return Redirect::to('login'); // redirect the user to the login screen
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function activate(Request $request)
    {
        $data = "";
        $data = User::where('id',$request->id)->update(['is_active'=>1]);
        return Response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function block(Request $request)
    {
        $data = "";
        $data = User::where('id',$request->id)->update(['is_active'=>0]);
        return Response()->json($data);
    }

}
