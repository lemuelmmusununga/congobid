  <ul class="horizontal-bid-list">
	<?php
$bid_debit = mysql_fetch_array(mysql_query("SELECT bid_debit FROM setting_increments WHERE product_id = '0'"), MYSQL_ASSOC);
			
	foreach($auctions as $auction):?>
	<li class="auction-item" title="<?php echo $auction['Auction']['id'];?>" id="auction_<?php echo $auction['Auction']['id'];?>"><?php if(!empty($auction['Product']['fixed'])):?><a href="<?php echo AppController::AuctionLinkFlat($auction['Auction']['id'], $auction['Product']['title']); ?>"><span class="fixed"></span></a><?php endif; ?><?php if(!empty($auction['Auction']['free'])) : ?><a href="<?php echo AppController::AuctionLinkFlat($auction['Auction']['id'], $auction['Product']['title']); ?>"><span class="free"></span></a><?php endif; ?>
		<div class="content">
        <div class="auctions-label <?php if(rand(1,2) == 1 && 0) echo 'auctions-label-green'; ?>"></div>        
        <div class="bidx_border"></div>
        
      
      <div class="bidx"><div  class="tooltip bottom animate" data-tool="Bid multiplier (number of bids deducted from your account each 
time you press the bid button)">bid x <?php echo $bid_debit['bid_debit'];?></div></div>
      
<div class="username bid-bidder clearfix"><?php __('Highest bidder');?></div>
            <h3><?php echo $html->link($text->truncate($auction['Product']['title'],25), AppController::AuctionLink($auction['Auction']['id'], $auction['Product']['title']));?></h3>
            <div class="thumb clearfix">
            
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
            
            
<div class="retail_price"><span><?php __('Minimum Price');?>:</span> <span class=""><?php echo $number->currency($auction['Product']['minimum_price'], $appConfigurations['currency']); ?></span></div>
<div class="minimum_price"><span><?php __('Retail Price');?>:</span> <?php echo $number->currency($auction['Product']['rrp'], $appConfigurations['currency']); ?></div>            

      <div class="dots"></div>
      <div class="auction_price bid-price"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?>            </div>
      
       <div id="timer_<?php echo $auction['Auction']['id'];?>" class="timer countdown clearfix" title="<?php echo $auction['Auction']['end_time'];?>">--:--:--</div>
		
				<?php 
					$hide_bid_button=false;
					eval(AddonManager::hook('views_elements_auction_beforebidbutton')); 
				?>
				<?php if (!$hide_bid_button): ?>
				<?php if(!empty($auction['Auction']['isFuture'])) : ?>
                <div class="bid-button">
					<a class="b-login b-login-sold" href="#"><?php __('SOON');?></a>
                    </div>
				 <?php elseif(!empty($auction['Auction']['isClosed'])) : ?>
				<div class="bid-button">
				<a class="b-login b-login-sold" href="#"><?php __('SOLD');?></a>
                </div>
				 <?php else:?>
					 <?php if($session->check('Auth.User')):?>
						<div class="bid-loading bid-loading2" style="display: none"><?php echo $html->image('ajax-arrows.gif');?></div>
						<div class="bid-button"><a class="b-login bid-button-link " title="<?php echo $auction['Auction']['id'];?>" href="/bid.php?scheck=<?php echo $csrf;?>&id=<?php echo $auction['Auction']['id'];?>"><?php __('Bid Now');?></a></div>
					<?php else:?>
					<div class="bid-button"><a href="/users/login" class="b-login"><?php __('Bid Now');?></a></div>
					<?php endif;?>
				<?php endif; ?>
				<?php endif; ?>
                
                
			
           
			<div class="bid-msg bid-msg2">
			<div class="bid-message"></div>
			</div>
		</div>
	</li>
	<?php endforeach;?>
</ul>