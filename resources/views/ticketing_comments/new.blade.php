@component("components.modal",[
    'modalId' => 'new',
    'modalTitle' => 'Add ticketing comments',
    'formId' => 'addTicketingCommentForm',
    'buttonName' => 'Save',
    'buttonId' => 'saveBtn'
])

<div class="row">
    <div class="col-md-12">
        Type :
        <select data-placeholder="Select type" name="type" class="form-control select2" style="width: 100%;">
            <option value=""></option>
        </select>
        <div class="invalid-feedback"></div>
    </div>
    <div class="col-md-12">
        Info :
        <textarea name="info" class="form-control input-sm" cols="30" rows="10"></textarea>
        <div class="invalid-feedback"></div>
    </div>
</div>
@endcomponent