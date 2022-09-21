

function beforeStart(){
	$('button[type=submit]').html('<i class="la la-gear fa-spin"></i> Processing...');
	$('button[type=submit]').attr('disabled','');
}


function ready(data){
	$('form').removeAttr('id');
	$('button[type=submit]').html('Guess The Number');
	$('button[type=submit]').removeAttr('disabled');
	$('.invBtn').addClass('d-none');
	$('.my-submit-btn').addClass('d-none');
	$('input[name=game_id]').val(data.game_id);
	$('.bal').html(parseFloat(data.balance).toFixed(2));
	if ($('.numberGs').hasClass('numHide')) {
		$('.numberGs').removeClass('numHide');
		$('.numberGs').addClass('numShow');
	}else{
		$('.numberGs').removeClass('numShow');
		$('.numberGs').addClass('numHide');
	}
	$('.bal-card').addClass('d-none');
	$('.min').addClass('d-none');
	$('.inp').addClass('d-none');
	$('.balan').addClass('d-none');
	$('.bons').removeClass('d-none');
	$('.chance-card').removeClass('col-md-6');
	$('.chance-card').addClass('col-md-8 col-sm-8');
}

function start(){
	$('.gmg').html('<i class="la la-gear fa-spin"></i> Processing...');
	$('button[type=submit]').attr('disabled','');
}

function gameEnd(percent){
	$('input[name=number]').val('');
	$('input[name=game_id]').val('');
	$('input[name=invest]').val('');
	$('.invBtn').removeClass('d-none');
	$('.my-submit-btn').removeClass('d-none');
	$('.my-submit-btn').html('Start Game');
	$('.bon').html(`${percent}%`); 
	if ($('.numberGs').hasClass('numHide')) {
		$('.numberGs').removeClass('numHide');
		$('.numberGs').addClass('numShow');
	}else{
		$('.numberGs').removeClass('numShow');
		$('.numberGs').addClass('numHide');
	}
	$('.bal-card').removeClass('d-none');
	$('.min').removeClass('d-none');
	$('.inp').removeClass('d-none');
	$('.balan').addClass('d-none');
	$('.bons').removeClass('d-none');
	$('.chance-card').addClass('col-md-6');
	$('.chance-card').removeClass('col-md-8 col-sm-8');
	$('.up').addClass('d-none');
	$('.down').addClass('d-none');

	$('.amf').show();
}

function play(data){
	$('.overlay').css('background',color())
	$('.gmg').html('Guess The Number');
	$('button[type=submit]').removeAttr('disabled');
	$('.text').find('h2').html(data.message);
	if (data.type == 0 && data.gameSt != 1) {
		$('audio#pop')[0].play();
		$('.up').removeClass('d-none');
		$('.down').addClass('d-none');
	}
	if (data.type == 1 && data.gameSt != 1) {
		$('audio#pop2')[0].play();
		$('.up').addClass('d-none');
		$('.down').removeClass('d-none');
	}
	if (data.win == 1) {
		$('audio#success')[0].play();
	}else{
		$('audio#lost')[0].play();
	}
	var bal = parseFloat(data.bal);
	$('.bal').html(bal.toFixed(2));
}
function errors(data){
	if (data.errors) {
		notify('error',data.errors);
		issuccess();
		return true;
	}

	if (data.error) {
		notify('error',data.error);
		issuccess();
		return true;
	}
}

function color(){
	var myArray = [
	"#00606596",
	"#654f0096",
	"#65000096",
	"#5f006596",
	"#000c659c",
	"#0057659c",
	];

	var randomItem = myArray[Math.floor(Math.random()*myArray.length)];
	return randomItem;
}

function issuccess(){
	$('.gmimg').removeClass('op');
	$('#game').find('input').not('input[name=type],input[name=_token]').val('');
	$('button[type=submit]').html('Start Game');
	$('button[type=submit]').removeAttr('disabled');
	$('input[name=invest]').removeAttr('readonly');
}

function game(data,url){
	$.ajax({
		headers:{
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url:url, 
		method:'POST',
		data:data,
		success:function(data){
			if(errors(data) == true){
				return false;
			}
			$('.amf').hide();
			$('.bal').text(parseFloat(data.balance).toFixed(2));
			ready(data);
		},
	});
}

function start(url,data,bon){
	$.ajax({
		headers:{
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url:url, 
		method:'POST',
		data:data,
		success:function(data){
			if(errors(data) == true){
				return false;
			}
			if (data.gameSt == 1) {
				gameEnd(bon);
			}else{
				$('.bon').html(data.data);
			}
			play(data);
		},
	});
}