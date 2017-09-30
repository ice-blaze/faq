import bootstrap from "bootstrap"
$(function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'click',
        placement: 'top',
    })
    $('[data-toggle="tooltip"]').on('shown.bs.tooltip', function (event) {
        const ev = event
        setTimeout(function(){
            $(ev.target).tooltip('hide')
	}, 1000);
    })
})
