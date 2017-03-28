$(document).ready(function() {
    $('[data-transform=select2]').select2()
    $('[data-provide=datepicker]').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    })
    $('[data-provide=timepicker]').timepicker({
        timeFormat: 'HH:mm',
        startTime: '07:00',
        interval: '60'
    })
})
