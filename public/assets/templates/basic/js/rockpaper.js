$(window).on("load", function () {
    var interval = setInterval(function () {
        if ($('.sld-wrapper').hasClass('clickImgs')) {
            clearInterval(interval);
        }
        loadSlide();
    }, 1000);
});
$('.info-btn').click(function () {
    if ($('.info').hasClass('hide')) {
        $('.info').removeClass('hide');
        $('.info').addClass('show');
    } else {
        $('.info').removeClass('show');
        $('.info').addClass('hide');
    }
});

$('.rock').click(function () {
    $(this).addClass('active');
    $('.paper').removeClass('active');
    $('.scissors').removeClass('active');
    $('input[name=choose]').val('rock');
});

$('.paper').click(function () {
    $(this).addClass('active');
    $('.rock').removeClass('active');
    $('.scissors').removeClass('active');
    $('input[name=choose]').val('paper');
});

$('.scissors').click(function () {
    $(this).addClass('active');
    $('.paper').removeClass('active');
    $('.rock').removeClass('active');
    $('input[name=choose]').val('scissors');
});


function successOrError() {
    $('.single-select').removeClass('active');
    $('#game').find('input').not('input[name=type],input[name=_token]').val('');
    $('.cmn-btn').html('Play');
    $('.cmn-btn').removeAttr('disabled');
}


//functions
function mainSlider() {
    classes()
    var startTime = new Date().getTime();
    var interval = setInterval(function () {
        slides();
        if (new Date().getTime() - startTime > 5000) {
            $('.sld-wrapper').addClass('d-none');
            $('.result').removeClass('d-none');
            timer();
            clearInterval(interval);
            return;
        }
    }, 100);
}

function loadSlide() {

    if ($('.img1').hasClass('op-0') && $('.img2').hasClass('op-0')) {
        $('.img1').removeClass('op-0');
        $('.img1').addClass('op-1');
        $('.img2').addClass('op-0');
        $('.img3').addClass('op-0');
        $('.img2').removeClass('op-1');
        $('.img3').removeClass('op-1');
    } else if ($('.img2').hasClass('op-0') && $('.img3').hasClass('op-0')) {
        $('.img2').removeClass('op-0');
        $('.img2').addClass('op-1');
        $('.img1').addClass('op-0');
        $('.img3').addClass('op-0');
        $('.img1').removeClass('op-1');
        $('.img3').removeClass('op-1');
    } else if ($('.img3').hasClass('op-0') && $('.img1').hasClass('op-0')) {
        $('.img3').removeClass('op-0');
        $('.img3').addClass('op-1');
        $('.img1').addClass('op-0');
        $('.img2').addClass('op-0');
        $('.img1').removeClass('op-1');
        $('.img2').removeClass('op-1');
    }
}

function slides() {
    if ($('.img1').hasClass('op-0') && $('.img2').hasClass('op-0')) {
        $('.img1').removeClass('op-0');
        $('.img2').addClass('op-0');
        $('.img3').addClass('op-0');
    } else if ($('.img2').hasClass('op-0') && $('.img3').hasClass('op-0')) {
        $('.img2').removeClass('op-0');
        $('.img1').addClass('op-0');
        $('.img3').addClass('op-0');
    } else if ($('.img3').hasClass('op-0') && $('.img1').hasClass('op-0')) {
        $('.img3').removeClass('op-0');
        $('.img1').addClass('op-0');
        $('.img2').addClass('op-0');
    }
}

function classes() {
    $('.imgs').addClass('clickImgs');
    $('.imgs').removeClass('imgs');
    $('.sld-wrapper').removeClass('d-none');
    $('.result').addClass('d-none');
    $('.result').find('.im-1').removeClass('res-img1');
    $('.result').find('h1').addClass('opac-0');
    $('.result').find('h1').removeClass('opac-1');
    $('.result').find('.im-2').addClass('opac-0');
    $('.result').find('.im-2').removeClass('opac-1');
    $('.result').find('.im-2').removeClass('res-img2');
}

function timer() {
    setTimeout(function () {
        $('.result').find('.im-1').addClass('res-img1');
    }, 500);
    setTimeout(function () {
        $('.result').find('h1').removeClass('opac-0');
        $('.result').find('h1').addClass('opac-1');
    }, 1500);
    setTimeout(function () {
        $('.result').find('.im-2').removeClass('opac-0');
        $('.result').find('.im-2').addClass('opac-1');
        $('.result').find('.im-2').addClass('res-img2');
    }, 2500);
}

function game(data, url) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        method: 'POST',
        data: data,
        success: function (data) {
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
            console.log(data.balance);
            $('.bal').html(parseFloat(data.balance).toFixed(2));
            startGame(data);
        },
    });
}

function startGame(data) {
    mainSlider();
    $('.cmn-btn').html('<i class="la la-gear fa-spin"></i> Playing...');
    timerA = setInterval(function () {
        successOrError();
        endGame(data);
    }, 5000);
}

function images(data, img1, img2, img3) {
    if (data.result == 'rock') {
        $('.im-1').attr('src', img1);
    }
    if (data.result == 'paper') {
        $('.im-1').attr('src', img2);
    }
    if (data.result == 'scissors') {
        $('.im-1').attr('src', img3);
    }

    if (data.user_choose == 'rock') {
        $('.im-2').attr('src', img1);
    }
    if (data.user_choose == 'paper') {
        $('.im-2').attr('src', img2);
    }
    if (data.user_choose == 'scissors') {
        $('.im-2').attr('src', img3);
    }
}

function complete(data, url, imgObj) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        method: 'POST',
        data: {'game_id': data.game_id},
        success: function (data) {
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
            }else{
                $('.win-loss-popup__body').find('.lose').removeClass('d-none');
            }
            $('.win-loss-popup__footer').find('.data-result').text(data.result);
            
            var bal = parseFloat(data.bal);
            $('.bal').html(bal.toFixed(2));
            images(data, imgObj.img1, imgObj.img2, imgObj.img3);
            $('.single-select').removeClass('active');
        },
    });
}


