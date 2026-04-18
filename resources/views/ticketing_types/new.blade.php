@component("components.modal",[
    'modalId' => 'new',
    'modalTitle' => 'Add new ticketing types',
    'formId' => 'addTicketingTypeForm',
    'buttonName' => 'Save',
    'buttonId' => 'saveBtn'
])

<div class="row">
    <div class="col-md-12">
        Name :
        <input type="text" name="name" class="form-control">
        <div class="invalid-feedback"></div>
    </div>
</div>
@endcomponent