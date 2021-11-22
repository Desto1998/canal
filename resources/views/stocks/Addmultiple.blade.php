<x-app-layout>
    <x-slot name="slot">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6>Enregistrer des décodeurs en stock</h6>

            </div>
            <div class="card-body">
                @include('layouts.flash-message')
                <div class="row">
                    <div class="col-m-2 ml-4">Quantité: <strong>{{ $request->quantite }}</strong></div>
                    <div class="col-m-2 ml-4">Prix U: <strong>{{ $request->prix_u }}</strong></div>
                    <div class="col-m-2 ml-4">Montant total:
                        <strong>{{ $request->prix_u * $request->quantite }}</strong></div>
                    <div class="col-m-2 ml-4">Date appro: <strong>{{ $request->date_appro }}</strong></div>
                </div>
                <div class="mt-4">
                    <form method="get" action="{{ route('stock.store.decodeur') }}" id="addstockForm">
                        @csrf
                        <input type="hidden" name="quantite" value="{{ $request->quantite }}">
                        <input type="hidden" name="prix_u" value="{{ $request->prix_u }}">
                        <input type="hidden" name="date_appro" value="{{ $request->date_appro }}">
                        <div class="form-group">
                        </div>
                        @for($i=0; $i<$request->quantite; $i++)
                            <div class="form-group">
                                <label>Numero du decodeur N_°: {{ $i+1 }}</label>
                                <input type="text" maxlength="14" minlength="10" name="code_stock[]"
                                       class="form-control" required>
                            </div>
                        @endfor

                        <hr>
                        <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Enregistrer
                        </button>
                        <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Retour</button>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
<script>
    // $('#prix_unitaire').change(function (e){
    //     var qte = $('#qte').val();
    //     var pu = $('#prix_unitaire').val();
    //     var total = 0;
    //     if ($.isNumeric(qte) && $.isNumeric(pu)){
    //         total = pu * qte;
    //         $('#total').val(total);
    //     }else {
    //         $('#total').val(total);
    //         e.preventDefault();
    //     }
    // });
    // $('#qte').change(function (e){
    //     var qte = $('#qte').val();
    //     var pu = $('#prix_unitaire').val();
    //     var total = 0;
    //     if ($.isNumeric(qte) && $.isNumeric(pu)){
    //         total = pu * qte;
    //         $('#total').val(total);
    //     }else {
    //         $('#total').val(total);
    //         e.preventDefault();
    //     }
    // });
    // function controlNumero(val) {
    //     // alert("test");
    //     var long = $('#num_decodeur1').val();
    //     if (long.length != 14) {
    //         $('.ereur-numerodd').removeClass('hidden');
    //     } else {
    //         $('.ereur-numerodd').addClass('hidden');
    //     }
    //     // if ($.isNumeric(value) == '') {
    //     //     alert('Veillez entrer un nombre compris entre 0 et 20. Merci!');
    //     //     return false;
    //     // }
    // }
    //
    // $("#decodeurForm").submit(function (event) {
    //
    //     var numdeco = $('#num_decodeur1').val();
    //     if (numdeco.length == 14) {
    //         $('.ereur-numerodd').addClass('hidden');
    //         return;
    //     } else {
    //         $('.ereur-numerodd').removeClass('hidden');
    //         event.preventDefault();
    //     }
    //
    // });

</script>
