<table class="table {{ $class ?? '' }}">
    <thead>
        <tr>
            @foreach ($columns as $column)
                <th style="{{ $column['style'] ?? '' }}">{{ $column['label'] }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        {{ $slot }}
    </tbody>
</table>