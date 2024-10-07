@extends('layouts.admin.master')
@section('title')
Edit Trip #{{ $trip->id }}
@endsection
@section('admin-additional-css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
<style>
    .datepicker-form-group {
        position: relative !important;
    }

    .datepicker-form-group .bootstrap-datetimepicker-widget {
        padding: 0 !important;
        z-index: 100 !important;
        position: absolute !important;
        border: 1px solid #dadce0;
        box-shadow: 0 7px 20px rgba(0,0,0,0.1);
    }

    .datepicker-form-group .bootstrap-datetimepicker-widget > ul {
        background-color: white !important;
    }
    
    .select2-results__options{
        text-align: start !important;
    }
    
    
</style>
<link href="{{asset('admin/assets/css/bootstrap-datetimepicker-2.min.css')}}" rel="stylesheet" />
@endsection
@section('content')
<div class="content">
    @include('layouts.admin.include.alert')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">{{ __('admin-trip.edit_trip')}}</#{{ $trip->id }}</h4>
                        <a  href="{{ url('/trips') }}" class="btn btn-primary"> {{ __('admin-trip.back')}}</a>
                    </div>
                    <div class="card-body">

                        @if(app()->getLocale() == 'ur')
                            {!! Form::model($trip, [
                                'method' => 'POST',
                                'url' => ['/ur/trips', $trip->id],
                                'class' => 'form-horizontal',
                                'files' => true
                            ]) !!}
                        @elseif(app()->getLocale() == 'ar')
                            {!! Form::model($trip, [
                                'method' => 'POST',
                                'url' => ['/ar/trips', $trip->id],
                                'class' => 'form-horizontal',
                                'files' => true
                            ]) !!}
                        @else
                            {!! Form::model($trip, [
                                'method' => 'POST',
                                'url' => ['/trips', $trip->id],
                                'class' => 'form-horizontal',
                                'files' => true
                            ]) !!}
                        @endif

                        @include ('trips.form', ['formMode' => 'edit'])

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('admin-additional-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>
<script src="{{asset('front/hijri-date-picker-bootstrap/dist/js/bootstrap-hijri-datetimepicker.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
        
        
         $('.js-example-basic-multiple').select2();
        $('#hijri-date-input-pickup').datetimepicker({
            "allowInputToggle": true,
            "showClose": true,
            "showClear": true,
            "showTodayButton": true,
            "format": "MM/DD/YYYY hh:mm:ss",
        });
        
        $('#hijri-date-input').datetimepicker({
            "allowInputToggle": true,
            "showClose": true,
            "showClear": true,
            "showTodayButton": true,
            "format": "MM/DD/YYYY hh:mm:ss",
        });

        $("#hijri-date-input").click(function(){
            $(".bootstrap-datetimepicker-widget").removeClass("dropdown-menu");
        });
        
        $("#hijri-date-input-pickup").click(function(){
            $(".bootstrap-datetimepicker-widget").removeClass("dropdown-menu");
        });

        // $("#hijri-date-input-pickup").hijriDatePicker({

        //     // timezone
        //     timeZone: 'Etc/UTC',

        //     // Date format. See moment.js docs for valid formats.
        //     format: 'YYYY/MM/DD',
        //     hijriFormat: 'iYYYY/iMM/iDD',
        //     hijriDayViewHeaderFormat: 'iMMMM iYYYY',

        //     // Changes the heading of the datepicker when in "days" view.
        //     dayViewHeaderFormat: 'MMMM YYYY',

        //     // Allows for several input formats to be valid.
        //     extraFormats: false,

        //     // Number of minutes the up/down arrow's will move the minutes value in the time picker
        //     stepping: 1,

        //     // Prevents date/time selections before this date
        //     minDate: '1950/01/01',

        //     // Prevents date/time selections after this date
        //     maxDate: '2070/01/01',

        //     // On show, will set the picker to the current date/time
        //     useCurrent: false,

        //     // Using a Bootstraps collapse to switch between date/time pickers.
        //     collapse: true,

        //     // See moment.js for valid locales.
        //     locale: 'ar-SA',

        //     // Sets the picker default date/time.
        //     defaultDate: false,

        //     // Disables selection of dates in the array, e.g. holidays
        //     disabledDates: false,

        //     // Disables selection of dates NOT in the array, e.g. holidays
        //     enabledDates: false,

        //     // Change the default icons for the pickers functions.
        //     icons: {
        //         time: 'fa fa-clock text-primary',
        //         date: 'glyphicon glyphicon-calendar',
        //         up: 'fa fa-chevron-up text-primary',
        //         down: 'fa fa-chevron-down text-primary',
        //         previous: '<<',
        //         next: '>>',
        //         today: 'اليوم',
        //         clear: 'مسح',
        //         close: 'اغلاق'
        //     },

        //     // custom tooltip text
        //     tooltips: {
        //         today: 'Go to today',
        //         clear: 'Clear selection',
        //         close: 'Close the picker',
        //         selectMonth: 'Select Month',
        //         prevMonth: 'Previous Month',
        //         nextMonth: 'Next Month',
        //         selectYear: 'Select Year',
        //         prevYear: 'Previous Year',
        //         nextYear: 'Next Year',
        //         selectDecade: 'Select Decade',
        //         prevDecade: 'Previous Decade',
        //         nextDecade: 'Next Decade',
        //         prevCentury: 'Previous Century',
        //         nextCentury: 'Next Century',
        //         pickHour: 'Pick Hour',
        //         incrementHour: 'Increment Hour',
        //         decrementHour: 'Decrement Hour',
        //         pickMinute: 'Pick Minute',
        //         incrementMinute: 'Increment Minute',
        //         decrementMinute: 'Decrement Minute',
        //         pickSecond: 'Pick Second',
        //         incrementSecond: 'Increment Second',
        //         decrementSecond: 'Decrement Second',
        //         togglePeriod: 'Toggle Period',
        //         selectTime: 'Select Time'
        //     },

        //     // Defines if moment should use scrict date parsing when considering a date to be valid
        //     useStrict: false,

        //     // Shows the picker side by side when using the time and date together
        //     sideBySide: false,

        //     // Disables the section of days of the week, e.g. weekends.
        //     daysOfWeekDisabled: [],

        //     // Shows the week of the year to the left of first day of the week
        //     calendarWeeks: false,

        //     // The default view to display when the picker is shown
        //     // Accepts: 'years','months','days'
        //     viewMode: 'days',

        //     // Changes the placement of the icon toolbar
        //     toolbarPlacement: 'default',

        //     // Show the "Today" button in the icon toolbar
        //     showTodayButton: true,

        //     // Show the "Clear" button in the icon toolbar
        //     showClear: false,

        //     // Show the "Close" button in the icon toolbar
        //     showClose: false,

        //     // On picker show, places the widget at the identifier (string) or jQuery object if the element has css position: 'relative'
        //     widgetPositioning: {
        //         horizontal: 'auto',
        //         vertical: 'auto'
        //     },

        //     // On picker show, places the widget at the identifier (string) or jQuery object **if** the element has css `position: 'relative'`
        //     widgetParent: null,

        //     // Allow date picker show event to fire even when the associated input element has the `readonly="readonly"`property.
        //     ignoreReadonly: false,

        //     // Will cause the date picker to stay open after selecting a date if no time components are being used
        //     keepOpen: false,

        //     // If `false`, the textbox will not be given focus when the picker is shown.
        //     focusOnShow: true,

        //     // Will display the picker inline without the need of a input field. This will also hide borders and shadows.
        //     inline: false,

        //     // Will cause the date picker to **not** revert or overwrite invalid dates.
        //     keepInvalid: false,

        //     // CSS selector
        //     datepickerInput: '.pickdatepickerinput',

        //     // shows switcher
        //     showSwitcher: true,

        //     // Debug mode
        //     debug: true,

        //     // If `true`, the picker will show on textbox focus and icon click when used in a button group.
        //     allowInputToggle: false,

        //     // Must be in 24 hour format. Will allow or disallow hour selections (much like `disabledTimeIntervals`) but will affect all days.
        //     disabledTimeIntervals: false,

        //     // Disable/enable hours
        //     disabledHours: false,
        //     enabledHours: false,

        //     // This will change the `viewDate` without changing or setting the selected date.
        //     viewDate: false,

        //     // Use hijri date
        //     hijri: true,

        //     // Enable/disable RTL mode
        //     isRTL: true

        // });
        
        // $("#hijri-date-input").hijriDatePicker({

        //     // timezone
        //     timeZone: 'Etc/UTC',

        //     // Date format. See moment.js docs for valid formats.
        //     format: 'YYYY/MM/DD',
        //     hijriFormat: 'iYYYY/iMM/iDD',
        //     hijriDayViewHeaderFormat: 'iMMMM iYYYY',

        //     // Changes the heading of the datepicker when in "days" view.
        //     dayViewHeaderFormat: 'MMMM YYYY',

        //     // Allows for several input formats to be valid.
        //     extraFormats: false,

        //     // Number of minutes the up/down arrow's will move the minutes value in the time picker
        //     stepping: 1,

        //     // Prevents date/time selections before this date
        //     minDate: '1950/01/01',

        //     // Prevents date/time selections after this date
        //     maxDate: '2070/01/01',

        //     // On show, will set the picker to the current date/time
        //     useCurrent: false,

        //     // Using a Bootstraps collapse to switch between date/time pickers.
        //     collapse: true,

        //     // See moment.js for valid locales.
        //     locale: 'ar-SA',

        //     // Sets the picker default date/time.
        //     defaultDate: false,

        //     // Disables selection of dates in the array, e.g. holidays
        //     disabledDates: false,

        //     // Disables selection of dates NOT in the array, e.g. holidays
        //     enabledDates: false,

        //     // Change the default icons for the pickers functions.
        //     icons: {
        //         time: 'fa fa-clock text-primary',
        //         date: 'glyphicon glyphicon-calendar',
        //         up: 'fa fa-chevron-up text-primary',
        //         down: 'fa fa-chevron-down text-primary',
        //         previous: '<<',
        //         next: '>>',
        //         today: 'اليوم',
        //         clear: 'مسح',
        //         close: 'اغلاق'
        //     },

        //     // custom tooltip text
        //     tooltips: {
        //         today: 'Go to today',
        //         clear: 'Clear selection',
        //         close: 'Close the picker',
        //         selectMonth: 'Select Month',
        //         prevMonth: 'Previous Month',
        //         nextMonth: 'Next Month',
        //         selectYear: 'Select Year',
        //         prevYear: 'Previous Year',
        //         nextYear: 'Next Year',
        //         selectDecade: 'Select Decade',
        //         prevDecade: 'Previous Decade',
        //         nextDecade: 'Next Decade',
        //         prevCentury: 'Previous Century',
        //         nextCentury: 'Next Century',
        //         pickHour: 'Pick Hour',
        //         incrementHour: 'Increment Hour',
        //         decrementHour: 'Decrement Hour',
        //         pickMinute: 'Pick Minute',
        //         incrementMinute: 'Increment Minute',
        //         decrementMinute: 'Decrement Minute',
        //         pickSecond: 'Pick Second',
        //         incrementSecond: 'Increment Second',
        //         decrementSecond: 'Decrement Second',
        //         togglePeriod: 'Toggle Period',
        //         selectTime: 'Select Time'
        //     },

        //     // Defines if moment should use scrict date parsing when considering a date to be valid
        //     useStrict: false,

        //     // Shows the picker side by side when using the time and date together
        //     sideBySide: false,

        //     // Disables the section of days of the week, e.g. weekends.
        //     daysOfWeekDisabled: [],

        //     // Shows the week of the year to the left of first day of the week
        //     calendarWeeks: false,

        //     // The default view to display when the picker is shown
        //     // Accepts: 'years','months','days'
        //     viewMode: 'days',

        //     // Changes the placement of the icon toolbar
        //     toolbarPlacement: 'default',

        //     // Show the "Today" button in the icon toolbar
        //     showTodayButton: true,

        //     // Show the "Clear" button in the icon toolbar
        //     showClear: false,

        //     // Show the "Close" button in the icon toolbar
        //     showClose: false,

        //     // On picker show, places the widget at the identifier (string) or jQuery object if the element has css position: 'relative'
        //     widgetPositioning: {
        //         horizontal: 'auto',
        //         vertical: 'auto'
        //     },

        //     // On picker show, places the widget at the identifier (string) or jQuery object **if** the element has css `position: 'relative'`
        //     widgetParent: null,

        //     // Allow date picker show event to fire even when the associated input element has the `readonly="readonly"`property.
        //     ignoreReadonly: false,

        //     // Will cause the date picker to stay open after selecting a date if no time components are being used
        //     keepOpen: false,

        //     // If `false`, the textbox will not be given focus when the picker is shown.
        //     focusOnShow: true,

        //     // Will display the picker inline without the need of a input field. This will also hide borders and shadows.
        //     inline: false,

        //     // Will cause the date picker to **not** revert or overwrite invalid dates.
        //     keepInvalid: false,

        //     // CSS selector
        //     datepickerInput: '.datepickerinput',

        //     // shows switcher
        //     showSwitcher: true,

        //     // Debug mode
        //     debug: true,

        //     // If `true`, the picker will show on textbox focus and icon click when used in a button group.
        //     allowInputToggle: false,

        //     // Must be in 24 hour format. Will allow or disallow hour selections (much like `disabledTimeIntervals`) but will affect all days.
        //     disabledTimeIntervals: false,

        //     // Disable/enable hours
        //     disabledHours: false,
        //     enabledHours: false,

        //     // This will change the `viewDate` without changing or setting the selected date.
        //     viewDate: false,

        //     // Use hijri date
        //     hijri: true,

        //     // Enable/disable RTL mode
        //     isRTL: true

        // });


    });

    $("#product_type").hide(500);
    $("#number_of_person").hide(500);
    $("#price_per_person").hide(500);
    $("#number_of_bag").hide(500);
    $("#price_per_bag").hide(500);

    if($("#shipment").is(':checked')){
        $("#product_type").show(500);
        $("#number_of_bag").show(500);
        $("#price_per_bag").show(500);
    }else{
        $("#number_of_bag").hide(500);
        $("#price_per_bag").hide(500);
        $("#input_price_per_bag").val('');
        $("#input_number_of_bag").val('');
        $('#product_type_id').val('').trigger("change");
        $("#product_type").hide(500);
    }

    $('#shipment').click(function(){

        if($(this).is(':checked')){
            $("#product_type").show(500);
            $("#number_of_bag").show(500);
            $("#price_per_bag").show(500);
        }else{
            $("#number_of_bag").hide(500);
            $("#price_per_bag").hide(500);
            $("#input_price_per_bag").val('');
            $("#input_number_of_bag").val('');
            $('#product_type_id').val('').trigger("change");
            $("#product_type").hide(500);
        }
    });

    if($("#ride").is(':checked')){
        $("#number_of_person").show(500);
        $("#price_per_person").show(500);
    }else{
        $("#number_of_person").hide(500);
        $("#price_per_person").hide(500);
        $("#input_number_of_person").val('');
        $("#input_price_per_person").val('');
    }

    $('#ride').click(function(){

        if($(this).is(':checked')){
            $("#number_of_person").show(500);
            $("#price_per_person").show(500);
        }else{
            $("#number_of_person").hide(500);
            $("#price_per_person").hide(500);
            $("#input_number_of_person").val('');
            $("#input_price_per_person").val('');
        }
    });
</script>
@endsection
