@component("components.modal",[
    'modalId' => 'assign',
    'modalTitle' => 'Assign ticket',
    'formId' => 'assignForm',
    'buttonName' => 'Assign',
    'buttonId' => 'assignBtn',
    'modalSize' => 'modal-lg'
])

<div class="row">
    <input type="hidden" name="ticket_id">
    <div class="col-md-12">
        Assigned :
        <select data-placeholder="Assigned personnel" name="assigned_to" class="form-control select2" style="width: 100%;">
            <option value=""></option>
        </select>
        <div class="invalid-feedback"></div>
    </div>
    <div class="col-md-12">
        Priority :
        <select data-placeholder="Select priority" name="priority" class="form-control select2" style="width: 100%;">
            <option value=""></option>
        </select>
        <div class="invalid-feedback"></div>
    </div>
    <div class="col-md-12">
        Category :
        <select data-placeholder="Select category" name="category" class="form-control select2" style="width: 100%;">
            <option value=""></option>
        </select>
        <div class="invalid-feedback"></div>
    </div>
</div>
@endcomponent