$('.info-btn').click(function() {
    if ($('.info').hasClass('hide')) {
        $('.info').removeClass('hide');
        $('.info').addClass('show');
    } else {
        $('.info').removeClass('show');
        $('.info').addClass('hide');
    }
});

function run(data) {
    ball1(data.result);
    ball2(data.result);
    ball3(data.result);
    ball4(data.result);
    ball5(data.result);
    ball6(data.result);
    ball7(data.result);
    ball8(data.result);
}
$('.pool-01').click(function() {
    $(this).addClass('op');
    $('.op').addClass('gmimg');
    $(this).removeClass('gmimg');
    $('.gmimg').removeClass('op');
    $('input[name=choose]').val(1);
});
$('.pool-02').click(function() {
    $(this).addClass('op');
    $('.op').addClass('gmimg');
    $(this).removeClass('gmimg');
    $('.gmimg').removeClass('op');
    $('input[name=choose]').val(2);
});
$('.pool-03').click(function() {
    $(this).addClass('op');
    $('.op').addClass('gmimg');
    $(this).removeClass('gmimg');
    $('.gmimg').removeClass('op');
    $('input[name=choose]').val(3);
});
$('.pool-04').click(function() {
    $(this).addClass('op');
    $('.op').addClass('gmimg');
    $(this).removeClass('gmimg');
    $('.gmimg').removeClass('op');
    $('input[name=choose]').val(4);
});
$('.pool-05').click(function() {
    $(this).addClass('op');
    $('.op').addClass('gmimg');
    $(this).removeClass('gmimg');
    $('.gmimg').removeClass('op');
    $('input[name=choose]').val(5);
});
$('.pool-06').click(function() {
    $(this).addClass('op');
    $('.op').addClass('gmimg');
    $(this).removeClass('gmimg');
    $('.gmimg').removeClass('op');
    $('input[name=choose]').val(6);
});
$('.pool-07').click(function() {
    $(this).addClass('op');
    $('.op').addClass('gmimg');
    $(this).removeClass('gmimg');
    $('.gmimg').removeClass('op');
    $('input[name=choose]').val(7);
});
$('.pool-08').click(function() {
    $(this).addClass('op');
    $('.op').addClass('gmimg');
    $(this).removeClass('gmimg');
    $('.gmimg').removeClass('op');
    $('input[name=choose]').val(8);
});

$('input[type=number]').on('keydown', function(e) {
    if (e.keyCode == 189) {
        return false;
    }
});

function game(data, url) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        method: 'POST',
        data: data,
        success: function(data) {
            if (data.errors) {
                notify('error', data.errors);
                issuccess();
                return false;
            }

            if (data.error) {
                notify('error', data.error);
                issuccess();
                return false;
            }
            $('.bal').text(parseFloat(data.balance).toFixed(2));
            startGame(data);
        },
    });
}

function startGame(data) {
    run(data);
    $('button[type=submit]').html('<i class="la la-gear fa-spin"></i> Playing...');
    timerA = setInterval(function() {
        issuccess();
        endGame(data);
    }, 5200);
}

function complete(data, url) {

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        method: 'POST',
        data: { 'game_id': data.game_id, 'invest': data.invest },
        success: function(data) {
            if (data.errors) {
                notify('error', data.errors);
                issuccess();
                return false;
            }

            if (data.error) {
                notify('error', data.error);
                issuccess();
                return false;
            }
            clearInterval(timerA);

            $('.win-loss-popup').addClass('active');

            $('.win-loss-popup__body').find('img').addClass('d-none')
            if (data.type == 'success') {
                $('.win-loss-popup__body').find('.win').removeClass('d-none');
            } else {
                $('.win-loss-popup__body').find('.lose').removeClass('d-none');
            }
            $('.win-loss-popup__footer').find('.data-result').text(data.result);
            bal = parseInt(data.bal);
            $('.bal').html(bal.toFixed(2));
            $('#slot-view').addClass('finish');
            $(`#ball-${data.result}`).addClass('test');

        },
    });
}


function issuccess() {
    $('.pools').find('img').removeClass('op');
    $('.pools').find('img').addClass('gmimg');
    $('#game').find('input').not('input[name=type],input[name=_token]').val('');
    $('button[type=submit]').html('Play');
    $('button[type=submit]').removeAttr('disabled');
    $('.single-select').removeClass('active op');
}

function ball1(data) {
    if (data == 1) {
        var skin = [{
                transform: 'translate(-475px, 210px)'
            },
            {
                transform: 'translate(0px,   0px)'
            },
            {
                transform: 'translate(190px,-100px)'
            },
            {
                transform: 'translate(-575px,  80px)'
            },
            {
                transform: 'translate(   0px,   0px)'
            },
            {
                transform: 'translate(0px, 0px)'
            },
        ];
    } else {
        var skin = [{
                transform: 'translate(-475px, 210px)'
            },
            {
                transform: 'translate(0px,   0px)'
            },
            {
                transform: 'translate(190px,-100px)'
            },
            {
                transform: 'translate(-575px,  80px)'
            },
            {
                transform: 'translate(   0px,   0px)'
            },
            {
                transform: 'translate(140px,-210px)'
            },
        ];
    }
    var ball1 = document.getElementById("ball-1")
    ball1.animate(skin, {
        duration: 5000,
        fill: 'forwards',
        easing: 'linear'
    });
}

function ball2(data) {
    if (data == 2) {
        var skin2 = [{
                transform: 'translate(0px,   0px)'
            },
            {
                transform: 'translate(-575px,  80px)'
            },
            {
                transform: 'translate(-475px, 210px)'
            },
            {
                transform: 'translate(140px,-210px)'
            },
            {
                transform: 'translate(190px,-100px)'
            },
            {
                transform: 'translate(0px, 0px)'
            },
        ];
    } else {
        var skin2 = [{
                transform: 'translate(0px,   0px)'
            },
            {
                transform: 'translate(-575px,  80px)'
            },
            {
                transform: 'translate(-475px, 210px)'
            },
            {
                transform: 'translate(140px,-210px)'
            },
            {
                transform: 'translate(190px,-100px)'
            },
            {
                transform: 'translate(   -575px,  80px)'
            },
        ];
    }
    var ball2 = document.getElementById("ball-2")
    ball2.animate(skin2, {
        duration: 5000,
        fill: 'forwards',
        easing: 'linear'
    });
}

function ball3(data) {
    if (data == 3) {
        var skin3 = [{
                transform: 'translate(190px,-100px)'
            },
            {
                transform: 'translate(-575px,  80px)'
            },
            {
                transform: 'translate(-475px, 210px)'
            },
            {
                transform: 'translate(140px,-210px)'
            },
            {
                transform: 'translate(0px,   0px)'
            },
            {
                transform: 'translate(0px, 0px)'
            },
        ];
    } else {
        var skin3 = [{
                transform: 'translate(190px,-100px)'
            },
            {
                transform: 'translate(-575px,  80px)'
            },
            {
                transform: 'translate(-475px, 210px)'
            },
            {
                transform: 'translate(140px,-210px)'
            },
            {
                transform: 'translate(0px,   0px)'
            },
            {
                transform: 'translate(   -575px,  80px)'
            },
        ];
    }
    var ball3 = document.getElementById("ball-3")
    ball3.animate(skin3, {
        duration: 5000,
        fill: 'forwards',
        easing: 'linear'
    });
}

function ball4(data) {
    if (data == 4) {
        var skin4 = [{
                transform: 'translate( -0px,-100px)'
            },
            {
                transform: 'translate(0px,   0px)'
            },
            {
                transform: 'translate(-575px,  -80px)'
            },
            {
                transform: 'translate(-475px, 210px)'
            },
            {
                transform: 'translate(140px,-210px)'
            },
            {
                transform: 'translate(0px, 0px)'
            },
        ];
    } else {
        var skin4 = [{
                transform: 'translate( -0px,-100px)'
            },
            {
                transform: 'translate(0px,   0px)'
            },
            {
                transform: 'translate(-575px,  -80px)'
            },
            {
                transform: 'translate(-475px, 210px)'
            },
            {
                transform: 'translate(140px,-210px)'
            },
            {
                transform: 'translate(   -575px,  -80px)'
            },
        ];
    }
    var ball4 = document.getElementById("ball-4")
    ball4.animate(skin4, {
        duration: 5000,
        fill: 'forwards',
        easing: 'linear'
    });
}

function ball5(data) {
    if (data == 5) {
        var skin5 = [{
                transform: 'translate(0px,   0px)'
            },
            {
                transform: 'translate( -0px,-100px)'
            },
            {
                transform: 'translate(-575px,  -80px)'
            },
            {
                transform: 'translate(0px,   0px)'
            },
            {
                transform: 'translate(140px,-210px)'
            },
            {
                transform: 'translate(0px, 0px)'
            },
        ];
    } else {
        var skin5 = [{
                transform: 'translate(0px,   0px)'
            },
            {
                transform: 'translate( -0px,-100px)'
            },
            {
                transform: 'translate(-575px,  -80px)'
            },
            {
                transform: 'translate(0px,   0px)'
            },
            {
                transform: 'translate(140px,-210px)'
            },
            {
                transform: 'translate(-475px, 210px)'
            },
        ];
    }
    var ball5 = document.getElementById("ball-5")
    ball5.animate(skin5, {
        duration: 5000,
        fill: 'forwards',
        easing: 'linear'
    });
}

function ball6(data) {
    if (data == 6) {
        var skin6 = [{
                transform: 'translate(-475px, 210px)'
            },
            {
                transform: 'translate(0px,   0px)'
            },
            {
                transform: 'translate(0px,   0px)'
            },
            {
                transform: 'translate(-575px,  -80px)'
            },
            {
                transform: 'translate(140px,-210px)'
            },
            {
                transform: 'translate(0px, 0px)'
            },
        ];
    } else {
        var skin6 = [{
                transform: 'translate(-475px, 210px)'
            },
            {
                transform: 'translate(0px,   0px)'
            },
            {
                transform: 'translate(475px,   0px)'
            },
            {
                transform: 'translate(-575px,  -80px)'
            },
            {
                transform: 'translate(140px,-210px)'
            },
            {
                transform: 'translate(-475px, 210px)'
            },
        ];
    }
    var ball6 = document.getElementById("ball-6")
    ball6.animate(skin6, {
        duration: 5000,
        fill: 'forwards',
        easing: 'linear'
    });
}

function ball7(data) {
    if (data == 7) {
        var skin7 = [{
                transform: 'translate(0px,   0px)'
            },
            {
                transform: 'translate(-585px, 290px)'
            },
            {
                transform: 'translate(0px,   0px)'
            },
            {
                transform: 'translate(1800px,-160px)'
            },
            {
                transform: 'translate(-575px,  -80px)'
            },
            {
                transform: 'translate(0px, 0px)'
            },
        ];
    } else {
        var skin7 = [{
                transform: 'translate(0px,   0px)'
            },
            {
                transform: 'translate(-585px, 290px)'
            },
            {
                transform: 'translate(0px,   0px)'
            },
            {
                transform: 'translate(1800px,-160px)'
            },
            {
                transform: 'translate(-575px,  -80px)'
            },
            {
                transform: 'translate(140px, 210px)'
            },
        ];
    }
    var ball7 = document.getElementById("ball-7")
    ball7.animate(skin7, {
        duration: 5000,
        fill: 'forwards',
        easing: 'linear'
    });
}

function ball8(data) {
    if (data == 8) {
        var skin8 = [{
                transform: 'translate(0px,   0px)'
            },
            {
                transform: 'translate(-0px,-100px)'
            },
            {
                transform: 'translate(-475px, -210px)'
            },
            {
                transform: 'translate(0px,   0px)'
            },
            {
                transform: 'translate(140px,-210px)'
            },
            {
                transform: 'translate(0px, 0px)'
            },
        ];
    } else {
        var skin8 = [{
                transform: 'translate(0px,   0px)'
            },
            {
                transform: 'translate(-0px,-100px)'
            },
            {
                transform: 'translate(-475px, -210px)'
            },
            {
                transform: 'translate(0px,   0px)'
            },
            {
                transform: 'translate(140px,-210px)'
            },
            {
                transform: 'translate(-575px, -120px)'
            },
        ];
    }
    var ball8 = document.getElementById("ball-8")
    ball8.animate(skin8, {
        duration: 5000,
        fill: 'forwards',
        easing: 'linear'
    });
}