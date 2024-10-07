@extends('layouts.admin.master')
@section('title')
User Edit # {{ $user->name }}
@endsection
@section('admin-additional-css')

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
<style type="text/css">
	#user_image{
        opacity: 1 !important;
		position: unset;
	}
	/* .form-group input[type=file]{
        opacity: 1 !important;
		position: relative !important;
		z-index: 1 !important;
	} */
	#userImg{
        width: 200px;
		height: 200px;
	}

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

<link href="{{asset('front/hijri-date-picker-bootstrap/dist/css/bootstrap-datetimepicker.css')}}" rel="stylesheet" />
@endsection
@section('content')
<div class="content">
    @include('layouts.admin.include.alert')
	<div class="container-fluid">
	  	<div class="row">
		    <div class="col-md-12">
	          	<div class="card">
		            <div class="card-header card-header-primary">
		              	<h4 class="card-title ">Profile # {{ $user->name }}</h4>
		            </div>
		            <div class="card-body">
		            	<a href="{{ url('/home') }}" title="Back">
		            		<button class="btn btn-warning btn-sm">
		            			<i class="fa fa-arrow-left" aria-hidden="true"></i>
		            		</button>
		            	</a>
                        <br />
                        <br />

                        <form action="{{ app()->getLocale() == 'ur' ? url('/ur/update-profile/' . $user->id) : (app()->getLocale() == 'ar' ? url('/ar/update-profile/' . $user->id) : url('/update-profile/' . $user->id)) }}" 
                            method="POST" 
                            class="form-horizontal" 
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" value="PATCH">

                            @if($user->hasrole('admin'))
                                @include('users.update-admin-profile', ['formMode' => 'edit'])
                            @else
                                @include('users.update-driver-profile', ['formMode' => 'edit'])
                            @endif

                        </form>

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


<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();

        $("#hijri-date-input").click(function(){
            $(".bootstrap-datetimepicker-widget").removeClass("dropdown-menu");
            // $(".bootstrap-datetimepicker-widget").addClass("show");
        });

        $(".hijri-date-input").hijriDatePicker({

            // timezone
            timeZone: 'Etc/UTC',

            // Date format. See moment.js docs for valid formats.
            format: 'YYYY/MM/DD',
            hijriFormat: 'iYYYY/iMM/iDD',
            hijriDayViewHeaderFormat: 'iMMMM iYYYY',

            // Changes the heading of the datepicker when in "days" view.
            dayViewHeaderFormat: 'MMMM YYYY',

            // Allows for several input formats to be valid.
            extraFormats: false,

            // Number of minutes the up/down arrow's will move the minutes value in the time picker
            stepping: 1,

            // Prevents date/time selections before this date
            minDate: '1950/01/01',

            // Prevents date/time selections after this date
            maxDate: '2070/01/01',

            // On show, will set the picker to the current date/time
            useCurrent: false,

            // Using a Bootstraps collapse to switch between date/time pickers.
            collapse: true,

            // See moment.js for valid locales.
            locale: 'ar-SA',

            // Sets the picker default date/time.
            defaultDate: false,

            // Disables selection of dates in the array, e.g. holidays
            disabledDates: false,

            // Disables selection of dates NOT in the array, e.g. holidays
            enabledDates: false,

            // Change the default icons for the pickers functions.
            icons: {
                time: 'fa fa-clock text-primary',
                date: 'glyphicon glyphicon-calendar',
                up: 'fa fa-chevron-up text-primary',
                down: 'fa fa-chevron-down text-primary',
                previous: '<<',
                next: '>>',
                today: 'اليوم',
                clear: 'مسح',
                close: 'اغلاق'
            },

            // custom tooltip text
            tooltips: {
                today: 'Go to today',
                clear: 'Clear selection',
                close: 'Close the picker',
                selectMonth: 'Select Month',
                prevMonth: 'Previous Month',
                nextMonth: 'Next Month',
                selectYear: 'Select Year',
                prevYear: 'Previous Year',
                nextYear: 'Next Year',
                selectDecade: 'Select Decade',
                prevDecade: 'Previous Decade',
                nextDecade: 'Next Decade',
                prevCentury: 'Previous Century',
                nextCentury: 'Next Century',
                pickHour: 'Pick Hour',
                incrementHour: 'Increment Hour',
                decrementHour: 'Decrement Hour',
                pickMinute: 'Pick Minute',
                incrementMinute: 'Increment Minute',
                decrementMinute: 'Decrement Minute',
                pickSecond: 'Pick Second',
                incrementSecond: 'Increment Second',
                decrementSecond: 'Decrement Second',
                togglePeriod: 'Toggle Period',
                selectTime: 'Select Time'
            },

            // Defines if moment should use scrict date parsing when considering a date to be valid
            useStrict: false,

            // Shows the picker side by side when using the time and date together
            sideBySide: false,

            // Disables the section of days of the week, e.g. weekends.
            daysOfWeekDisabled: [],

            // Shows the week of the year to the left of first day of the week
            calendarWeeks: false,

            // The default view to display when the picker is shown
            // Accepts: 'years','months','days'
            viewMode: 'days',

            // Changes the placement of the icon toolbar
            toolbarPlacement: 'default',

            // Show the "Today" button in the icon toolbar
            showTodayButton: false,

            // Show the "Clear" button in the icon toolbar
            showClear: false,

            // Show the "Close" button in the icon toolbar
            showClose: false,

            // On picker show, places the widget at the identifier (string) or jQuery object if the element has css position: 'relative'
            widgetPositioning: {
                horizontal: 'auto',
                vertical: 'auto'
            },

            // On picker show, places the widget at the identifier (string) or jQuery object **if** the element has css `position: 'relative'`
            widgetParent: null,

            // Allow date picker show event to fire even when the associated input element has the `readonly="readonly"`property.
            ignoreReadonly: false,

            // Will cause the date picker to stay open after selecting a date if no time components are being used
            keepOpen: false,

            // If `false`, the textbox will not be given focus when the picker is shown.
            focusOnShow: true,

            // Will display the picker inline without the need of a input field. This will also hide borders and shadows.
            inline: false,

            // Will cause the date picker to **not** revert or overwrite invalid dates.
            keepInvalid: false,

            // CSS selector
            datepickerInput: '.datepickerinput',

            // shows switcher
            showSwitcher: false,

            // Debug mode
            debug: true,

            // If `true`, the picker will show on textbox focus and icon click when used in a button group.
            allowInputToggle: false,

            // Must be in 24 hour format. Will allow or disallow hour selections (much like `disabledTimeIntervals`) but will affect all days.
            disabledTimeIntervals: false,

            // Disable/enable hours
            disabledHours: false,
            enabledHours: false,

            // This will change the `viewDate` without changing or setting the selected date.
            viewDate: false,

            // Use hijri date
            hijri: true,

            // Enable/disable RTL mode
            isRTL: true

        });

    });



</script>
@endsection
