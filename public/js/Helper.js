function initializeDataTable(tableId, url, type, columnHead) {
    $(tableId).DataTable({
        ordering: true,
        pageLength: 10,
        stateSave: true,
        processing: true,
        serverSide: true,
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            url: url,
            type: type
        },
        columns: columnHead
    })
}

function reloadTable(table) {
    $('#'+table).DataTable().ajax.reload();
}

function initializeAjax(method, url, data = {}, option = {}) {
    $.ajax({
        type: method,
        url: url,
        dataType:"json",
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        },
        beforeSend: function() {
            if (typeof option.beforeSend == "function") {
                option.beforeSend()
            }
        },
        success: function(response) {
            if (typeof option.success == "function") {
                option.success(response)
            }
        },
        complete: function() {
            if (typeof option.complete == "function") {
                option.complete()
            }
        },
        error: function(xhr) {
            if (typeof option.error == "function") {
                option.error(xhr)
            }
        }
    })
}

function displayError(form, errors) {
    $('#'+form+' .form-control').removeClass('is-invalid is-valid');
    $('#'+form+' .invalid-feedback').text('');
    
    $.each(errors, function (key, value) {
        let input = $('[name="' + key + '"]');
        input.addClass('is-invalid');
        
        // Handle Select2
        if (input.hasClass('select2-hidden-accessible')) {
            input.next('.select2-container').find('.select2-selection')
                .addClass('is-invalid');
        }

        input.nextAll('.invalid-feedback').first().text(value[0]);
    });
}

function successMessage(message) {
    $.toast({
        heading: 'Success',
        text: message,
        icon: 'success',
        loader: true,
        position: 'top-right'
    })
}

function errorMessage(message) {
    $.toast({
        heading: 'Error',
        text: message,
        icon: 'error',
        loader: true,
        position: 'top-right'
    })
}

function isDisableButton(buttonId, isDisabled, text) {
    $("#"+buttonId).prop("disabled", isDisabled).text(text)
}