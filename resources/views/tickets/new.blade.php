@component("components.modal",[
    'modalId' => 'new',
    'modalTitle' => 'Add ticket',
    'formId' => 'addTicketForm',
    'buttonName' => 'Save',
    'buttonId' => 'saveBtn',
    'modalSize' => 'modal-lg'
])

<div class="row">
    <div class="col-lg-6">
        Viber Number : <span class="text-danger">*</span>
        <input type="tel" name="viber_number" class="form-control input-sm" placeholder="Ex: +639123456789" value="{{ old('viber_number') }}">
    </div>
    <div class="col-lg-6">
        Department :
        <input type="hidden" name="department" value="{{ auth()->user()->department_id }}">
        <input type="text" class="form-control input-sm" value="{{ auth()->user()->department->name }}" readonly>
    </div>
    <div class="col-lg-6 mb-2">
        Title : <span class="text-danger">*</span>
        <input type="text" name="title" class="form-control input-sm" value="{{ old('title') }}">
    </div>
    <div class="col-lg-12">
        Concern : <span class="text-danger">*</span>
        <textarea name="task" class="form-control input-sm" cols="30" rows="10">{{ old('task') }}</textarea>
    </div>
    <div class="col-lg-12">
        Attachment : (optional)
        <input type="file" name="attachment" class="form-control input-sm">
    </div>
</div>
@endcomponent