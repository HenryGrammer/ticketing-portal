@component("components.modal",[
    'modalId' => 'new',
    'modalTitle' => 'Add new user',
    'formId' => 'addUserForm',
    'buttonName' => 'Save',
    'buttonId' => 'saveBtn'
])

<div class="row">
    <div class="col-md-12">
        Company :
        <select data-placeholder="Select company" name="company" class="select2 form-control"
            style="width: 100%;">
            <option value=""></option>
        </select>
        <div class="invalid-feedback"></div>
    </div>
    <div class="col-md-12">
        Departments :
        <select data-placeholder="Select departments" name="department" class="select2 form-control"
            style="width: 100%;">
            <option value=""></option>
        </select>
        <div class="invalid-feedback"></div>
    </div>
    <div class="col-md-12">
        Name :
        <input type="text" name="name" class="form-control input-sm">
        <div class="invalid-feedback"></div>
    </div>
    <div class="col-md-12">
        Email :
        <input type="email" name="email" class="form-control input-sm">
        <div class="invalid-feedback"></div>
    </div>
    <div class="col-md-12">
        Roles :
        <select data-placeholder="Select roles" name="role" class="select2 form-control" style="width: 100%;">
            <option value=""></option>
        </select>
        <div class="invalid-feedback"></div>
    </div>
</div>
@endcomponent