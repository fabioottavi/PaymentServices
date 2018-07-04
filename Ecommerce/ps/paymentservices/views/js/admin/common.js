// we are loading jQuery library
$(document).ready(function () {
    // listening for event on select options
    $('select#gateway_method').on('change', function () {
        var chosenOpt =$('#gateway_method').find(':selected').val();
        if (chosenOpt == 2) {
            $('.test_mode').closest('.form-group').hide();
        }
        else {
            $('.test_mode').closest('.form-group').show();
        }
    })
});