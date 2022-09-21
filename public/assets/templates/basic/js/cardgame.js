$('.info-btn').click(function(){
		if ($('.info').hasClass('hide')) {
			$('.info').removeClass('hide');
			$('.info').addClass('show');
		}else{
			$('.info').removeClass('show');
			$('.info').addClass('hide');
		}
	});
	$('.black').click(function(){
		$('input[name=choose]').val('black');
		$(this).addClass('op');
		$('.red').removeClass('op');
	});
	$('.red').click(function(){
		$('input[name=choose]').val('red');
		$(this).addClass('op');
		$('.black').removeClass('op');
	});

	function beforeProcess(){
		if ($('.flying').hasClass('d-none')) {
			$('#cards').removeClass('op');
		  	$('.res').addClass('d-none');
		}
		$('button[type=submit]').html('<i class="la la-gear fa-spin"></i> Processing...');
		$('button[type=submit]').attr('disabled','');
	}
	function errors(data){
		if (data.errors) {
			notify('error',data.errors);
			succOrError();
			return true;
		}
		if (data.error) {
			notify('error',data.error);
			succOrError();
			return true;
		}
	}

	function succOrError(){
		$('.gmimg').removeClass('op');
		$('#game').find('input').not('input[name=type],input[name=_token]').val('');
		$('button[type=submit]').html('Play');
		$('button[type=submit]').removeAttr('disabled');
		$('.single-select').removeClass('active');
        $('.single-select').removeClass('op');
        $('.single-select').find('img').removeClass('op');
	}

	function card(res){
		if (res == 'red') {
			var blackCard = [
			  "01",
			  "2",
			  "03",
			  "05",
			  "07",
			  "08",
			  "09",
			  "10",
			  "11",
			  "12",
			  "13",
			  "14",
			  "15",
			  "16",
			  "17",
			  "18",
			  "19",
			  "20",
			  "21",
			  "22",
			  "23",
			  "24",
			  "25",
			  "26",
			  "27",
			];
			var card = blackCard[Math.floor(Math.random()*blackCard.length)];
		}else{
			var redCard = [
			  "28",
			  "29",
			  "30",
			  "31",
			  "32",
			  "33",
			  "34",
			  "35",
			  "36",
			  "37",
			  "38",
			  "39",
			  "40",
			  "41",
			  "42",
			  "43",
			  "44",
			  "45",
			  "46",
			  "47",
			  "48",
			  "49",
			  "50",
			  "51",
			  "52",
			  "53",
			];
			var card = redCard[Math.floor(Math.random()*redCard.length)];
		}
		return card;
	}

	function gameFinish(data,timerA){
		clearInterval(timerA);
		setTimeout(function(){
			success(data);
		},1800);
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
				$('.bal').text(parseFloat(data.balance).toFixed(2));
				startGame(data);
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
				if(errors(data) == true){
					return false;
				}
				gameFinish(data,timerA)

			},
		});
	}