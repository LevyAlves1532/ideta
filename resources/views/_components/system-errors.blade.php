@if (session('system_errors'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <div class="">
            <ul style="margin: 0">
                @foreach (session('system_errors') as $errorItem)
                    <li>{{ $errorItem }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
