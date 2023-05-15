const myModal = document.getElementById('exampleModalCenter')
const myInput = document.getElementById('start_date')

myModal.addEventListener('shown.bs.modal', () => {
  myInput.focus()
})

$(document).ready(function() {
  $('#date_timepicker_start').datetimepicker({
    format: 'Y-m-d',
    timepicker: false
  });
  
  $('#date_timepicker_end').datetimepicker({
    format: 'Y-m-d',
    timepicker: false
  });
});

jQuery(function(){
    jQuery('#date_timepicker_start').datetimepicker({
     format:'Y-m-d',
     onShow:function( ct ){
      this.setOptions({
       maxDate:jQuery('#date_timepicker_end').val()?jQuery('#date_timepicker_end').val():false
      })
     },
     timepicker:false
    });
    jQuery('#date_timepicker_end').datetimepicker({
     format:'Y-m-d',
     onShow:function( ct ){
      this.setOptions({
       minDate:jQuery('#date_timepicker_start').val()?jQuery('#date_timepicker_start').val():false
      })
     },
     timepicker:false
    });
   });