jQuery(function($) {
    $( "#ffw_events_start_date" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 3,
      dateFormat: 'yy-mm-dd'
      // onClose: function( selectedDate ) {
      //   $( "#ffw_events_end_date" ).datepicker( "option", "minDate", selectedDate );
      // }
    });
    // $( "#ffw_events_end_date" ).datepicker({
    //   defaultDate: "+1w",
    //   changeMonth: true,
    //   numberOfMonths: 3,
    //   dateFormat: 'yy-mm-dd',
    //   onClose: function( selectedDate ) {
    //     $( "#ffw_events_start_date" ).datepicker( "option", "maxDate", selectedDate );
    //   }
    // });
});