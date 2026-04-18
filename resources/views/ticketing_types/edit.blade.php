@component("components.modal",[
    'modalId' => 'edit',
    'modalTitle' => 'Edit ticketing types',
    'formId' => 'updateTicketingTypeForm',
    'buttonName' => 'Update',
    'buttonId' => 'updateBtn'
])

<div class="row">
    <input type="hidden" name="id">
    <div class="col-md-12">
        Name :
        <input type="text" name="name" class="form-control">
        <div class="invalid-feedback"></div>
    </div>
</div>
@endcomponent