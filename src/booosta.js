/**
 * Booosta JavaScript
 * ------------------
 */

// Datepicker
// -----------------------------------

var datepicker_defaults = { 
    locale: { 
        format: 'YYYY-MM-DD',
        applyLabel: 'Save',
        cancelLabel: 'Cancel',
        customRangeLabel: 'Custom',
        daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
        monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
    },
    autoUpdateInput: false,
};

var datepicker_ranges = { ranges: {
    'Today': [moment(), moment()],
    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
    'This Month': [moment().startOf('month'), moment().endOf('month')],
    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
}};

var datepicker_single = {
    "singleDatePicker" : true
};
var datepicker_range = {
    "linkedCalendars": false,
};

(function ($) {

    //Initialize Select2 Elements
    $('.booosta-select2').select2();
    
    var options = $.extend( {}, datepicker_defaults, datepicker_single );
    $('.booosta-datepicker').daterangepicker(options);
    $('.booosta-datepicker').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD'));
    });

    var options = $.extend( {}, datepicker_defaults, datepicker_range );
    $('.booosta-rangedatepicker').daterangepicker(options);
    $('.booosta-rangedatepicker').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });
    $('.booosta-rangedatepicker').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    var options = $.extend( {}, datepicker_defaults, datepicker_range, datepicker_ranges );
    $('.booosta-rangedatepicker-with-ranges').daterangepicker(options);
    $('.booosta-rangedatepicker-with-ranges').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });
    $('.booosta-rangedatepicker-with-ranges').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    $("input[data-bootstrap-switch]").each(function(){
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

   jQuery.validator.addMethod(
        'requiredIfNotEmpty',
        function(value, element, param) {
            var target = $( param );
            return (target.val() == '' || value != '');
        }
    );

    jQuery.validator.addMethod(
        'requireFileExtension',
        function(value, element, param) {
            if(value == '') return true;

            var extension = value.split('.').pop();
            var allowed = param.split(',');
            //console.log("extension: " + extension); console.log(allowed);
            return $.inArray(extension.toLowerCase(), allowed) > -1;
        }
    );
    
})(jQuery)
  