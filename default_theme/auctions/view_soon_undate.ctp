<SCRIPT type="text/javascript" src="<?php echo $this->webroot; ?>css/slide/script.js"></SCRIPT>
 	
<link href="/css/slide/lightgallery.css" rel="stylesheet">
<link  type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css" />
 <link  type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.4/css/lightgallery.min.css"/> 
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.4/js/lightgallery-all.min.js"></script>
 
<script type="text/javascript">
$(document).ready(function(){
	
	$('ul.tabs_s li').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('ul.tabs_s li').removeClass('current');
		$('.tab-content').removeClass('current');

		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
	});

})
</script>

	
<?php 
 
$is_future =  true  ;	
	 	
?>


<style>
.bid-message{
	text-align: center;
	padding-bottom: 5px;
}
.bid_debit{
	right: 13px;
	top: 13px;
}
div.submit input{
	font-size: 17px;
	padding: 5px 20px;
}
.bidbuddy{text-align:center;float:left;width:100%;padding:0px 0px 10px 0px;}
.bidbuddy p{font-size:13px;}
.hide{display:none;}
.set_input{border-radius: 6px;
	display:inline-block;border:none;
	background:#efecec;
	height:35px;width:98px;text-align:center;
	margin-right: 10px;}
.bidbuddy label{display: inline-block;padding-right: 10px;}
#auction-details .bid-history div.submit{margin-top: 13px !important;margin-bottom: 10px !important;}
#tab-4 li {
	width:250px;
}
ul.tabs_s li:last-child{
	width: 244px;
}

.item-slick.slick-slide.slick-current.slick-active {
  outline: none !important;
}

.slider-for {
  margin-bottom:20px;
}
.slider-for img {
  width: 100%;
  min-height: 100%;
  height: 100%;
}

.slider-nav {
  margin: auto;  
  padding:0;
}

.slider-nav .item-slick {
  max-width:117px;
  margin-right:10px;
  outline: none !important;
  cursor: pointer;
  transition:all 0.5s ease-in;
}
.slider-nav .item-slick img {
  max-width: 100%;
  height: 100px;
  background-size: cover;
  background-position: center;
  transition:all 0.5s ease-in;
  opacity: 0.4;
}
.slider-nav .item-slick img:hover{
	opacity: 1;
}
.item-slick.slick-slide.slick-current.slick-active{
	opacity: 1;	
	border:1px solid #fff;
}
.item-slick.slick-slide.slick-current.slick-active img{
	opacity: 1;	
}

.slick-arrow {
  position: absolute;
  top:-250px;
  background-color: transparent;
  border:none;
  text-indent: -5000px;
  z-index: 50;
  margin-top: -12px;
  width: 27px;
  height: 44px;
  cursor: pointer;
  background-size: 27px 44px;
  background-position: center;
  background-repeat: no-repeat
}

.slick-prev {
  left: 15px;
  background: url(/img/prev.svg);
    width: 21px;
  height: 34px;
  cursor: pointer;
  background-repeat: no-repeat

}

.slick-next {
  right: 15px;
  background: url(/img/next.svg);
  width: 21px;
  height: 34px;
  cursor: pointer;
  background-repeat: no-repeat

}
.slick-slider{
	height: 100%;
}
.future a.b-login{
	background: linear-gradient(to right, #a8b6bf 0%,#d5d6d9 100%);
	color: #000;
}
.future a:hover.b-login{
	background: linear-gradient(to right, #d5d6d9 0%,#a8b6bf 100%);
	color: #000;
}
 
</style> 









<div class="box clearfix">

<div class="main_content">

<div class="step_titel">
<div class="doc_width">
<h1><?php echo $auction['Product']['title']; ?></h1>
			
</div>
</div>

<div class="doc_width  shadow_bg_des mt-0">			
<div id="auction-details">


<div class="col1">
<div class="content">	


<div id="aniimated-thumbnials" class="slider-for">
			
	<?php if(!empty($auction['Product']['Image']) && count($auction['Product']['Image']) > 0):?>
	<?php 
	$i = 0;
	foreach($auction['Product']['Image'] as $image):  $i++; 
	?>
	<a href="/img/product_images/<?php echo $image['image'];?>"><img   src="/img/product_images/<?php echo $image['image'];?>" alt="" /></a>	
	<?php endforeach;?>
	<?php endif;?>
	
	
	</div>
	
	
	<div class="slider-nav">
	<?php if(!empty($auction['Product']['Image']) && count($auction['Product']['Image']) > 0):?>
	<?php 
	$i = 0;
	foreach($auction['Product']['Image'] as $image):  $i++; 
	?>
	<div class="item-slick">	
	<img  src="/img/product_images/thumbs/<?php echo $image['image'];?>" alt="" />
	</div>
	<?php endforeach;?>
	<?php endif;?>
	</div>


                    
                
				 
                     
				</div>
			</div>
			 
			
		<div class="col2_col3 auction-item auction_<?php echo $auction['Auction']['id']; echo ($is_future) ? ' future ' : '' ;?>" id="auction_<?php echo $auction['Auction']['id'];?>">
			
		<div class="col2">			
      <div class="content">
	   <div class="content_manage_hieght">
	  <div class="blink">
	  <div class="auc_row" style="width:45%;margin-right:5%;text-align:center">
	  <div class="label2">
	  
	  <strong class="time_left">	  
	  <?php __('Starts at');?>:
	  	 
	  </strong></div>
	  
		<div  class="timer countdown"><?php  __('Soon')  ?>	</div> 
  
  
	 </div>
	  
	  <div class="auc_row">
	  <div class="label2 top_auc_price"><strong><?php __('Auction Price');?></strong></div>
	  <div class="buynoprice">	  
	  <h4 class="bid-price"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></h4>  
	  
	  <strong>  <?php echo $number->currency($auction['Product']['rrp'], $appConfigurations['currency']); ?></strong>
	  <p><?php __('Save over');?> , <?php if(empty($auction['Auction']['isFuture'])):?><?php echo $number->currency($auction['Auction']['savings']['price'], $appConfigurations['currency']);?>
		<?php endif; ?></p>
		<p class="min_price"><?php __('Min price');?>: <label><?php echo $number->currency($auction['Auction']['minimum_price'], $appConfigurations['currency']); ?></label></p>
	  </div>
	  </div>
	  
	   <div class="auc_row">
	   
	  
	  <?php if($session->check('Auth.User') && empty($auction['Auction']['isClosed'])):?>
      <?php if(!empty($watchlist)):?>
       <p class="favorite remove"><?php echo $html->link(__('Remove  Watchlist', true), array('controller' => 'watchlists', 'action'=>'delete', $watchlist['Watchlist']['id']), null, sprintf(__('Are you sure you want to delete the auction from your watchlist?', true), $watchlist['Watchlist']['id'])); ?></p>
      <?php else:?>
       <p class="favorite add"><?php echo $html->link(__('Add to Watchlist', true), array('controller' => 'watchlists', 'action' => 'add', $auction['Auction']['id']));?></p>
      <?php endif;?>
      <?php endif;?>
	  
	  
	  
	  </div>
	  
	    <div class="auc_row">
	  	<p class="auc_cat">
		<?php __('Categorie');?>:
		<strong><?php echo $number->prod_subs_cat_name($auction['Product']['rrp']); ?></strong>
		</p>
	  </div>
	  
	  
	  </div>
	  
	
	  <?php if(empty($auction['Auction']['isFuture']) && empty($auction['Auction']['isClosed'])):?>
						<div class="bid-msg">
						<div class="bid-message" style="display: none"></div>
						</div>
						<?php endif; ?>
	  
	  <div class="auc_row" style="width:100%;position: relative">
	  
	  <div class="bid-now"> 
                        
	  <a class="b-login-sold" href="javascript:void(0)"><?php __('Coming Soon');?> </a>
						 
						</div>
		  
	  </div>
	  
		
	  
	  
	  
	  <?php if($session->check('Auth.User')):?>
	  
	  <div class="add_business"> 
      <p class="eye_icon"> 	  
	  <?php if($session->check('Auth.User') && empty($auction['Auction']['isClosed'])):?>
      <?php if(!empty($watchlist)):?>
      <?php echo $html->link(__('Remove from Watchlist', true), array('controller' => 'watchlists', 'action'=>'delete', $watchlist['Watchlist']['id']), null, sprintf(__('Are you sure you want to delete the auction from your watchlist??', true), $watchlist['Watchlist']['id'])); ?>
      <?php else:?>
      <?php echo $html->link(__('Add to Watchlist', true), array('controller' => 'watchlists', 'action' => 'add', $auction['Auction']['id']));?>
      <?php endif;?>
      <?php endif;?>
		  
	   </p>
	   
	   
	<?php if($session->check('Auth.User')):?>   
	<?php
	if ($buy_it_now) { ?>
	<p class="eye_icon buy_icon">
	</p>		
	<?php } ?>
	<?php endif;?>
	   
	   
	  <p class="star_icon">
	  <?= __('Each bid reverts the timer back to') ?> 
	  <strong><?php echo $auction['Auction']['time_inc'];?></strong>s</p>
	  <p class="star_icon"><?php __('Highest bidder wins!');?></p>
	  <p class="star_icon"><?php __('DO NOT wait until there are one or two seconds left to bid!');?></p>
	  	  
	 				
       </div>
	   
	   
	   
		
		<?php endif;?>
			
	  
	  
  
			 
		
        
                      <?php if(!empty($auction['Product']['fixed']) && empty($auction['Auction']['isClosed'])):?>
							<p><?php if(!empty($auction['Auction']['free'])):?><?php __('Free listing! Costs nothing.');?> <br /><?php endif; ?>
                            <?php __('To the highest bidder, flat rate pricing:');?><span class="side_2px bold blk"><?php echo $number->currency($auction['Product']['fixed_price'], $appConfigurations['currency']);?></span><?php __('You can bid.');?>
						<?php endif; ?>
						<?php if(empty($auction['Auction']['isClosed']) && empty($auction['Auction']['isFuture']) && empty($auction['Product']['fixed'])):?>
							<div class="note" style="<?php if ($buy_it_now) { ?>margin-top:3px; <?php } ?>">
                            <div style="float:left;display:none;padding-bottom:8px;padding-left:29px;">
							<?php if(!empty($auction['Auction']['free'])):?><?php __('Free listing! Costs nothing.');?> <br />
							<?php endif; ?>

							<?php if(!isset($is_unique)): ?>
							<span style="float:left;display:none"><?= __('With each bid, the auction price') ?> <?php if ($auction['Auction']['reverse']) echo __('decreases by'); else echo __('increases by'); ?> </span>
                            
                            <span class="side_2px bold blk price-increment"><?php echo $number->currency($bidIncrease, $appConfigurations['currency']);?></span></div>
							<?php endif; ?>
							</div>
						<?php endif; ?>

                       
					

</div>		
<div class="view_inquiry">
					<span class="f_l"><?php __('Price Increment');?>
					<strong class="price-increment">
					<?php echo $number->currency($auction['Auction']['price_inc'], $appConfigurations['currency']);?> 
					</strong>
					</span>
					
					<span class="f_r">
					<?php __('Lot Number');?>
					<strong><?php echo $auction['Auction']['id'];?> </strong>
					</span>
					</div>						
					</div>
					
					
									
					
					
					
					
					<div class="informations dasktop_none">
					<ul>												
					
					<li>					
					<span><?php __('Auction Price');?> </span>
					<p><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?> </p>			
					</li>
					
					<li>					
					<span><?php __('Retail Price');?> </span>
					<p><?php echo $number->currency($auction['Product']['rrp'], $appConfigurations['currency']); ?></p>			
					</li>
					
					<li>					
					<span><?php __('Buy Now Price');?> </span>
					<p><?php echo $number->currency($auction['Product']['buy_now'], $appConfigurations['currency']); ?></p>			
					</li>
					
					<li>					
					<span><?php __('Minimum Price');?> </span>
					<p><?php echo $number->currency($auction['Product']['minimum_price'], $appConfigurations['currency']); ?></p>			
					</li>
					
					<li>					
					<span><?php __('Auction ID');?> </span>
					<p><?php echo $auction['Auction']['id'];?></p>			
					</li>
					
					<li>					
					<span><?php __('Start Time');?> </span>
					<p><?php echo $time->niceshort($auction['Auction']['start_time']);?></p>			
					</li>
					
					<li style="border:none">					
					<span><?php __('End Time');?> </span>
					<p><?php echo $time->niceshort($auction['Auction']['end_time']);?></p>			
					</li>
					
				
					
					</ul>
					</div>
					
					
					</div>
					

					
					
					
					
					
					<div class="col3_outer">
				 
				<div class="col3">
			
			
	

<div class="panes">
	<div class="shadow_bg shadow_bg_history">
	<ul class="tabs">
	<li id="bid-h" ><?php __('Bidding History');?></li>    
	<?php if(empty($auction['Auction']['isFuture']) && empty($auction['Auction']['isClosed']) && empty($auction['Auction']['nail_bitter']) && $session->check('Auth.User')):?>

	<li id="bid-b" style="display:none;"><a href="#t2"><?= __('Bid Butlers')?></a></li>
	<?php endif;?>
</ul>

	<div class="bid-history bid-histories scrollbar green_scroll" style="display: block;" id="bidHistoryTableauction_<?php echo $auction['Auction']['id'];?>">
		   <div class="overflow">
		   <table width="100%" cellpadding="0" cellspacing="0" border="0">
			   <thead>
				  <tr style="background:#fff!important;">
					 <th><label><?php __('Time');?></label></th>
					 <th><label><?php __('Bidder');?></label></th>
					 <th><label><?php __('Price');?></label></th>
				  </tr>
			   </thead>
			   
			   <tbody>
				  <?php if(!empty($bidHistories)):?>
					 <?php foreach($bidHistories as $bid):
					 $date1 = strtotime($bid['Bid']['created']) ;
					 ?>
					 <tr>
						<td><?php echo date('H:i:s',strtotime($bid['Bid']['created']));?></td>
						<td><?php echo ($bid['User']['first_name']) ? $bid['User']['first_name'] : $bid['User']['username'] ;?></td>
						<td><?php echo $number->currency($bid['Bid']['bid_val']);?></td>
					 </tr>
					 <?php endforeach;?>
				  <?php endif;?>
				  <?php if(empty($bidHistories)):?>
				  <tr><td colspan="3" align="center" style="border-bottom:0px;"><p class="align-center bold" style="padding-top:30px; color:#AAA; font-size:12px;"><label>
					  <?php __('No bids have been placed yet.');?></label></p></td></tr>
				  <?php endif;?>
			   </tbody>
		    </table>
			</div>
	</div>
	</div>
	

<?php if(empty($auction['Auction']['isFuture']) && empty($auction['Auction']['isClosed']) && empty($auction['Auction']['nail_bitter']) && $session->check('Auth.User')):?>	
<div class="shadow_bg shadow_bg_bidbuddy" style="position:relative;display: none;">                                         
<ul class="tabs">
	<li id="bid-h" style="margin-right:7px!important;"><strong style="text-transform:uppercase;"> <?php __('Bid');?> <?php __('Buddy');?></strong>  </li>
    
</ul>

	<div class="bid-history bid-histories">
	<div class="bidbuddy_new">
    <?php echo $form->create('Bidbutler', array('url' => '/bidbutlers/add/'.$auction['Auction']['id']));?>
 	<p>
	<?php __("The Bid Buddy will place bids for you while you are away. Enter the amount of bids you are willing to allow the Buddy to place, and hit 'Set'. Refresh the page to see the number of remaining bids. To adjust the number of bids in your Buddy, type in a new number and click 'Set'. Unused bids will be refunded.");?>
	  
	  <a href="/bidbutlers"> <?php __('Manage');?>   >> </a>
    </p>
			
<br style="clear:both;" />            
					
				
					
					<label for="BidbutlerBids"><?= __('Bids') ?></label>&nbsp;
					 <input class="disabled set_input" name="data[Bidbutler][bids]" type="text" maxlength="6" value="<?php echo $bb_bids  ?>" id="BidbutlerBids" />
					</fieldset>
				<div class="submit" style="display:inline-block;clear:both;float:none;"><input type="submit" value="<?= __('Set') ?>"/></div>
				</form>
				</div>
	</div>
</div> 
	<?php endif;?>			
</div>



					<div class="informations mobile_none">
					<ul>												
					
					<li>					
					<span><?php __('Auction Price');?> </span>
					<p><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?> </p>			
					</li>
					
					<li>					
					<span><?php __('Retail Price');?> </span>
					<p><?php echo $number->currency($auction['Product']['rrp'], $appConfigurations['currency']); ?></p>			
					</li>
					
					<li>					
					<span><?php __('Buy Now Price');?> </span>
					<p><?php echo $number->currency($auction['Product']['buy_now'], $appConfigurations['currency']); ?></p>			
					</li>
					
					<li>					
					<span><?php __('Minimum Price');?> </span>
					<p><?php echo $number->currency($auction['Product']['minimum_price'], $appConfigurations['currency']); ?></p>			
					</li>
					
					<li>					
					<span><?php __('Auction ID');?> </span>
					<p><?php echo $auction['Auction']['id'];?></p>			
					</li>
					
					<li>					
					<span><?php __('Start Time');?> </span>
					<p><?php echo $time->niceshort($auction['Auction']['start_time']);?></p>			
					</li>
					
					<li style="border:none">					
					<span><?php __('End Time');?> </span>
					<p><?php echo $time->niceshort($auction['Auction']['end_time']);?></p>			
					</li>
					
				
					
					</ul>
					</div>
					
 
	</div>
	</div>

					
					
					
					</div>
					
				</div>
				
				
				
				
	
	</div>
			




           
            
            
            
 

</div>









</div>








<div class="tab_con doc_width shadow_bg">
	 <div class="padd_151">
	<ul class="tabs_s">
	
	<li class="tab-link current" data-tab="tab-1">
	<i class="fa fa-file"></i><font><?php __('Product Description');?></font></li>
	
	<li class="tab-link" data-tab="tab-2"><i class="fa fa fa-truck"></i>
	<font><?php __('Shipping Information');?></font></li>

	
	
	
	
	<li class="tab-link" data-tab="tab-3"><i class="fa fa-gavel"></i>
	<font><?php __('Auction Info');?></font></li>
	</ul>	

	<div id="tab-1" class="tab-content current">
	   		 <h1><?php echo $auction['Product']['title']; ?></h1>
	<?php echo $auction['Product']['description'];?>
		</div>
    
    
    
    <div id="tab-2" class="tab-content">
	<br style="clear:both;">
       <div class="info">
			  <?php __('Shipping');?>
				 <?php if(!empty($auction['Product']['delivery_cost'])) : ?>
					<p><strong><?php echo $number->currency($auction['Product']['delivery_cost'], $appConfigurations['currency']);?></strong></p>
				 <?php endif;?>
				</div>
                
    <br class="clear_br">
	<div class="info">
				<?php __('Shipping Information');?>
				<?php if(!empty($auction['Product']['delivery_information'])) : ?>
			    <p><strong><?php echo $auction['Product']['delivery_information'];?></strong></p>
				<?php else: ?>
				<p class="align-center" style="padding:4px;"><?php __('None provided');?></p>
				<?php endif;?>
				</div>
	</div>
	


	<div id="tab-3" class="tab-content  tab_auction_info">	
	
	
	<div class="row">
	<p><?php __('Auction id');?>: <strong><?php echo $auction['Auction']['id']; ?></strong></p>
	<p><?php __('Auction Type');?>: 
	<strong>
	<?php
	$auction_type = 'Penny Auction';
	  ?>	  
	<?php echo $auction_type;?>	 
	</strong>
	</p>
	<p><?php __('Bids per bid');?>: <strong><?php echo $auction['Auction']['bid_debit'];?></strong></p>
	</div>
	
	<div class="row">
	<p><?php __('Retail Price');?>: <strong><?php echo $number->currency($auction['Product']['rrp'], $appConfigurations['currency']); ?></strong></p>
	<p><?php __('Price Increment');?>: +<strong><?php echo $number->currency($auction['Auction']['price_inc'], $appConfigurations['currency']);?></strong> 	</p>
	<p><?php __('Shipment');?>: <strong><?php echo $number->currency($auction['Product']['delivery_cost'], $appConfigurations['currency']);?></strong></p>
	</div>
	
	</div>					
		
	</div>
	</div>

	
	
	

</div>


</div>
</div>
 
<script>
if($('.productImageThumb').length){ 
		$('.productImageThumb').click(function(){  
			$('.productImageMax').fadeOut('fast').attr('src', $(this).attr('href')).fadeIn('fast');
			return false;
		});
	}
	  
$('.edit_bb_link').click(function(){  
	 $('.edt_bb').toggleClass('hide');
});
$('.prefill_bb').click(function(){  
	$('#BidbutlerBids').val($( this ).attr('rel'));
});
$('#delete_bbb').click(function(){  
	 if(confirm("Are you sure?")){
		 return true;
	 }else{
		return false; 
	 }
});
</script>

<script>

$(function() {
  
  $('#aniimated-thumbnials').lightGallery({
    thumbnail: true,
  });
// Card's slider
  var $carousel = $('.slider-for');

  $carousel
    .slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      adaptiveHeight: true,
      asNavFor: '.slider-nav'
    });
  $('.slider-nav').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    asNavFor: '.slider-for',
    dots: false,
    centerMode: false,
    focusOnSelect: true,
    variableWidth: true
  });


});

</script>


      
      
  <SCRIPT type="text/javascript">
		$(document).ready(function(){
    $(".bid-history tr:even").css("background-color","#fff");
    $(".bid-history tr:odd").css("background-color","#f0f8ff");
});
		</script>
        
         <SCRIPT type="text/javascript">
//	var parentAccordion = new TINY.accordion.slider("parentAccordion");
//	parentAccordion.init("acc", "h3", 0, 0);

var index=$('h3.acc-selected').attr('tabindex');
index=parseInt(index);
//alert(index + " is selected!"); 
	var nestedAccordion = new TINY.accordion.slider("nestedAccordion");
	nestedAccordion.init("acc", "h3", 1, index, "acc-selected");


</SCRIPT>
             
