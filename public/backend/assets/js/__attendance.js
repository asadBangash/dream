$(document).ready(function () {
    function currentTime() {
        let date = new Date();
        let hh = date.getHours();
        let mm = date.getMinutes();
        let ss = date.getSeconds();
        let session = "AM";

        if (hh === 0) {
            hh = 12;
        }
        if (hh == 12) {
            session = "PM";
        }
        if (hh > 12) {
            hh = hh - 12;
            session = "PM";
        }

        hh = (hh < 10) ? "0" + hh : hh;
        mm = (mm < 10) ? "0" + mm : mm;
        ss = (ss < 10) ? "0" + ss : ss;

        let time = hh + ":" + mm + ":" + ss + " " + session;
        $('.clock').html(time);
        // document.getElementById("clock").innerText = time;
        let t = setTimeout(function () { currentTime() }, 1000);
    }
    currentTime();
});

var url = $('#url').val();
var _token = $('meta[name="csrf-token"]').attr('content');


function btnHold() {
    let duration = 1600,
        success = button => {
            //Success function
            $('.progress').hide();
            button.classList.add('success');
            checkIn($('#form_url').val());
        };
    document.querySelectorAll('.button-hold').forEach(button => {
        button.style.setProperty('--duration', duration + 'ms');
        ['mousedown', 'touchstart', 'keypress'].forEach(e => {
            button.addEventListener(e, ev => {
                if (e != 'keypress' || (e == 'keypress' && ev.which == 32 && !button
                    .classList.contains('process'))) {
                    button.classList.add('process');
                    button.timeout = setTimeout(success, duration, button);
                }
            });
        });
        ['mouseup', 'mouseout', 'touchend', 'keyup'].forEach(e => {
            button.addEventListener(e, ev => {
                if (e != 'keyup' || (e == 'keyup' && ev.which == 32)) {
                    button.classList.remove('process');
                    clearTimeout(button.timeout);
                }
            }, false);
        });
    });

}
btnHold();
var checkUrl;
var checkIn = (url) => {
    checkUrl = url;
    if (navigator?.geolocation) {
        navigator.geolocation.getCurrentPosition(attendanceStore, positionError, { timeout: 10000 });
    } else {
        console.log("Geolocation is not supported by this browser.");
    }
}

function positionError(error) {
    $('.progress').show();
    $('#button-hold').removeClass('success');

    attendanceStore();
}

function attendanceStore(position = null) {
        
    $.ajax({
        type: "POST",
        dataType: 'json',
        data: { message: $('#reason').val() },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: checkUrl,
        success: function (data) {
            Toast.fire({
                icon: 'success',
                title: data.message,
                timer: 1500,
            })
            $('#lead-modal').modal('hide');
        },
        error: function (data) {
            Toast.fire({
                icon: 'error',
                title: 'Something went wrong!',
                timer: 1500,
            })
        }
    });
}




