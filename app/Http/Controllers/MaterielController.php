<?php

namespace App\Http\Controllers;

use App\Models\Decodeur;
use App\Models\Materiel;
use App\Models\Type;
use Illuminate\Http\Request;

class MaterielController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allMateriels = Materiel::all();
        $allDecodeurs = Decodeur::all();
        return view('stock',compact('allMateriels','allDecodeurs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeMat(Request $request)
    {
        $request->validate([
            'type_materiel'=>'required',
        ]);
        $mat = new Materiel();
        $mat->quantite = $request->quantite;
        $mat->quantite_stock = $request->quantite;
        $mat->date_livaison = $request->date_livraison;


        $mat->save();

        $notification = array(
            'message' => 'Données insérées avec succès',
            'alert-type' =>'success'
        );
        return Back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_type)
    {
        $donnees = Materiel::find($id_type);
        return view('modif_materiel',compact('donnees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id_type)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
