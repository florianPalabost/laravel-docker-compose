<div class="form-group">
    <select @if($disabled) disabled @endif class="form-control selectpicker" id="{{$nameFilter}}" multiple="multiple" name="{{$nameFilter}}[]"
            title="Choose {{$nameFilter}}" data-actions-box="true">
        @foreach ($options as $opt)
            <option @if( $filters && isset($filters[$nameFilter]) && in_array($opt, $filters[$nameFilter])) selected @endif value="{{ $opt }}">
                {{ $opt }}
            </option>
        @endforeach
    </select>
</div>
