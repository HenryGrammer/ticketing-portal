@component("components.modal",[
    'modalId' => 'edit',
    'modalTitle' => 'Edit role',
    'formId' => 'updateRoleForm',
    'buttonName' => 'Update',
    'buttonId' => 'updateBtn'
])

<div class="row">
    <input type="hidden" name="id">
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