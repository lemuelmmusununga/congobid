
<div class="step_titel">
<div class="doc_width"><h1><?php __('Fevorite Auctions'); ?></h1></div>
</div>
<div class="doc_width">
   

    <?php if(!empty($watchlists)) : ?>
    	
		
		
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.0/socket.io.js"></script>
	
	<ul class="horizontal-bid-list">
	<?php
 		//echo '<pre>';print_r($watchlists[1]);echo '</pre>'; exit;	
	foreach($watchlists as $auction): 
		//if(!$auction['Auction']['id']){ continue; }
		$auction['Product'] = $auction['Auction']['Product'];

	$pos = strpos($auction['Auction']['end_time'], ':');
if($pos){ $auction['Auction']['end_time'] = strtotime($auction['Auction']['end_time']); }
$sec_left =  $auction['Auction']['end_time'] - time();
	
	
	
	?>
	<li class="auction-item auction_<?php echo $auction['Auction']['id'];?> " title="<?php echo $auction['Auction']['id'];?>" id="auction_<?php echo $auction['Auction']['id'];?>"><?php if(!empty($auction['Product']['fixed'])):?><a href="<?php echo AppController::AuctionLinkFlat($auction['Auction']['id'], $auction['Product']['title']); ?>"><span class="fixed"></span></a><?php endif; ?><?php if(!empty($auction['Auction']['free'])) : ?><a href="<?php echo AppController::AuctionLinkFlat($auction['Auction']['id'], $auction['Product']['title']); ?>"><span class="free"></span></a><?php endif; ?>
		  <font></font>
		  <font></font>
		  <font></font>
		  <font></font>		 
		<i class="live_icon"><span></span></i>		
		<h3><?php echo $html->link($text->truncate($auction['Product']['title'],25), AppController::AuctionLink($auction['Auction']['id'], $auction['Product']['title']));?></h3>
	    
		<div class="thumb clearfix">
            	
			<?php if ($auction['Auction']['closed'] == 1){?>
			<span class="close_sticker"></span>
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
		<span id="timer_<?php echo $auction['Auction']['id'];?>" class="timer countdown clearfix" title="<?php echo $auction['Auction']['end_time'];?>">--:--:--</span>
		<span class="bnr_timer_calculation" style="display:none;"><?php echo $sec_left;  ?></span> 
		<span class="closed_status" style="display:none;"><?php echo $auction['Auction']['closed'] ; ?></span>
		</label>	
			
			
			
	<div class="row row_username">
	<span class="username_icon">
	<img class="logo-white"  src="<?php echo $this->webroot; ?>img/user_icon_red.png" alt="" />
	<img class="logo-black" src="<?php echo $this->webroot; ?>img/user_icon_red_black.png" alt="" />
	</span>
	
	<label class="username_highlight">	
	<span class="username bid-bidder"><?php  echo ($auction['Leader']['username'] !='') ? $auction['Leader']['username'] : 'No Bids' ;  ?></span>
	</label>	
	
	
	<span class="username_icon">
	<img class="logo-white"  src="<?php echo $this->webroot; ?>img/user_icon_red.png" alt="" />
	<img class="logo-black" src="<?php echo $this->webroot; ?>img/user_icon_red_black.png" alt="" />
	</span>
	</div>
	
	
	
	<div class="row row_price">	
	<div class="padd_lr_20">
	<div class="left_auc_content f_l">
	
	
	<div class="price_arrow">
	<div id="pricear">
	<span class="arrow1 arrow_up ar1"></span>
	<span class="arrow1 arrow_down ar1"></span>
	
	
	
	</div>
	</div>


	
	<label class="price_highlight">
	<span class="bid-price">
	<?php echo $number->currency($auction['Auction']['price'],$appConfigurations['currency']); ?></span>
	</label>
	</div>
	
		
	<div class="left_auc_content f_r text-right">
	
	<span class="valu_price">
	<span><?php __('Value');?></span>	
	<span><?php echo $number->currency($auction['Product']['rrp'], $appConfigurations['currency']); ?></span>	
	</span>

	</div>	
	</div>
	</div>
	
		
		    <div class="auc_btm_content blink">	
		
				 
				<?php if (!$hide_bid_button): ?>
				<?php if(!empty($auction['Auction']['isFuture'])) : ?>
                <div class="bidbtn bid-button">
					<a class="b-login-new b-login-sold" style="text-transform: uppercase;" href="#"><?php __('Soon');?></a>
                    </div>
				 <?php elseif(!empty($auction['Auction']['isClosed'])) : ?>
				<div class="bidbtn bid-button">
				<a class="b-login-new b-login-sold" href="#" style="text-transform: uppercase;"><?php __('Sold');?></a>
                </div>
				 <?php else:?>
					 <?php if($session->check('Auth.User')):?>
						<div class="bid-loading bid-loading2" style="display: none"><?php echo $html->image('ajax-arrows.gif');?></div>
						<div class="bidbtn bid-button"><a class="b-login-new bid-button-link " title="<?php echo $auction['Auction']['id'];?>" href="/bid.php?scheck=<?php echo $csrf;?>&id=<?php echo $auction['Auction']['id'];?>"><span><?php __('Bid Now');?></span></a></div>
					<?php else:?>
					<div class="bidbtn bid-button"><a href="/users/login" class="b-login-new"><span><?php __('Register or login to bid');?></span></a></div>
					<?php endif;?>
				<?php endif; ?>
				<?php endif; ?>
                
                
				<div class="btn_view">
				 <a href="<?php echo AppController::AuctionLinkFlat($auction['Auction']['id'], $auction['Product']['title']); ?>"><?php __('View');?></a>
				</div>
           
			<div class="bid-msg bid-msg2">
			<div class="bid-message"></div>
			</div>
			</div>
		
	</li>
	<?php endforeach;?>
</ul>
		
		
		
		
		<?php echo $this->element('pagination'); ?>
    <?php else: ?>
		<div class="align-center off_message">
		<p>
			<?php __('There are no live auctions at the moment.');?>
		</p>
		</div>
    <?php endif; ?>
    
	
	
	
	<br class="clear_l">
    <div class="crumb_bar">
		<?php
			$html->addCrumb(__('Live Auctions', true), '/auctions');
			echo $this->element('crumb_auction');
		?>
    </div>

  
</div>

