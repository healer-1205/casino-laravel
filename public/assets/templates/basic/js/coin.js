$(window).on("load", function() {
    $('.flipcoin').removeClass('animate');

    setTimeout(function() {
        $('.flipcoin').addClass('animate');
    }, 1);;
});
$('.info-btn').click(function() {
    if ($('.info').hasClass('hide')) {
        $('.info').removeClass('hide');
        $('.info').addClass('show');
    } else {
        $('.info').removeClass('show');
        $('.info').addClass('hide');
    }
});

$('input[type=number]').on('keydown', function(e) {
    if (e.keyCode == 189) {
        return false;
    }
});
$('.head').click(function() {
    $('input[name=choose]').val('head');
    $(this).addClass('active');
    $('.tail').removeClass('active');
});
$('.tail').click(function() {
    $('input[name=choose]').val('tail');
    $(this).addClass('active');
    $('.head').removeClass('active');
});

function successOrError() {
    $('.gmimg').removeClass('active');
    $('#game').find('input').not('input[name=type],input[name=_token]').val('');
    $('.cmn-btn').html('Play Now');
    $('.cmn-btn').removeAttr('disabled');
}

function flipping() {
    $('.flipcoin').removeClass('animateClick');
    setTimeout(function() {
        $('.flipcoin').addClass('animateClick');
    }, 5);
}

function startGame(data) {
    flipping();
    $('.cmn-btn').html('<i class="la la-gear fa-spin"></i> Playing...');
    timerA = setInterval(function() {
        successOrError();
        endGame(data);
    }, 15000);
}

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
                successOrError();
                return false;
            }

            if (data.error) {
                notify('error', data.error);
                successOrError();
                return false;
            }

            $('.bal').text(parseFloat(data.balance).toFixed(2));

            startGame(data);
        },
    });
}

function complete(data, url) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        method: 'POST',
        data: { 'game_id': data.game_id },
        success: function(data) {
            if (data.errors) {
                notify('error', data.errors);
                successOrError();
                return false;
            }

            if (data.error) {
                notify('error', data.error);
                successOrError();
                return false;
            }


            clearInterval(timerA);

            $('.win-loss-popup').addClass('active');
            $('.win-loss-popup__body').find('img').addClass('d-none');

            if (data.type == 'success') {
                $('.win-loss-popup__body').find('.win').removeClass('d-none');
            } else {
                $('.win-loss-popup__body').find('.lose').removeClass('d-none');
            }
            $('.win-loss-popup__footer').find('.data-result').text(data.result);


            var bal = parseFloat(data.bal);
            var n = bal.toFixed(2);
            $('.bal').html(n);
            if (data.result == 'head') {
                $('.headCoin').removeClass('d-none');
                $('.headCoin').find('.front').removeClass('d-none');
                $('.headCoin').find('.back').addClass('d-none');
                $('.tailCoin').addClass('d-none');
                $('.flpng').addClass('d-none');
            } else {
                $('.tailCoin').removeClass('d-none');
                $('.tailCoin').find('.back').addClass('d-none');
                $('.tailCoin').find('.front').removeClass('d-none');
                $('.headCoin').addClass('d-none');
                $('.flpng').addClass('d-none');
            }

        },
    });
}