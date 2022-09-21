function startGame(data) {
    startSpin(data);
    $('.cmn-btn').html('<i class="la la-gear fa-spin"></i> Playing...');
    timerA = setInterval(function() {
        succOrError();
        endGame(data);
    }, 10000);
}

function startSpin(data) {
    playingAnimation();
    setpoint(data);
    theWheel.startAnimation();
    wheelSpinning = true;
}

function winnerPoint(data) {
    theWheel.stopAnimation();
    getWinnerPoint(data);
    theWheel.draw();
    wheelSpinning = false;
}

function succOrError() {
    $('.gmimg').removeClass('active');
    $('#game').find('input').not('input[name=type],input[name=_token]').val('');
    $('.cmn-btn').html('Play Now');
    $('.cmn-btn').removeAttr('disabled');
}

function setpoint(point) {
    if (point.result == 'blue') {
        theWheel.animation.stopAngle = 12;
    } else {
        theWheel.animation.stopAngle = 30;
    }
}

function getWinnerPoint(data) {
    if (data.result == 'blue') {
        theWheel.rotationAngle = 28;
    } else {
        theWheel.rotationAngle = 10;
    }
}

function runningAnimation() {
    theWheel.animation.type = 'spinOngoing';
}

function playingAnimation() {
    theWheel.animation.type = 'spinToStop';
    theWheel.animation.spins = 50;
    theWheel.animation.duration = 10; //duration
}

function beforeProcess() {
    $('.cmn-btn').html('<i class="la la-gear fa-spin"></i> Processing...');
    $('.cmn-btn').attr('disabled', '');
    $('.cd-ft').children().remove();
}

function errors(data) {
    if (data.errors) {
        notify('error', data.errors);
        succOrError();
        return true;
    }
    if (data.error) {
        notify('error', data.error);
        succOrError();
        return true;
    }
}

function success(data) {

    $('.win-loss-popup').addClass('active');
    $('.result-message').find('img').addClass('d-none');
    if (data.type == 'success') {
        $('.win-loss-popup__body').find('.win').removeClass('d-none');
        $('.win-loss-popup__body').find('.lose').addClass('d-none');
    } else {
        $('.win-loss-popup__body').find('.lose').removeClass('d-none');
        $('.win-loss-popup__body').find('.win').addClass('d-none');
    }
    $('.win-loss-popup__footer').find('.data-result').text(data.result);

    var bal = parseFloat(data.bal);
    $('.bal').html(bal.toFixed(2));
    $('.gmimg').removeClass('active');
    $('#game').find('input').not('input[name=type],input[name=_token]').val('');
}

function gameFinish(data, timerA) {
    clearInterval(timerA);
    winnerPoint(data);
    success(data);
}

$('.info-btn').click(function() {
    if ($('.info').hasClass('hide')) {
        $('.info').removeClass('hide');
        $('.info').addClass('show');
    } else {
        $('.info').removeClass('show');
        $('.info').addClass('hide');
    }
});

$('.black').click(function() {
    $('input[name=choose]').val('blue');
    $(this).addClass('active');
    $('.red').removeClass('active');
});
$('.red').click(function() {
    $('input[name=choose]').val('red');
    $(this).addClass('active');
    $('.black').removeClass('active');
});

$(window).on("load", function() {
    var theWheel = new Winwheel({
        'numSegments': 18,
        'outerRadius': 210,
        'segments': [
            { 'fillStyle': '#09097d', 'text': '' },
            { 'fillStyle': '#ff0000', 'text': '' },
            { 'fillStyle': '#09097d', 'text': '' },
            { 'fillStyle': '#ff0000', 'text': '' },
            { 'fillStyle': '#09097d', 'text': '' },
            { 'fillStyle': '#ff0000', 'text': '' },
            { 'fillStyle': '#09097d', 'text': '' },
            { 'fillStyle': '#ff0000', 'text': '' },
            { 'fillStyle': '#09097d', 'text': '' },
            { 'fillStyle': '#ff0000', 'text': '' },
            { 'fillStyle': '#09097d', 'text': '' },
            { 'fillStyle': '#ff0000', 'text': '' },
            { 'fillStyle': '#09097d', 'text': '' },
            { 'fillStyle': '#ff0000', 'text': '' },
            { 'fillStyle': '#09097d', 'text': '' },
            { 'fillStyle': '#ff0000', 'text': '' },
            { 'fillStyle': '#09097d', 'text': '' },
            { 'fillStyle': '#ff0000', 'text': '' },
        ]
    });
    runningAnimation();
    theWheel.startAnimation();
});

var theWheel = new Winwheel({
    'numSegments': 18,
    'outerRadius': 210,
    'segments': [
        { 'fillStyle': '#09097d', 'text': '' },
        { 'fillStyle': '#ff0000', 'text': '' },
        { 'fillStyle': '#09097d', 'text': '' },
        { 'fillStyle': '#ff0000', 'text': '' },
        { 'fillStyle': '#09097d', 'text': '' },
        { 'fillStyle': '#ff0000', 'text': '' },
        { 'fillStyle': '#09097d', 'text': '' },
        { 'fillStyle': '#ff0000', 'text': '' },
        { 'fillStyle': '#09097d', 'text': '' },
        { 'fillStyle': '#ff0000', 'text': '' },
        { 'fillStyle': '#09097d', 'text': '' },
        { 'fillStyle': '#ff0000', 'text': '' },
        { 'fillStyle': '#09097d', 'text': '' },
        { 'fillStyle': '#ff0000', 'text': '' },
        { 'fillStyle': '#09097d', 'text': '' },
        { 'fillStyle': '#ff0000', 'text': '' },
        { 'fillStyle': '#09097d', 'text': '' },
        { 'fillStyle': '#ff0000', 'text': '' },
    ],
});
var wheelSpinning = false;

$('input[type=number]').on('keydown', function(e) {
    if (e.keyCode == 189) {
        return false;
    }
});

function game(url, data) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        method: 'POST',
        data: data,
        success: function(data) {
            if (errors(data) == true) {
                return false;
            }
            $('.bal').text(parseFloat(data.balance).toFixed(2));
            $('audio#pop')[0].play();
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
            if (errors(data) == true) {
                return false;
            }
            gameFinish(data, timerA)

        },
    });
}