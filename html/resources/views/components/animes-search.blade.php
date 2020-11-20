<div class="container-fluid">
    <div class="row justify-content-center">
        {!! Form::open(['route' => 'animes.searchFilters', 'method' => 'POST', 'class' => 'w-100 inline-flex']) !!}
        <div class="col-3">
            <div class="form-group">
                <select class="form-control selectpicker" id="genres" multiple="multiple" name="genres[]" title="Choose genre(s)">
                    @foreach ($genres as $genre)
                        <option value="{{ $genre }}">
                            {{ $genre }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-3">
            <div class="form-group">
                <select class="form-control selectpicker" id="subtype" multiple="multiple" name="subtypes[]" title="Choose type(s)">
                    <option value="TV">TV</option>
                    <option value="OVA">ONA</option>
                    <option value="Movie">Movie</option>
                    <option value="Music">Music</option>
                    <option value="Special">Special</option>
                </select>
            </div>
        </div>

        <div class="col-3">
            <div class="form-group">
                <select class="form-control selectpicker" id="status" multiple="multiple" name="status[]" title="Choose statu(s)">
                    <option value="current">In progress</option>
                    <option value="finished">Finished</option>
                    <option value="unreleased">Unreleased</option>
                    <option value="tba">tba</option>
                    <option value="upcoming">Upcoming</option>
                </select>
            </div>
        </div>
        <div class="col-3">
            {{Form::submit('Filtrez', ['class' => 'btn btn-outline-dark mx-auto d-block'])}}
        </div>
    </div>
</div>

@section('css')
    <style>
    .inline-flex {
        display: inline-flex;
    }
    </style>
@endsection
