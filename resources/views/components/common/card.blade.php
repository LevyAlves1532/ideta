<div class="card">
    @isset($card_header)
        <div class="card-header">
            {{ $card_header }}
        </div>
    @endisset

    <div class="card-body p-0">
        {{$slot}}
    </div>

    @isset($card_footer)
        <div class="card-footer">
            {{ $card_footer }}
        </div>
    @endisset
</div>
