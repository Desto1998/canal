<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    //
    public function makeForm(Request $request)
    {
        $request->validate([
            'quantite'=>'required|numeric|min:1|',
            'prix_u'=>'required|numeric',
            'date_appro'=>'required'
        ]);
        return view('stocks.Addmultiple',compact('request'));
    }
    public function storeDecodeur(Request $request)
    {
        $id_user = Auth::user()->id;
        $request->validate([
            'quantite'=>'required|numeric|min:1',
            'code_stock'=>'required',
            'prix_u'=>'required|numeric',
            'date_appro'=>'required'
        ]);
        $done =0;
        $fail = 0;
        $stock=[];
        foreach ($request->code_stock as $num=> $item)
        {
            $check  = Stock::where('code_stock',$item)
                ->get();
            if (!isset($check[0])){
                $done++;
                $stock[$num] = Stock::create([
                    'code_stock'=>$item,
                    'prix_unit'=>$request->prix_u,
//                    'date_appro'=>$request->date_appro,
                    'date_ajout'=>date('Y-m-d'),
                    'id_user'=>$id_user,
                    'statut'=>0
                ]);
            }else{
                $fail ++;
            }
            $nombre = count($stock);
            $raison = "Enrgistrement de $nombre decodeur(s). prix unit de $request->prix_u, approvisionné le $request->date_appro";
            $debitcaisse = (new CaisseController)->debitCaisse(-$request->prix_u * $nombre,$raison);
        }
        if ($fail==0)
        {
            return  redirect(route('stock'))->with('info', 'Les enregistrements ont été effectué avec succès.');

        }else{
            return  redirect(route('stock'))->with('warning', $done.' enregistrements ont été effectué avec succès. Certains existent dejà dans le système.');

        }
    }

}
