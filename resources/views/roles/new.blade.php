@component("components.modal",[
    'modalId' => 'new',
    'modalTitle' => 'Add new role',
    'formId' => 'addRoleForm',
    'buttonName' => 'Save',
    'buttonId' => 'saveBtn'
])

<div class="row">
    <div class="col-md-12">
        Code :
        <input type="text" name="code" class="form-control input-sm">
        <div class="invalid-feedback"></div>
    </div>
    <div class="col-md-12">
        Name :
        <input type="text" name="name" class="form-control input-sm">
        <div class="invalid-feedback"></div>
    </div>
</div>
@endcomponent