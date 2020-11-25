<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        {!! Form::open(['route' => 'animes.index', 'method' => 'GET', 'class' => 'w-100 inline-flex', 'id' => 'form-filter']) !!}
        <div class="col-3">
            <x-animes-select-filter :nameFilter="'genres'" :options="$genres" :filters="$filters"></x-animes-select-filter>
        </div>

        <div class="col-3">
            <x-animes-select-filter :nameFilter="'subtypes'" :options="$types" :filters="$filters"></x-animes-select-filter>
        </div>

        <div class="col-3">
            <x-animes-select-filter :nameFilter="'status'" :options="$status" :filters="$filters" :disabled="true"></x-animes-select-filter>
        </div>
        <div class="col-3">
            {{Form::submit('Filtrer', ['class' => 'btn btn-outline-dark '])}}
            {{Form::reset('Reset', ['class' => 'btn btn-outline-danger ml-5', 'id' => 'resetBtn'])}}
            {{ Form::close() }}
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
@push('script')
    <script type="text/javascript">
        $(() => {
            const resetBtn = document.querySelector('#resetBtn');
            resetBtn.addEventListener('click', () => {
                const form = document.getElementById('form-filter');
                form.reset();
           });

        });
    </script>
@endpush
