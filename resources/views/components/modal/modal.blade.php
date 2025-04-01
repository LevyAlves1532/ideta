<div class="modal fade" id="{{ $id }}" style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                {{ $modal_header ?? '' }}
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {{ $slot }}
        </div>
    </div>
</div>
