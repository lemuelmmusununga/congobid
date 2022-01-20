$(document).ready(function(){

var auctionObjects = new Array(); 
$('.auction-item').each(function(){
        var auctionId    = $(this).attr('id');
		
        auctionObjects[auctionId]                           = $('.' + auctionId);
       auctionObjects[auctionId]['flash-elements']         = $('.' + auctionId + ' .countdown, .' + auctionId + ' .bid-price, .' + auctionId + ' .bid-bidder');
			
        auctionObjects[auctionId]['bt']             = $('.' + auctionId + ' .bnr_timer_calculation');
        auctionObjects[auctionId]['btf']             = $('.' + auctionId + ' .bnr_timer_calculationF');
        auctionObjects[auctionId]['bid-price']             = $('.' + auctionId + ' .bid-price');
        auctionObjects[auctionId]['price-increment']             = $('.' + auctionId + ' .price-increment');
        auctionObjects[auctionId]['bid-bidder']             = $('.' + auctionId + ' .bid-bidder');
        auctionObjects[auctionId]['sold_class']             = $('.' + auctionId + ' .sold_class');
        auctionObjects[auctionId]['future']             = $('.' + auctionId + ' .future');
        auctionObjects[auctionId]['soon']             = $('.' + auctionId + ' .soon');
        auctionObjects[auctionId]['live']             = $('.' + auctionId + ' .live');
        auctionObjects[auctionId]['timer']             = $('.' + auctionId + ' .countdown');
        auctionObjects[auctionId]['block']             = $('.' + auctionId + ' .block');
        auctionObjects[auctionId]['closed_status']             = $('.' + auctionId + ' .closed_status');
        auctionObjects[auctionId]['bid-button']             = $('.' + auctionId + ' .bid-button');
        auctionObjects[auctionId]['bid-loading']             = $('.' + auctionId + ' .bid-loading');
		auctionObjects[auctionId]['bid-message']            = $('.' + auctionId + ' .bid-message'); 
		auctionObjects[auctionId]['auction-bid-balance']    = $('.' + auctionId + ' .auction-bid-balance'); 
		
		auctionObjects[auctionId]['bid-histories']          = $('#bidHistoryTable' + auctionId);
		auctionObjects[auctionId]['bid-histories-p']        = $('#bidHistoryTable' + auctionId + ' p');
		auctionObjects[auctionId]['bid-histories-tbody']    = $('#bidHistoryTable' + auctionId + ' tbody');
        
    });

    setInterval(function(){ 

    $('.auction-item').each(function(){

        var auctionId    = $(this).attr('id');

        
        var closed 	= parseInt(auctionObjects[auctionId]['closed_status'].html());
        var diff 	= parseInt(auctionObjects[auctionId]['bt'].html());
        var diff_raw 	= parseInt(auctionObjects[auctionId]['bt'].html());
        var day_text_timr 	= $('.day_text').html();
        var future 	= parseInt(auctionObjects[auctionId]['btf'].html());
		 
		if(diff < 0) diff = 0;
		var day    =  parseInt(Math.floor(diff / 86400));
		if(future <=0 ){
			  auctionObjects[auctionId].removeClass('future'); 
			  //auctionObjects[auctionId]['soon'].hide(); auctionObjects[auctionId]['live'].show();
		}
		if(diff_raw < 600){
			auctionObjects[auctionId]['block'].removeClass('hide');
		}

		if(day < 1){
			day = 0; 
			
		}else{
			day = day;
		}

		diff   -= day * 86400;
		var hour   = parseInt(Math.floor(diff / 3600));
		if(hour < 10) hour = '0'+ hour;
		diff   -= hour * 3600;

		var minute = parseInt(Math.floor(diff / 60));
		if(minute < 10) minute = '0' + minute;
		diff   -= minute * 60;

		var second = parseInt(diff);
		if(second < 10) second = '0'+second;
		
		var result =  day+ day_text_timr+' '+hour+':'+minute+':'+second;
		if(day > 0){
			var result =  day+day_text_timr+' '+hour+':'+minute+':'+second;
		}else{
			var result =   hour+':'+minute+':'+second;
		}
		
		//window.console.log(auctionId+' : '+result);
		
		if(diff_raw > 0 && future <=0 ){
			auctionObjects[auctionId]['timer'].html(result); 
		 
		}else{
			if(closed == 1){
				auctionObjects[auctionId]['timer'].html('Auction Ended'); 
				auctionObjects[auctionId].addClass('sold ');
  			}else{
				//auctionObjects[auctionId]['timer'].html('Checking..'); 
			}
		}
		 
		
        auctionObjects[auctionId]['bt'].html( parseInt(auctionObjects[auctionId]['bt'].html()) -1 ); 
        auctionObjects[auctionId]['btf'].html( parseInt(auctionObjects[auctionId]['btf'].html()) -1 ); 
         
		
    });

    }, 1000);
	
		connect();
		 
	     function connect()  
		  {
			var socket = io.connect("https://www.congobid.com:3001"), 
				 	timer;

				socket.on('error', function() 
				{
					if (!socket.connected) 
					{
						timer = window.setInterval(function() { connect() }, 7000);
					}
				});

				socket.on('connect', function() 
				{
					window.clearInterval(timer);
					$('#connected_push').html('Connected PUSH ');
					socket.on('push',function(data)
					{	
					   if(data.event == 'Block'){
							block_auc(data);
					   }else{
						   get_push_data(data);
					   }
					});
					 
					 
				});
		 }
		 
		 
		function block_auc(data){ 
			console.log('block_auc');
			console.log(data);
 			var randm = Math.round(new Date().getTime()/1000) ; 
			var html_block = '<div class="alert alert_'+ randm +'"><span class="closebtn" onclick="this.parentElement.style.display=\'none\';" >&times;</span><p> '+ data.msg +   ' </p></div><script> setTimeout(function(){  $(".alert_'+ randm +'").remove();}, 2500);</script>   ';
			
			var updated_bal = parseInt( $('.bid-balance').html() ) - parseInt(data.blk_bd) ;  
			if(updated_bal > 0) { $('.bid-balance').html( updated_bal );  } 
			
			$('.alert-outer').append(html_block );
		}	

		function get_push_data(data)	
		{ 
			 console.log(data)
			var auctionId2 = 'auction_'+data.id; 
			if(auctionObjects[auctionId2])  { 		 
				if(data.s && auctionObjects[auctionId2])  {
					auctionObjects[auctionId2]['bt'].html( data.s );
				} else{
					console.log(data.id);
				}
				if( data.auto_update != 1 )  { 
					var prs =   parseFloat(data.p).toFixed(2);

					auctionObjects[auctionId2].addClass('bid_animation').delay(2000).queue(function(next ){
						$(this).removeClass('bid_animation');
						next();
					});
					 
					auctionObjects[auctionId2]['bid-price'].html( '$'+ prs );
					if(data.pi){ auctionObjects[auctionId2]['price-increment'].html( '$'+ data.pi ); }
					auctionObjects[auctionId2]['bid-bidder'].html( data.u );
					
					auctionObjects[auctionId2]['closed_status'].html( data.cs );
					if( data.auto_update == 1 || 1 ){
						auctionObjects[auctionId2]['flash-elements'].effect("highlight", {color:"#ff0000"}, 80);
						console.log('lighting ... ') ;
					}

					

					if(page_name == 'view'){
						if(data.s > 0 ){		
							var row = '<tr><td>' + data.BC + '</td><td>' + data.BU + '</td><td>$' + prs + '</td></tr>';
							auctionObjects[auctionId2]['bid-histories-tbody'].prepend(row);
							var myremovedElems = $("#bidHistoryTable"+auctionId2+ " tr:gt(10)").remove();
						}
					}
				}else{ 
					console.log('autoupdate');
				}
			
		}
			
			/*console.log('auction id not found.', data);*/
		}
		  
		 
	
	
	 
	$('.bid-button-link').click(function(){
		 
		var aucId =  $(this).attr('title');
		var auctionElement = 'auction_' + aucId;
        
		auctionObjects[auctionElement]['bid-button'].hide(1);
		auctionObjects[auctionElement]['bid-loading'].show(1);
        
		var params = $(this).attr('href') + '&ms=' + new Date().getTime();
        
		$.ajax({
			url: params,
			dataType: 'json',
			success: function(data){
				 
				auctionObjects[auctionElement]['bid-message'].html(data.Auction.message)
				.show(1)
				.animate({
					opacity: 1.0
				}, 2000)
				.hide(1);
				if( data.Auction.message1 =='bid_placed'){
					var auc_usr_bal = parseInt( auctionObjects[auctionElement]['auction-bid-balance'].html() ) + parseInt(data.Auction.bd1) ;
					var updated_bal = parseInt( $('.bid-balance').html() ) - parseInt(data.Auction.bd) ;
					var reward_points =  parseInt(data.Auction.reward_points) ;
					if(reward_points > 0) { playAudio(); $('.reward_points').html( reward_points );  } 
					 
					if(updated_bal > 0) { $('.bid-balance').html( updated_bal );  } 
					if(data.Bid.user_id == uid ){
						auctionObjects[auctionElement]['auction-bid-balance'].html( auc_usr_bal );
					}

				}
				if( data.Auction.message1 =='no_bids'){
					window.location.href= "/packages/index?err=1";
				}
				if( data.Auction.message1 =='auction_blocked'){
					if(confirm(  data.Auction.message)){
						var params1 = '/bid.php?un_block=1&id=' + aucId ;
							$.ajax({
								url: params1,
								dataType: 'json',
								success: function(data){
									auctionObjects[auctionElement]['bid-message'].html(data.Auction.message)
									.show(1)
									.animate({
										opacity: 1.0
									}, 2000)
									.hide(1);  
								}
							});
						
					}
				}
				if( data.Auction.new_sid  > 0){
					if(confirm(  data.Auction.message)){
						window.location.href= "/pages/update_plan/"+ data.Auction.new_sid + '/' +  data.Auction.id ;
					}
				}
				auctionObjects[auctionElement]['bid-button'].show(1);
				auctionObjects[auctionElement]['bid-loading'].hide(1);
			}
		});

		return false;
	});

	$('.block').click(function(){
		var blk_bd =   $(this).attr('rel2') ;
		 if( confirm(" Voulez vous bloquer cette enchere pour "+ blk_bd +" bids   ")  ){
			var auctionElement = 'auction_' + $(this).attr('rel'); 
			var params = '/bid.php?block=1&id=' + $(this).attr('rel') ;
			$.ajax({
				url: params,
				dataType: 'json',
				success: function(data){
					auctionObjects[auctionElement]['bid-message'].html( data.Auction.message )
					.show(1)
					.animate({
						opacity: 1.0
					}, 2000)
					.hide(1);  
				}
			});
		}
 
		 return false;
	 });

	 
	
	
	
	});
	
 

    
