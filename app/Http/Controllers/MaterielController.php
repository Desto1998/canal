<?php

namespace App\Http\Controllers;

use App\Models\Decodeur;
use App\Models\Materiel;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\DecodeurRequest;
use App\Models\Decodeur_Accessoire;
use Illuminate\Http\Request;

class MaterielController extends Controller
{

    public function index()
    {
        $allMateriels = Materiel::all();
        $allDecodeurs = Decodeur::all();
        $allDecodeurs = Stock::join('users','users.id','stocks.id_user')
            ->where('stocks.statut',0)
            ->get()
        ;
        return view('stocks.stock',compact('allMateriels','allDecodeurs'));
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
        $mat->nom_materiel = $request->nom_materiel;
        $mat->quantite = $request->quantite;
        $mat->prix_materiel = $request->prix_materiel;
        $mat->date_livaison = $request->date_livraison;

        $mat->save();
        session()->flash('message','Materiel ajouté avec succès.');
        return  redirect()->back()->with('info', 'Le materiel ajouté avec succès.');
    }

    public function storeDec(Request $request)
    {
        // $request->validate([
        //     'prix'=>'bail|required|integer',
        //     'num_decodeur'=>'bail|required|integer|size:14',
        //     'date_livaison'=>'bail|required',
        // ]);
        $mat_dec = new Decodeur_Accessoire();

        $dec = new Decodeur();
        $decs = Decodeur::all();
//        $dec->num_decodeur = $request->num_decodeur;
//DD($request);exit();
        foreach($decs as $d){
            if($d->num_decodeur == $request->num_decodeur){
                session()->flash('message', ' Le décodeur existe déja!');

                return redirect()->back()->with('warning', 'Le décodeur existe déja!');
            }
//            else{
//
//
//            }
        }
        $dec->num_decodeur = $request->num_decodeur;
        $dec->id_user= Auth::user()->id;
        $dec->prix_decodeur = $request->prix_decodeur;
        $dec->quantite =1;
        $dec->date_livaison = $request->date_livraison;

        $dec->save();
        session()->flash('message','Decodeur ajouté avec succès.');
        return  redirect()->back()->with('info', 'Le décodeur ajouté avec succès.');
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
        return view('stocks.modif_materiel',compact('donnees'));
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
        session()->flash('message',
            $this->id ?
             'Decodeur mis à jour avec succès.'
              : 'Decodeur créé avec succès.');
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
