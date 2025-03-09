<input 
    type="{{ $type ?? 'text' }}" 
    class="form-control" 
    name="{{ $name }}" id="{{ $id }}" 
    placeholder="{{ $placeholder ?? '' }}" 
    value="{{ $value ?? '' }}"
    @if(!empty($read_only)) readonly @endif
>
