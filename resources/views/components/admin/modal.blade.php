<div class="modal fade text-left modal-{{ $type }} " id="{{ $id }}" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel160">
                    {{ $title }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                @if (!empty($modal_body))
                    {{ $modal_body }}
                @else
                    <div class="alert alert-danger" role="alert">
                        <div class="alert-body">
                            You should use @.slot('body') for the body of the modal.
                        </div>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                @if ($btn !== 'false')
                    <button type="button"
                        class="btn @if (!empty($type)) {{ 'btn-' . $type }} @else{{ 'btn-primary' }} @endif waves-effect waves-float waves-light"
                        data-dismiss="modal">{{ $btn }}</button>
                @endif
            </div>
        </div>
    </div>
</div>
