<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use phpDocumentor\Reflection\Types\Array_;
use Vonage\Response;
use Exception;
use function PHPUnit\Framework\exactly;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role==='admin'){
            $users = User::all();
//            $data = new Array_();
//            $data->name= 'desto';
//            $data->prenom= 'tambu';
//            $data->age= 10;
//            dd($data->prenom, $data->age, $data ->name);
            return view('users.list', compact('users'));

        }else{
            return view('layouts.droit');
        }

    }
//    public function sendSmsNotificaition()
//    {
//        $basic  = new \Nexmo\Client\Credentials\Basic('Nexmo key', 'Nexmo secret');
//        $client = new \Nexmo\Client($basic);
//
//        $message = $client->message()->send([
//            'to' => '9197171****',
//            'from' => 'John Doe',
//            'text' => 'A simple hello message sent from Vonage SMS API'
//        ]);
//
//        dd('SMS message has been delivered.');
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
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
        $password = Hash::make($request->password);

        if ($request->role == 'admin') {
            $is_admin = 1;
        }
//        $verifyEmail = User::where('email',$request->email)->get();
//        $verifyEmail =  User::find($request->email) ;
        $verifyEmail =User::where('email',$request->email)->get();
//        DD(count($verifyEmail));exit();


        if (count($verifyEmail) == 0){

            $user = User::Create(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $password,
                    'role' => $request->role,
                    'telephone' => $request->telephone,
                    'is_admin' => $is_admin,
                    'adresse' => $request->adresse,
                    'is_active' => $is_active
                ]);
        }else{
            session()->flash('message', 'Cette adresse email est déja utilsé');
            return redirect()->back()->with('warning', 'Cette adresse email est déja utilsé!');

        }

        if ($user) {
            session()->flash('message', 'Utilisateur Enregistré avec succès');
            return redirect()->route('compte')->with('success', 'Utilisateur enregistré avec succès!');
        } else {
            return redirect()->back()->with('danger', 'Error!');
        }


    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit_users(Request $request)
    {

        $userid = $request->route('id');
        if ($userid) {
            $user = User::find($userid);
            return view('users.add', compact('user'));
        }
        session()->flash('message', 'Utilisateur inconnu veillez le créer!');

        //dd($datas);
        return redirect()->route('compte.add')->with('danger', 'Utilisateur inconnu veillez le créer!');
    }

    public function update(Request $request){
        $this->validate(request(), [
            'name' => 'required',
            'role' => 'required',
            'telephone' => 'required',
            'email' => 'required|email',
            'password' => 'min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:6'
        ]);
        $is_admin = 0;
        $password = Hash::make($request->password);

        if ($request->role == 'admin') {
            $is_admin = 1;
        }
        if (!empty($request->id)) {

            $dataId = $request->id;
            $current_user_password = Auth::user()->password;
//            DD(Hash::check($request->oldpassword,$current_user_password));
//            exit();
            if (empty($request->oldpassword) || Hash::check($request->oldpassword,$current_user_password) == true)  {

                $user = User::updateOrCreate(
                    [
                        'id' => $dataId
                    ],
                    [
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => $password,
                        'role' => $request->role,
                        'telephone' => $request->telephone,
                        'is_admin' => $is_admin,
                        'adresse' => $request->adresse,
                    ]);

            } else {
                session()->flash('message', 'Ancien mot de passe incorrect!');
                return redirect()->back()->with('error', 'Ancien mot de passe incorrect!');
            }
        }
        if ($user) {
            session()->flash('message', 'Utilisateur Enregistré avec succès');
            return redirect()->route('compte')->with('success', 'Utilisateur modifié avec succès!');
        } else {
            session()->flash('message', 'Erreur');

            return redirect()->back()->with('error', 'Erreur!');
        }
    }
    public function delete(Request $request)
    {
//        $result = Client::where('id', $request->id)->delete();
        $data = $this->destroy($request->id);
        return Response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::where('id', $id)->delete();
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
        $data = User::where('id', $request->id)->update(['is_active' => 1]);
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
        $data = User::where('id', $request->id)->update(['is_active' => 0]);
        return Response()->json($data);
    }

}
