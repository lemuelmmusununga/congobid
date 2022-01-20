<style>
.sold .current_bid {
    display: block;
}
</style>
<div class="step_titel">
<div class="doc_width"><h1><?php __('Closed Auctions'); ?></h1></div>
</div>
<div class="doc_width">

<p class="padding_left" style="margin-top:15px;margin-bottom:10px;"><?php __('These auctions have ended. Look out for more great bargains!');?></p>


<?php if(!empty($auctions)) : ?>
				<?php if(!empty($appConfigurations['endedLimit'])) : ?>
<p class="padding_left" style="padding-bottom:10px;"><strong><?php __('Showing the last');?> <?php echo $appConfigurations['endedLimit']; ?> <?php __('Auctions');?>.</strong></p>	
				<?php else : ?>	
				<?php endif; ?>
					
			 
	<ul class="horizontal-bid-list">
	<?php
 			
	foreach($auctions as $auction):
 	 
	?>
	
	
	
	
	<li class="sold auction-item auction_<?php echo $auction['Auction']['id'];?> " title="<?php echo $auction['Auction']['id'];?>" id="auction_<?php echo $auction['Auction']['id'];?>"><?php if(!empty($auction['Product']['fixed'])):?><a href="<?php echo AppController::AuctionLinkFlat($auction['Auction']['id'], $auction['Product']['title']); ?>"><span class="fixed"></span></a><?php endif; ?><?php if(!empty($auction['Auction']['free'])) : ?><a href="<?php echo AppController::AuctionLinkFlat($auction['Auction']['id'], $auction['Product']['title']); ?>"><span class="free"></span></a><?php endif; ?>
		  <font></font>
		  <font></font>
		  <font></font>
		  <font></font>		 

	 	
		<h3><?php echo $html->link($text->truncate($auction['Product']['title'],28), AppController::AuctionLink($auction['Auction']['id'], $auction['Product']['title']));?></h3>
	     
		<div class="thumb clearfix">
            	
		 
			<span class="close_sticker close_sticker_<?php echo $appConfigurations['language']; ?>"></span>
			<div class="sold_for">
				<p><?php __('Sold for');?></p><strong class="bid-price"><?php echo $number->currency($auction['Auction']['price'],$appConfigurations['currency']); ?></strong>
			</div>
			
		 
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
			<div class="row row_price">	
				<label class="username_highlight"><span class="username bid-bidder"><?php __('Congratulation'); ?></span></label>	
			</div>	

		<label class="highlight_timer">	
 		  
		<span id="timer_<?php echo $auction['Auction']['id'];?>" class="timer countdown" title="<?php echo $auction['Auction']['end_time'];?>">
		<?php  echo ($auction['Leader']['first_name'] !='') ? ''.$auction['Leader']['first_name']  : '--' ;  ?>
		</span>
		  
		</label>	
			
			
 
	
	
	
	<div class="row row_price">	
	<div class="padd_lr_20">
	<div class="left_auc_content f_l">
	
	<label class="price_highlight">
	<span class="bid-price">
	<?php echo $number->currency($auction['Auction']['price'],$appConfigurations['currency']); ?></span>
	</label>
	
	<div class="price_arrow">
	<div id="pricear">
	<span class="arrow1 arrow_up ar1"></span>
	<span class="arrow1 arrow_down ar1"></span>			
	</div>
	</div>
	
	<p class="current_bid"><?php __('Winner bid');?></p>
	
	
	</div>
	
		
	<div class="left_auc_content f_r text-right">
	
	<span class="valu_price">
	<span><?php __('Value');?></span>	
	<span><label><?php echo $number->currency($auction['Product']['rrp'], $appConfigurations['currency']); ?></label></span>	
	</span>
	 
	</div>	
	</div>
	</div>
	
	<p class="auc_cat">
		<?php __('Categorie');?>:
		<strong><?php echo $number->prod_subs_cat_name($auction['Product']['rrp']); ?></strong>
	</p>
	
		<div class="bid-msg bid-msg2">
			<div class="bid-message"></div>
			</div>
			
		    <div class="auc_btm_content blink">	
		
				<?php 
					$hide_bid_button=false;
					eval(AddonManager::hook('views_elements_auction_beforebidbutton')); 
				?>
				 
			  
			 <div class="bidbtn bid-button sold-btn">
				
				<div class="neon">
				  <span class="text" data-text="<?php __('Sold');?>"><?php __('Sold');?></span>
				  <span class="gradient"></span>
				  <span class="spotlight"></span>
				</div>
				
                </div>
			 
			</div>
			

		
	</li>
	<?php endforeach;?>
	
	


</ul>
					
				<?php echo $this->element('pagination'); ?>

			<?php else: ?>
				<div class="align-center off_message"><p><?php __('There are no closed auctions at the moment.');?></p></div>
			<?php endif; ?>
	
	<br class="clear_l">

	<div class="crumb_bar">
			<?php
			$html->addCrumb(__('Closed Auctions', true), '/auctions/closed');
			echo $this->element('crumb_auction');
			?>
	</div>


       			
			
</div>			


				
        