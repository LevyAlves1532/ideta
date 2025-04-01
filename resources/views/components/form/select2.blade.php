<select class="form-control" id="{{ $id }}" name="{{ $name }}" @if(!empty($isMutiple)) multiple @endif style="width: 100%;">
    @foreach ($options as $option)
        <option @if(in_array($option['id'], $selectedOptions)) selected @endif value="{{ $option['id'] }}">{{ $option['name'] }}</option>
    @endforeach
</select>