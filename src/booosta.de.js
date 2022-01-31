/**
 * Booosta JavaScript
 * ------------------
 */

// Datepicker
// -----------------------------------

var datepicker_defaults = { 
    locale: { 
        format: 'DD.MM.YYYY',
        applyLabel: 'Speichern',
        cancelLabel: 'Abbrechen',
        customRangeLabel: 'Eigene',
        daysOfWeek: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr','Sa'],
        monthNames: ['Jänner', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
    },
    autoUpdateInput: false,
};

var datepicker_ranges = { ranges: {
    'Heute': [moment(), moment()],
    'Gestern': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
    'Letzte 7 Tage': [moment().subtract(6, 'days'), moment()],
    'Letzte 30 Tage': [moment().subtract(29, 'days'), moment()],
    'Dieses Monat': [moment().startOf('month'), moment().endOf('month')],
    'Letztes Monat': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
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
        $(this).val(picker.startDate.format('DD.MM.YYYY'));
    });

    var options = $.extend( {}, datepicker_defaults, datepicker_range );
    $('.booosta-rangedatepicker').daterangepicker(options);
    $('.booosta-rangedatepicker').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD.MM.YYYY') + ' - ' + picker.endDate.format('DD.MM.YYYY'));
    });
    $('.booosta-rangedatepicker').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    var options = $.extend( {}, datepicker_defaults, datepicker_range, datepicker_ranges );
    $('.booosta-rangedatepicker-with-ranges').daterangepicker(options);
    $('.booosta-rangedatepicker-with-ranges').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD.MM.YYYY') + ' - ' + picker.endDate.format('DD.MM.YYYY'));
    });
    $('.booosta-rangedatepicker-with-ranges').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    $("input[data-bootstrap-switch]").each(function(){
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

    jQuery.validator.addMethod(
        "dateDE",
        function(value, element) {
            var check = false;
            var re = /^\d{1,2}\.\d{1,2}\.\d{4}$/;
            if( re.test(value)){
                var adata = value.split('.');
                var dd = parseInt(adata[0],10);
                var mm = parseInt(adata[1],10);
                var yyyy = parseInt(adata[2],10);
                var xdata = new Date(yyyy,mm-1,dd);
                if ( ( xdata.getFullYear() == yyyy ) && ( xdata.getMonth () == mm - 1 ) && ( xdata.getDate() == dd ) )
                    check = true;
                else
                    check = false;
            } else
                check = false;
            return this.optional(element) || check;
        },
        "Gültiges Datum erforderlich!"
    );
	
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
  