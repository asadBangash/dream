// Start Fees Master
var fine_type = $('.fine_type').val();
if (fine_type == 0) {
    $('.percentage').hide();
    $('.fine_amount').hide();
}
else if (fine_type == 1) {
    $('.percentage').show();
    $('.fine_amount').show();
}
else if (fine_type == 2) {
    $('.percentage').hide();
    $('.fine_amount').show();
}

$('.fine_type').on('change', function (e) {
    var fine_type = $('.fine_type').val();
    if (fine_type == 0) {
        $('.percentage').hide();
        $('.fine_amount').hide();
        $('.percentage_input').val('0');
        $('.fine_amount_input').val('0');
        $('.fine_amount_input').prop('readonly', false);
    }
    else if (fine_type == 1) {
        $('.percentage').show();
        $('.fine_amount').show();
        $('.percentage_input').val('0');
        $('.fine_amount_input').val('0');
        $('.fine_amount_input').prop('readonly', true);
    }
    else if (fine_type == 2) {
        $('.percentage').hide();
        $('.fine_amount').show();
        $('.percentage_input').val('0');
        $('.fine_amount_input').val('0');
        $('.fine_amount_input').prop('readonly', false);
    }
});

$(".percentage_input").on("keypress", function (e) {
    var currentValue = String.fromCharCode(e.which);
    var finalValue = $(this).val() + currentValue;
    if (finalValue > 100) {
        e.preventDefault();
    }
});

$('.percentage_input').on('keyup', function (e) {
    var amount = $('.amount').val();
    var per = $('.percentage_input').val();
    $('.fine_amount_input').val((amount * (per / 100)).toFixed(0));
});

$('.amount').on('keyup', function (e) {
    var amount = $('.amount').val();
    var per = $('.percentage_input').val();
    $('.fine_amount_input').val((amount * (per / 100)).toFixed(0));
});
// End Fees Master