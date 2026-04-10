<div class="modal" id="{{ $modalId }}">
    <div class="modal-dialog @isset($modalSize) {{ $modalSize }} @endisset">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">{{$modalTitle}}</h6>
            </div>
            <form method="POST" id="{{ $formId }}">
                @csrf
                <div class="modal-body">
                    {{ $slot }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" id="{{ $buttonId }}">{{$buttonName}}</button>
                </div>
            </form>
        </div>
    </div>
</div>