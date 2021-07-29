<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nom_client'=>'bail|required|between:5,20|alpha',
            'prenom_client'=>'bail|required|between:5,20|alpha',
            'num_abonne'=>'bail|required|integer|size:9',
            'adresse_client'=>'bail|required',
            'formule'=>'bail|required',
            'telephone_client'=>'bail|required|integer|size:9',
            'num_decodeur'=>'bail|required|integer|size:14',
            'date_abonnement'=>'bail|required',
        ];
    }
}
