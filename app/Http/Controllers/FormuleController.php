<?php

namespace App\Http\Controllers;

use App\Models\Formule;
use Illuminate\Http\Request;

class FormuleController extends Controller
{
    public function view()
    {
        $allFormules = Formule::all();
        $allFormules = Formule::paginate(5);
        return view('modifier',compact('allFormules'));
    }

    public function edit_formule($id)
    {
        $datas = Formule::find($id);
        //dd($datas);
        return view('modif_formule',compact('datas'));
    }

    public function update(Request $request,$id_formule)
    {
        $request->validate([
            'nom_formule'=>'required',
            'prix_formule'=>'required',
        ]);
        $data = Formule::find($id_formule);
        $data->nom_formule = $request->nom_formule;
        $data->prix_formule = $request->prix_formule;

        $data->save();
        return redirect()->route('modifier')->with('info', 'La modification a reussi');
    }
}
