<?php
if(!empty($auctions_end_soon)) : ?>


<div class="step_titel heading_titel">
<div class="doc_width">
<h1><?php __('Our Runway');?></h1>

<ul style="display:none;">
<li class="highlight"><?php __('Ending today');?></li>
<li><?php __('Upcoming');?></li>
</ul>

</div>
</div>

    

<div class="main_content">  
<div class="main_content_middle">     
<?php echo $this->element('auctions', array('auctions'=>$auctions_end_soon)); ?>
</div>
</div>

			
<?php if(!empty($auctions_live)) : ?>
	
<?php else:?>
	
<?php endif; ?>




</div>
<?php endif; ?>


<?php if(!empty($auctions_live)) : ?>
<div id="live-bids" class="box">

<div class="top_heading2">
<h1>More Live Auctions</h1>
<span>Current Bid</span>
<span class="timeleft">Time Left</span>                         
<span class="bidnow">Bid Now</span>


</div>	

<div class="main_content main_content_bor">        
<div class="main_content_middle" style="padding:0px;">			                
		<div class="main_content_middle">
        
		<div class="content">			
			<ul class="vertical-bid-list">
				<?php foreach($auctions_live as $auction):?>
				<li class="auction-item" title="<?php echo $auction['Auction']['id'];?>" id="auction_<?php echo $auction['Auction']['id'];?>">
					<div class="content">
                                            
						<div class="col1 thumb">
							<a href="<?php echo AppController::AuctionLinkFlat($auction['Auction']['id'], $auction['Product']['title']); ?>"><span class="<?php if(!empty($auction['Auction']['penny'])):?> penny<?php endif;?><?php if(!empty($auction['Auction']['peak_only'])):?> peak_only<?php endif;?><?php if(!empty($auction['Auction']['beginner'])):?> beginner<?php endif;?> <?php if(!empty($auction['Auction']['nail_bitter'])):?> nail<?php endif;?><?php if(!empty($auction['Auction']['featured'])):?> featured<?php endif;?><?php if(empty($auction['Auction']['nail_bitter']) && empty($auction['Auction']['penny']) && empty($auction['Auction']['featured']) && empty($auction['Auction']['peak_only'])):?> glossy<?php endif;?>"></span>
							<?php
							if(!empty($auction['Product']['Image']) && !empty($auction['Product']['Image'][0]['image'])) {
								echo $html->image('product_images/thumbs/'.$auction['Product']['Image'][0]['image']);
							} else {
								echo $html->image('product_images/thumbs/no-image.gif');
							}
							?>
							</a>
						</div>
						<div class="col2">
							<h3 class="heading"><?php echo $html->link($auction['Product']['title'], AppController::AuctionLink($auction['Auction']['id'], $auction['Product']['title']));?></h3>
							<?php echo strip_tags($text->truncate($auction['Product']['brief'], 120, '...', false, true));?>
							
							<div><?php if(!empty($auction['Auction']['free'])) : ?><a href="/page/auction_type" class="side_2px"><img src="<?php echo $this->webroot; ?>badge/free_label_vertical.png" width="101" height="16" border="0" alt="Free auctions" title="Free auctions"></a><?php endif; ?>
							<?php if(!empty($auction['Product']['fixed'])) : ?><a href="/page/auction_type" class="side_2px"><img src="<?php echo $this->webroot; ?>/badge/fixed_label_vertical.png" width="101" height="16" border="0" alt="Fixed price auction" title="Fixed price auction"></a><?php endif; ?></div>
						</div>
						<div class="col3">
							<div class="price">
								<?php if(!empty($auction['Product']['fixed'])) : ?>
									<?php echo $number->currency($auction['Product']['fixed_price'], $appConfigurations['currency']); ?>
									<span class="bid-price-fixed" style="display:none"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></span>
								<?php else: ?>
									<div class="bid-price"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></div>
								<?php endif; ?>
							</div>
							<?php if(!empty($auction['Product']['rrp'])): ?>
								<div class="rrp"><?= __('Retail Price')?> : <br><?php echo $number->currency($auction['Product']['rrp'], $appConfigurations['currency']); ?></div>
							<?php endif; ?>

						</div>
						<div class="col4 bid-bidder"></div>
                        
					<div class="col4_">
                    <div id="auctionLive_<?php echo $auction['Auction']['id'];?>" class="timer countdown" title="<?php echo $auction['Auction']['end_time'];?>">Loading...</div>
                    
                    <div class="bid-now">
								<?php if(!empty($auction['Auction']['isFuture'])) : ?>
									<div><?= $html->image('/button/b-soon-w.gif', array('width'=>"94", 'height'=>"32", 'alt'=>__("Please wait until the auction starts"), 'title'=>__("Please wait until the auction starts"))) ?></div>
								 <?php elseif(!empty($auction['Auction']['isClosed'])) : ?>
									<div><?= $html->image('/button/b-sold-w.gif', array('width'=>"94", 'height'=>"32", 'alt'=>"", 'title'=>"")) ?>></div>
								 <?php else:?>
									 <?php if($session->check('Auth.User')):?>
										<div class="bid-loading" style="display: none"><?php echo $html->image('ajax-arrows.gif');?></div>
										<div class="bid-button"><a class="bid-button-link button-small-vertical" title="<?php echo $auction['Auction']['id'];?>" href="/bid.php?scheck=<?php echo $csrf;?>&id=<?php echo $auction['Auction']['id'];?>">&nbsp;</a></div>
									<?php else:?>
										<div class="bid-button"><a href="/users/login" class="b-login-vertical"><?php __(@$j['menu_my_login']);?></a></div>
									<?php endif;?>
								<?php endif; ?>
							<div class="bid-message"></div>
							</div>
                    
                    </div>
                        
						
					</div>
				</li>
				<?php endforeach;?>
			</ul>	        
		</div>        
        
        </div>
				
</div>  
</div>

	

</div>
<?php endif; ?>