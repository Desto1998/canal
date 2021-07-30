<?php

namespace App\Http\Controllers;

use App\Models\Decodeur;
use App\Models\Materiel;
use App\Http\Requests\DecodeurRequest;
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
        $mat = new Materiel();
        $mat->quantite = $request->quantite;
        $mat->prix_materiel = $request->prix_materiel;
        $mat->quantite_stock = $mat->quantite_stock+$request->quantite;
        $mat->date_livaison = $request->date_livraison;


        $mat->save();

        $notification = array(
            'message' => 'Données insérées avec succès',
            'alert-type' =>'success'
        );
        return Back()->with($notification);
    }

    public function storeDec(Request $request)
    {
        $request->validate([
            'prix'=>'bail|required|integer',
            'num_decodeur'=>'bail|required|integer|size:14',
            'date_livaison'=>'bail|required',
        ]);
        $dec = new Decodeur();
        $dec->num_decodeur = $request->num_decodeur;
        $dec->prix_decodeur = $request->prix_decodeur;
        $dec->quantite =1;
        $dec->quantite_stock = 1;
        $dec->date_livaison = $request->date_livraison;


        $dec->save();

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
