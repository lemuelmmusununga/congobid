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

			
		<h3><?php echo $html->link($text->truncate($auction['Product']['title'],28), AppController::AuctionLink($auction['Auction']['id'], $auction['Product']['title']));?></h3>
	   		
		<div class="thumb">
            	
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
			
			
			<div class="left_sec">
			<div class="cat_sec">
				<div class="row cat_name"><?php __('Categorie');?>: 
				<p><strong><?php echo $number->prod_subs_cat_name($auction['Product']['rrp']); ?></strong></p>
				</div>			
				<div class="row main_price">
					<p><?php __('Prix CongoBid');?></p>
					<h2 class="bid-price">
						<?php echo $number->currency($auction['Auction']['price'],$appConfigurations['currency']); ?>
					</h2>
				</div>	

				<div class="row sold_bid mb-0">
					<p><?php __('Prix Kinshasa');?></p>
					<h2 class="cut-price">
						550$
					</h2>
				</div>				
			</div>
			
			<div class="cat_sec soldbid_sec">
				<div class="row"><?php __('Solde (Bids)');?>: <p><strong class="sold_bid theme-color">$443</strong></p></div>
				<div class="row mb-0"><?php __('Bonus (Bids)');?>: <p><strong class="bonus_bid theme-color">$15</strong></p></div>					
			</div>

			
		
			
			</div>
			
			
	
	



			<div class="right_sec">			
				<div class="live_chat">
					<a href="#"><img src="<?php echo $this->webroot; ?>img/live_chat_icon.png" alt=""></a>
				</div>
				
				<div class="click_price">
					<div class="row">
						<p><?php __('Vous avez Cliqu');?>:</p> 
						<h2>566x</h2>	
					</div>	
				</div>				
				
				<div class="bidbtn">					
						<?php if($session->check('Auth.User')):?>
						<div class="bid-loading bid-loading2" style="display: none"><?php echo $html->image('ajax-arrows.gif');?></div>
					
						<div class="bidbtn bid-button">
						<a class="b-login-new bid-button-link " title="<?php echo $auction['Auction']['id'];?>" href="/bid.php?scheck=<?php echo $csrf;?>&id=<?php echo $auction['Auction']['id'];?>">
						<span class="soon" style="<?php echo ($is_future) ? 'display:block' : 'display:none'; ?>"><?php __('Coming Soon');  ?></span>
						<span class="live" style="<?php echo (!$is_future) ? 'display:none' : 'display:block'; ?>" ><?php __('Bid');  ?></span>
 						 
						</a></div>										
					<?php else:?>
					<div class="bidbtn bid-button"><a href="/users/login" class="b-login-new"><span><?php __('Bid');?></span></a></div>
					<?php endif;?>
				</div>
				
				
				<div class="click_price click_price2">
					<div class="row">
					<p><?php __('Prix de lenchere');?>:</p>
					<h2><span><?php echo $number->currency($auction['Product']['rrp'], $appConfigurations['currency']); ?></span></h2>	
					</div>
				</div>
				
				
				<div class="auction_click">
					<h2><?php __('Achat des Clics');?></h2>	
					<input type="text" /><span><?php __('Ok');?></span>
				</div>				
			</div>


				<div class="options">			
				<div class="row">
					<h2><?php __('Options');?>:</h2>
					<div class="row">
						<div class="item_row">
							<img src="<?php echo $this->webroot; ?>img/crown_icon.png" alt="">
							<p><span class="bid-debit">x3</span></p>
						</div>
						<div class="item_row">
							<img src="<?php echo $this->webroot; ?>img/x_icon.png" alt="">
							<p><span class="bid-debit">x5</span></p>
						</div>						
					</div>
				</div>
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

	<label class="username_highlight">	
	<span class="username bid-bidder"><?php  echo ($auction['Leader']['first_name'] !='') ? $auction['Leader']['first_name'] : 'No Bids' ;  ?></span>
	</label>	
	
	

	</div>
	
	
	

	
	
	<div style="display:none">
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
	</div>

	
	
	
		<div class="bid-msg bid-msg2">
			<div class="bid-message"></div>
			</div>

			



		<?php if($auction['Auction']['block_bids'] > 0){?>
		<div class="block-bid block <?php echo ($sec_left > 600) ? 'hide' : ''; ?>" rel="<?php echo $auction['Auction']['id'] ?>" rel2="<?php echo $auction['Auction']['block_bids'] ?>" >
		    <p><img src="/img/hand-icon.png" alt="" /></p>
			<button   rel="<?php echo $auction['Auction']['id'];?>"> <strong class="hide"><?php echo $auction['Auction']['block_bids'];?></strong> <?php __('Block for 30 sec');?></button>
		</div>
		<?php } ?>
		
		<div class="vote">
			<p class="vote_text"><?php __('Si vous  aimez cliquez sur le coeur pour que cet article passe a la prochaine enchere.');?></p>
			<p><img src="/img/heart-icon.png" alt="" /></p>
			<h2>212 <strong class="total_votes">Votes</strong></h2>
		</div>
		
		
	</li>
	<?php endforeach;?>
	
	


</ul>