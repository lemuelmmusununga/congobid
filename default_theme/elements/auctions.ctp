<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.0/socket.io.js"></script>
	
	<ul class="horizontal-bid-list">
	<?php
 			require_once ($_SERVER['DOCUMENT_ROOT'].'/database.php');
		
	foreach($auctions as $auction):  
 	$pos = strpos($auction['Auction']['end_time'], ':');
	if($pos){ $auction['Auction']['end_time'] = strtotime($auction['Auction']['end_time']); }
	$sec_left =   $auction['Auction']['end_time'] - time();
	$sec_leftF =  strtotime($auction['Auction']['start_time']) - time();
	$is_future = ($sec_leftF > 10) ? true : false ;	
	//$pack_info = $number->prod_subs_cat_name($auction['Product']['rrp']); 
	
	$user_auc_bid_ql = "SELECT total_bids FROM user_auction_bids WHERE auction_id = '{$auction['Auction']['id']}' AND user_id = '".$session->read('Auth.User.id')."' ";
 
	$user_auc_bid_rs = mysqli_query($db, $user_auc_bid_ql);	 
	$user_auc_bid_rs1 =   mysqli_fetch_assoc($user_auc_bid_rs);
	?>
	
	
																				
	<li class="auction-item auction_<?php echo $auction['Auction']['id']; echo ($is_future) ? ' future ' : '' ; ?>   " title="<?php echo $auction['Auction']['id'];?>" id="auction_<?php echo $auction['Auction']['id'];?>"><?php if(!empty($auction['Product']['fixed'])):?><a href="<?php echo AppController::AuctionLinkFlat($auction['Auction']['id'], $auction['Product']['title']); ?>"><span class="fixed"></span></a><?php endif; ?><?php if(!empty($auction['Auction']['free'])) : ?><a href="<?php echo AppController::AuctionLinkFlat($auction['Auction']['id'], $auction['Product']['title']); ?>"><span class="free"></span></a><?php endif; ?>
		 <div class="ribbon ribbon-top-right"><span><?php __('Future');?></span></div>

		 <font></font>
		  <font></font>
		  <font></font>
		  <font></font>		 

		<i class="live_icon"><span></span></i>		
		<h3><?php echo $html->link($text->truncate($auction['Product']['title'],28), AppController::AuctionLink($auction['Auction']['id'], $auction['Product']['title']));?></h3>
	   
			
			<?php if( $auction['Auction']['add_watchlist'] == 1 || $fromWatchlist == 1  ):?>
				<div class="favorite remove"><?php echo $html->link(__('Remove  Watchlist', true), array('controller' => 'watchlists', 'action'=>'delete1', $auction['Auction']['id']), null, sprintf(__('Are you sure you want to delete the auction from your watchlist??', true), $watchlist['Watchlist']['id'])); ?></div>
			<?php else:?>
				<div class="favorite add"><?php echo $html->link(__('Add to Watchlist', true), array('controller' => 'watchlists', 'action' => 'add', $auction['Auction']['id']));?></div>
			<?php endif;?>
			
		
		
		<div class="thumb clearfix">
            	
			<?php if (1){?>
			<span class=" close_sticker close_sticker_<?php echo $appConfigurations['language']; ?>"></span>
			<div class="sold_for">
				<p><?php __('Sold for');?></p><strong class="bid-price"><?php echo $number->currency($auction['Auction']['price'],$appConfigurations['currency']); ?></strong>
			</div>
			
			<?php }?>
				<a href="<?php echo AppController::AuctionLinkFlat($auction['Auction']['id'], $auction['Product']['title']); ?>"><span class="<?php if(!empty($auction['Auction']['penny'])):?> penny<?php endif;?><?php if(!empty($auction['Auction']['peak_only'])):?> peak_only<?php endif;?><?php if(!empty($auction['Auction']['beginner'])):?> beginner<?php endif;?> <?php if(!empty($auction['Auction']['nail_bitter'])):?> nail<?php endif;?><?php if(!empty($auction['Auction']['featured'])):?> featured<?php endif;?>"></span>
				<?php
				if(!empty($auction['Product']['Image']) && !empty($auction['Product']['Image'][0]['image'])) {
					echo $html->image('product_images/max/'.$auction['Product']['Image'][0]['image']);
				} else {
					echo $html->image('product_images/thumbs/no-image.gif');
				} 
				?>
				</a>
			</div> 
			
		<label class="highlight_timer">	
		<div class="time_left"><span><?php if($is_future){ __('Starts at'); }else{ __('Time Left');  }?></span></div>
		<div class="timer_arrow price_arrow">
		<div id="pricear">
		<span class="arrow1 arrow_up ar1"></span>
		<span class="arrow1 arrow_down ar1"></span>			
		</div>
		</div>
	
		<span id="timer_<?php echo $auction['Auction']['id'];?>" class="timer countdown" >
		<?php if($is_future){ echo $time->niceshort1($auction['Auction']['start_time']); } else{ echo '--:--:--'; }    ?>
		
		</span>
		<span class="bnr_timer_calculation" style="display:none;"><?php echo $sec_left;  ?></span> 
		<span class="bnr_timer_calculationF" style="display:none;"><?php echo $sec_leftF;  ?></span> 
		<span class="future" style="display:none;"><?php echo (int) $is_future;  ?></span> 
		<span class="closed_status" style="display:none;"><?php echo $auction['Auction']['closed'] ; ?></span>
		</label>	
			
			
			
	<div class="row row_username">
	<span class="username_icon">
	<img class="logo-white"  src="<?php echo $this->webroot; ?>img/user_icon_red.png" alt="" />
	<img class="logo-black" src="<?php echo $this->webroot; ?>img/user_icon_red_black.png" alt="" />
	</span>
	
	<label class="username_highlight">	
	<span class="username bid-bidder"><?php  echo ($auction['Leader']['first_name'] !='') ? $auction['Leader']['first_name'] : 'No Bids' ;  ?></span>
	</label>	
	
	
	<span class="username_icon">
	<img class="logo-white"  src="<?php echo $this->webroot; ?>img/user_icon_red.png" alt="" />
	<img class="logo-black" src="<?php echo $this->webroot; ?>img/user_icon_red_black.png" alt="" />
	</span>
	</div>
	
	
	
	<div class="row row_price">	
	<div class="padd_lr_20">
	<div class="left_auc_content f_l price_increase_left" style="display:<?php echo (!$auction['Auction']['price_inc']) ? 'none': 'none1'; ?>">
	 
	
	
	<label class="price_highlight">
	<span class="bid-price">
	<?php echo $number->currency($auction['Auction']['price'],$appConfigurations['currency']); ?></span>
	</label>
	

	
	<p class="current_bid"><?php __('Current bid');?></p>
	<p class="current_bid winner_bid"><?php __('Winner bid');?></p>
	
	
	</div>
	
		
	<div class="left_auc_content f_r text-right">
	
	<span class="valu_price">
	<span><?php __('Value');?></span>	
	<span><label><?php echo $number->currency($auction['Product']['rrp'], $appConfigurations['currency']); ?></label></span>	
	</span>
	<p class="min_price"><?php __('Min price');?>: <strong><?php echo $number->currency($auction['Product']['minimum_price'], $appConfigurations['currency']); ?></strong></p>

	</div>	
	</div>
	</div>
	
	<p class="auc_cat">
		<?php __('Categorie');?>:
		<strong><?php echo $number->prod_subs_cat_name($auction['Product']['rrp']); ?></strong>
		 
 	</p>
	<p class="auc_cat padd_t_0">
	<?php __('Your current balance');?>:
		<strong class="bid-balance"> <?php echo $user_info['User']['bid_balance'] ; ?></strong>
		<?php __('Bonus');?>:
		<strong class="reward_points"> <?php echo $user_info['User']['rewards_points'] ; ?></strong>  
	</p>
	<p class="auc_cat padd_t_0">
		<?php __('bids placed on this auction');?>: 
		<strong class="auction-bid-balance"> <?php echo (int) $user_auc_bid_rs1['total_bids'] ; ?></strong>
	 
	</p>
		<div class="bid-msg bid-msg2">
			<div class="bid-message"></div>
			</div>
			
		    <div class="auc_btm_content blink">	
		
				 
			 
				 
			 
					 <?php if($session->check('Auth.User')):?>
						<div class="bid-loading bid-loading2" style="display: none"><?php echo $html->image('ajax-arrows.gif');?></div>
					
						<div class="bidbtn bid-button">
						<a class="b-login-new bid-button-link " title="<?php echo $auction['Auction']['id'];?>" href="/bid.php?scheck=<?php echo $csrf;?>&id=<?php echo $auction['Auction']['id'];?>">
						<span class="soon" style="<?php echo ($is_future) ? 'display:block' : 'display:none'; ?>"><?php __('Coming Soon');  ?></span>
						<span class="live" style="<?php echo (!$is_future) ? 'display:none' : 'display:block'; ?>" ><?php __('Bid Now');  ?></span>
 						 
						</a></div>
					
					
					<?php else:?>
					<div class="bidbtn bid-button"><a href="/users/login" class="b-login-new"><span><?php __('Bid Now');?></span></a></div>
					<?php endif;?>

					<div class="bidbtn bid-button sold-btn">
						<div class="neon">
						<span class="text" data-text="<?php __('Sold');?>"><?php __('Sold');?></span>
						<span class="gradient"></span>
						<span class="spotlight"></span>
						</div>
                	</div>
			 
				
                
				<div class="btn_view">
				 <a href="<?php echo AppController::AuctionLinkFlat($auction['Auction']['id'], $auction['Product']['title']); ?>"><?php __('View');?></a>
				</div>
           
			
			</div>
			

		<div class="crackers">
			<div class="before"></div>
			<div class="after"></div>
		</div>

		<?php if($auction['Auction']['block_bids'] > 0){?>
		<div class="block-bid block <?php echo ($sec_left > 600) ? 'hide' : ''; ?>" rel="<?php echo $auction['Auction']['id'] ?>" rel2="<?php echo $auction['Auction']['block_bids'] ?>" >
		    <p><img src="/img/hand-icon.png" alt="" /></p>
			<button   rel="<?php echo $auction['Auction']['id'];?>"> <strong class="hide"><?php echo $auction['Auction']['block_bids'];?></strong> <?php __('Block for 30 sec');?></button>
		</div>
		<?php } ?>
		
	</li>
	<?php endforeach;?>
	
	


</ul>