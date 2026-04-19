@component("components.modal",[
    'modalId' => 'edit',
    'modalTitle' => 'Edit comment',
    'formId' => 'editCommentForm',
    'buttonName' => 'Update comment',
    'buttonId' => 'updateBtn',
])

<div class="row">
    <input type="hidden" name="comment_id">
    <div class="col-lg-12">
        <textarea name="editComment" cols="30" rows="10"></textarea>
    </div>
</div>
@endcomponent