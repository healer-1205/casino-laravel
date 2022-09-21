$('.info-btn').click(function(){
	if ($('.info').hasClass('hide')) {
		$('.info').removeClass('hide');
		$('.info').addClass('show');
	}else{
		$('.info').removeClass('show');
		$('.info').addClass('hide');
	}
});


function sloting(pos1){
	var slot = [
	{ 
		transform: 'rotateX(324deg)' 
	},
	{ 
		transform: 'rotateX(-900deg)' 
	},
	{ 
		transform: 'rotateX(-1260deg)' 
	},
	{ 
		transform: 'rotateX(-1584deg)' 
	},
	{ 
		transform: `rotateX(${pos1}deg)` 
	},
	];

	var slotRef = document.getElementById("slot1")
	slotRef.animate(slot,{
		duration: 10000,
		fill: 'forwards',
		easing: 'linear',
		iterationCount:1
	});
}

function sloting2(pos2){
	var slot = [
	{ 
		transform: 'rotateX(324deg)' 
	},
	{ 
		transform: 'rotateX(-900deg)' 
	},
	{ 
		transform: 'rotateX(-1260deg)' 
	},
	{ 
		transform: 'rotateX(-1584deg)' 
	},
	{ 
		transform: `rotateX(${pos2}deg)` 
	},
	];

	var slotRef = document.getElementById("slot2")
	slotRef.animate(slot,{
		duration: 12000,
		fill: 'forwards',
		easing: 'linear',
		iterationCount:1
	});
}

function sloting3(pos3){
	var slot = [
	{ 
		transform: 'rotateX(324deg)' 
	},
	{ 
		transform: 'rotateX(-900deg)' 
	},
	{ 
		transform: 'rotateX(-1260deg)' 
	},
	{ 
		transform: 'rotateX(-1584deg)' 
	},
	{ 
		transform: `rotateX(${pos3}deg)` 
	},
	];

	var slotRef = document.getElementById("slot3")
	slotRef.animate(slot,{
		duration: 13000,
		fill: 'forwards',
		easing: 'linear',
		iterationCount:1
	});
}

function issuccess(){
	$('.dices').find('img').removeClass('op');
	$('#game').find('input').not('input[name=type],input[name=_token]').val('');
	$('button[type=submit]').html('Play Now');
	$('button[type=submit]').removeAttr('disabled');
}

function posSlot1(slot1){
	if (slot1 == 1) {
		var pos1 = -72;
	}

	if (slot1 == 2) {
		var pos1 = -108;
	}

	if (slot1 == 3) {
		var pos1 = -144;
	}

	if (slot1 == 4) {
		var pos1 = -180;
	}

	if (slot1 == 5) {
		var pos1 = -216;
	}

	if (slot1 == 6) {
		var pos1 = -252;
	}

	if (slot1 == 7) {
		var pos1 = -288;
	}

	if (slot1 == 8) {
		var pos1 = -324;
	}

	if (slot1 == 9) {
		var pos1 = -360;
	}

	if (slot1 == 0) {
		var pos1 = -396;
	}

	return pos1
}

function posSlot2(slot2){
	if (slot2 == 1) {
		var pos2 = -1152;
	}

	if (slot2 == 2) {
		var pos2 = -1188;
	}

	if (slot2 == 3) {
		var pos2 = -1224;
	}

	if (slot2 == 4) {
		var pos2 = -1260;
	}

	if (slot2 == 5) {
		var pos2 = -1296;
	}

	if (slot2 == 6) {
		var pos2 = -1332;
	}

	if (slot2 == 7) {
		var pos2 = -1368;
	}

	if (slot2 == 8) {
		var pos2 = -324;
	}

	if (slot2 == 9) {
		var pos2 = -360;
	}

	if (slot2 == 0) {
		var pos2 = -396;
	}

	return pos2
}

function posSlot3(slot3){
	if (slot3 == 1) {
		var pos3 = -1152;
	}

	if (slot3 == 2) {
		var pos3 = -1188;
	}

	if (slot3 == 3) {
		var pos3 = -1224;
	}

	if (slot3 == 4) {
		var pos3 = -1260;
	}

	if (slot3 == 5) {
		var pos3 = -1296;
	}

	if (slot3 == 6) {
		var pos3 = -1332;
	}

	if (slot3 == 7) {
		var pos3 = -1368;
	}

	if (slot3 == 8) {
		var pos3 = -324;
	}

	if (slot3 == 9) {
		var pos3 = -360;
	}

	if (slot3 == 0) {
		var pos3 = -396;
	}

	return pos3
}

function startGame(data){
	var pos1 = posSlot1(data.number[0]);
	var pos2 = posSlot2(data.number[1]);
	var pos3 = posSlot3(data.number[2]);
	sloting(pos1);
	sloting2(pos2);
	sloting3(pos3);
	$('button[type=submit]').html('<i class="la la-gear fa-spin"></i> Playing...');
	timerA = setInterval(function(){
		issuccess();
		endGame(data);
	},13000);
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
			if (data.errors) {
				notify('error',data.errors);
				issuccess();
				return false;
			}

			if (data.error) {
				notify('error',data.error);
				issuccess();
				return false;
			}
			$('.bal').text(parseFloat(data.balance).toFixed(2));
			startGame(data)
		},
	});
}

function complete(data,url){
	$.ajax({
		headers:{
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url:url,
		method:'POST',
		data:{'game_id':data.game_id},
		success:function(data){
			if (data.errors) {
				notify('error',data.errors);
				issuccess();
				return false;
			}

			if (data.error) {
				notify('error',data.error);
				issuccess();
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
            $('.result-message').text(`${data.message}`);
            $('.win-loss-popup__footer').find('.data-result').closest('.win-loss-popup__footer').remove();

			var bal = parseInt(data.bal);
			$('.bal').html(bal.toFixed(2));
		},
	});
}