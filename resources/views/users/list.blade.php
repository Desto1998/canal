<x-app-layout>
    <x-slot name="slot">
        <div class="card shadow mb-4">
            <div class="card-header py-3 ">
                <h4 class="m-2 font-weight-bold text-primary float-left">Liste des Utilisateurs</h4>

                <a class="btn btn-primary d-flex float-right text-center" href="{{route('compte.add')}}">Ajouter</a>

            </div>
            <div class="alert hidden alert-success alert-block " id="success">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ __('Action effectuée avec succès') }}</strong>
            </div>

            <div class="alert hidden alert-danger alert-block " id="error">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ __( 'Erreur. Veillez recommencer') }}</strong>
            </div>
            @include('layouts/flash-message')
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Numéro de téléphone</th>
                            <th>Role</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $comp = 0;
                        @endphp
                        @foreach($users as $key => $user)
                            {{--                            {{ $comp++ }}--}}
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->telephone}}</td>
                                <td>
                                    @if($user->role == 'admin')
                                        {{'Administrateur'}}
                                    @else
                                        {{'Utilisateur'}}

                                    @endif
                                </td>
                                <td>
                                    @if($user->is_active==1)
                                        <span class="text-primary">Actif</span>
                                    @endif
                                    @if($user->is_active==0)
                                        <span class="text-danger">Blocké</span>
                                    @endif
                                </td>
                                <td align="center">
                                    <div class="btn_group">
                                        {{--                                        <a class="button is-primary" href="{{ route('user.show', $user->id) }}"><i class="fas fa-fw fa-list-alt"></i> Details</a>--}}
                                        <div class="btn-group">
                                            <a type="button"
                                               class="btn btn-primary bg-gradient-primary dropdown no-arrow "
                                               data-toggle="dropdown" style="color:white;">
                                                ... <span class="caret"></span></a>
                                            <ul class="dropdown-menu text-center" role="menu">
                                                <li>
                                                    <a type="button"
                                                       class="btn btn-warning bg-gradient-warning btn-block"
                                                       style="border-radius: 0px;"
                                                       href="{{route('user.editForm',$user->id)}}">
                                                        <i class="fas fa-fw fa-edit"></i> Modifier
                                                    </a>
                                                @if(Auth::user()->id != $user->id)
                                                    @if($user->is_active==1)
                                                        <li>
                                                            <a type="button"
                                                               class="btn btn-dark bg-gradient-dark btn-block"
                                                               style="border-radius: 0px;" href="javascript:void(0);"
                                                               id="block-user" onClick="blockFunc({{ $user->id }})"
                                                               data-toggle="tooltip">
                                                                <i class="fas fa-fw fa-lock"></i> Blocker
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if($user->is_active==0)
                                                        <li>
                                                            <a type="button"
                                                               class="btn btn-success bg-gradient-success btn-block"
                                                               style="border-radius: 0px;" href="javascript:void(0);"
                                                               id="activate-user"
                                                               onClick="activateFunc({{ $user->id }})"
                                                               data-toggle="tooltip">
                                                                <i class="fas fa-fw fa-check"></i> Activer
                                                            </a>
                                                        </li>
                                                    @endif

                                                    <li>
                                                        <a type="button"
                                                           class="btn btn-danger bg-gradient-danger btn-block"
                                                           style="border-radius: 0px;" href="javascript:void(0);"
                                                           id="delete-user" onClick="deleteFunc({{ $user->id }})"
                                                           data-toggle="tooltip">
                                                            <i class="fas fa-fw fa-trash"></i> Supprimer
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </x-slot>
</x-app-layout>
<script>
    // $('#success').addClass('hidden');
    // $('#error').addClass('hidden');
    function deleteFunc(id) {
        $('#success').addClass('hidden');
        $('#error').addClass('hidden');
        if (confirm("Supprimer cet utilisateur?") == true) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route('user.delete') }}",
                data: {id: id},
                dataType: 'json',
                success: function (res) {
                    if (res) {

                        $('#success').removeClass('hidden');
                        $('#error').addClass('hidden');
                        window.location.reload(200);

                    } else {
                        $('#success').addClass('hidden');
                        $('#error').removeClass('hidden');
                    }

                }
            });
        }
    }

    function blockFunc(id) {
        $('#success').addClass('hidden');
        $('#error').addClass('hidden');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "{{ route('block_compte') }}",
            data: {id: id},
            dataType: 'json',
            success: function (res) {
                if (res) {

                    $('#success').removeClass('hidden');
                    $('#error').addClass('hidden');
                    $('#succesActionModal').show(50);
                    window.location.reload(200);

                } else {
                    $('#success').addClass('hidden');
                    $('#error').removeClass('hidden');
                }

            }
        });
    }

    function activateFunc(id) {
        $('#success').addClass('hidden');
        $('#error').addClass('hidden');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "{{ route('activate_compte') }}",
            data: {id: id},
            dataType: 'json',
            success: function (res) {
                if (res) {

                    $('#success').removeClass('hidden');
                    $('#error').addClass('hidden');
                    $('#succesActionModal').removeClass('hidden');
                    window.location.reload(200);

                } else {
                    $('#success').addClass('hidden');
                    $('#error').removeClass('hidden');
                }

            }
        });
    }

    // function refreshTable() {
    //     $('#dataTable').each(function() {
    //         dt = $(this).dataTable();
    //         dt.fnDraw();
    //     })
    // }
</script>
