@component("components.modal",[
    'modalId' => 'edit',
    'modalTitle' => 'Edit departments',
    'formId' => 'updateDepartmentForm',
    'buttonName' => 'Update',
    'buttonId' => 'updateBtn'
])

<div class="row">
    <input type="hidden" name="id">
    <div class="col-md-12">
        Company :
        <select data-placeholder="Select company" name="company" class="select2 form-control" style="width: 100%;">
            <option value=""></option>
        </select>
        <div class="invalid-feedback"></div>
    </div>
    <div class="col-md-12">
        Users :
        <select data-placeholder="Select users" name="user" class="select2 form-control" style="width: 100%;">
            <option value=""></option>
        </select>
        <div class="invalid-feedback"></div>
    </div>
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