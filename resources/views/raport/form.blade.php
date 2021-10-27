<x-app-layout>
    <x-slot name="slot">
        @if(Auth::user()->is_admin===1)
            <a href="{{ route('today.all') }}" class="btn">Operations du jour</a>
        @endif
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="text-info">Générer un rapport</h6>

            </div>
            @include('layouts.flash-message')
            <div class="card-body">
                <div class="table-responsive">
                    <form action="{{ route('report.make') }}" method="get">
                        <div class="form-group">
                            <label for="select">Pour</label>
                            <select name="action" class="form-control" id="select">
                                <option value="{{ Auth::user()->id }}">Pour moi</option>
                                @if(Auth::user()->is_admin==1)
                                    <option value="ALL">Pour tout le monde</option>
                                    @foreach($users as $key=>$item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                @endif

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="date1">Date début</label>
                            <input type="date" name="date1" class="form-control" id="date1" required>
                        </div>
                        <div class="form-group">
                            <label for="date2">Date début</label>
                            <input type="date" name="date2" class="form-control" id="date2" required>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="validate" class="btn btn-success btn-block" value="Valider">
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </x-slot>
</x-app-layout>

