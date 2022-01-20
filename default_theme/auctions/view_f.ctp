<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.0/socket.io.js"></script>


<?php 
	$pos = strpos($auction['Auction']['end_time'], ':');
if($pos){ $auction['Auction']['end_time'] = strtotime($auction['Auction']['end_time']); }
$sec_left =  $auction['Auction']['end_time'] - time();
	
?>



<style>
.bidbuddy{text-align:center;float:left;width:100%;padding:20px 0px 10px 0px;}
.bidbuddy p{font-size:14px;}
.set_input{float:right;border:1px solid #ccc;height:25px;width:56px;text-align:center;}
.bidbuddy label{ float:left;}
</style> 









<div class="box clearfix">

<div class="main_content" style="background:#fff;padding:50px 0px;">

<div class="main_content_middle">			
<div id="auction-details">
<div class="col1">
<div class="content">
 <div class="center_img">
					<div class="auction-image">
						<?php if(!empty($auction['Auction']['image'])):?>
							<?php echo $html->image($auction['Auction']['image'], array('class'=>'productImageMax', 'alt' => $auction['Product']['title'], 'title' => $auction['Product']['title']));?>
						<?php else:?>
							<?php echo $html->image('product_images/max/no-image.gif', array('alt' => $auction['Product']['title'], 'title' => $auction['Product']['title']));?>
						<?php endif; ?>
					</div>
                    </div>
					<div class="thumbs">
						<?php if(!empty($auction['Product']['Image']) && count($auction['Product']['Image']) > 1):?>
								<?php 
								$i = 0;
								foreach($auction['Product']['Image'] as $image):  $i++; 
									if($i > 3){ continue; }
								?>
									<?php if(!empty($image['ImageDefault'])) : ?>
								<div class="margin_seg"><div class="center_img_thumb"><span><?php echo $html->link($html->image('default_images/'.$appConfigurations['serverName'].'/thumbs/'.$image['ImageDefault']['image']), '/img/'.$appConfigurations['currency'].'/default_images/max/'.$image['ImageDefault']['image'], array('class' => 'productImageThumb'), null, false);?></span></div></div>                                
								<?php else: ?>
								<div class="margin_seg"><div class="center_img_thumb"><span><?php echo $html->link($html->image('product_images/thumbs/'.$image['image']), '/img/product_images/max/'.$image['image'], array('class' => 'productImageThumb'), null, false);?></span></div></div>                                                                
								<?php endif; ?>
							<?php endforeach;?>
			                                                                			
						<?php endif;?>					
					</div>
                    
                
					 
                     
                     
				</div>
			</div>
<div class="col2_descrition">
<h1><?php echo $auction['Product']['title']; ?></h1>
<div class="product_description"><?php echo $auction['Product']['description'];?></div>

<div class="retail_price2">
<span>Retail price: <?php echo $number->currency($auction['Product']['rrp'], $appConfigurations['currency']); ?>
</span>
<span>Minimum price: <?php echo $number->currency($auction['Product']['minimum_price'], $appConfigurations['currency']); ?></span>
</div>

<div class="buybids_btn">
<a href="<?php echo $this->webroot; ?>packages">Buy More Bids</a>
</div>
</div>            
            
            
            
 

</div>


</div>
</div>

<div class="box clearfix">
<div class="gray_dotted" style="width:100%;"></div>
<div id="auction-details" class="main_content_middle">

<div class="col3">

<!-- the tabs -->
<ul class="tabs">
	<li id="bid-h" style="margin-right:7px!important;"><strong>BIDDING</strong> HISTORY</li>
    <div class="greenline">&nbsp;</div>
    
	<?php if(empty($auction['Auction']['isFuture']) && empty($auction['Auction']['isClosed']) && empty($auction['Auction']['nail_bitter']) && $session->check('Auth.User')):?>

	<li id="bid-b" style="display:none;"><a href="#t2"><?= __('Bid Butlers')?></a></li>
	<?php endif;?>
</ul>

<!-- tab "panes" -->
<div class="panes">
	<div class="bid-history bid-histories" id="bidHistoryTableauction_<?php echo $auction['Auction']['id'];?>">
		    <table width="100%" cellpadding="0" cellspacing="0" border="0">
			   <thead>
				  <tr>
					 <th><label><?php __('Time');?></label></th>
					 <th><label><?php __('Bidder');?></label></th>
					 <th><label><?php __('Type');?></label></th>
				  </tr>
			   </thead>
			   <tbody>
				  <?php if(!empty($bidHistories)):?>
					 <?php foreach($bidHistories as $bid):?>
					 <tr>
						<td><?php echo $time->niceShort($bid['Bid']['created']);?></td>
						<td><?php echo $bid['User']['username'];?></td>
						<td><?php echo $bid['Bid']['description'];?></td>
					 </tr>
					 <?php endforeach;?>
				  <?php endif;?>
				  <?php if(empty($bidHistories)):?>
				  <tr><td colspan="3" align="center" style="border-bottom:0px;"><p class="align-center bold" style="padding-top:30px; color:#AAA; font-size:12px;"><label><?php __('No bids have been placed yet.');?></label></p></td></tr>
				  <?php endif;?>
			   </tbody>
		    </table>
	</div>
	<?php if(empty($auction['Auction']['isFuture']) && empty($auction['Auction']['isClosed']) && empty($auction['Auction']['nail_bitter']) && $session->check('Auth.User')):?>
	<div class="bid-history bid-histories" style="display:none!important;">
			<p class="bid_setting"><?= __('Bid Butler settings') ?></p>
				<?php echo $form->create('Bidbutler', array('url' => '/bidbutlers/add/'.$auction['Auction']['id']));?>
					<fieldset class="auto">
					<?php if (Configure::read('App.bidButlerType')=='advanced') { ?>
					<label for="BidbutlerMinimumPrice"><?= __('Starting Bid') ?>&nbsp;&nbsp;&nbsp;<?= $number->currencySign($appConfigurations['currency']) ?></label><input class="disabled" name="data[Bidbutler][minimum_price]" type="text" maxlength="6" value="" id="BidbutlerMinimumPrice" />
					<br style="clear:both">
					<?php } ?>
					
					<?php
					if (!$auction['Auction']['reverse'] && Configure::read('App.bidButlerType')=='advanced') {
						?>
					<label for="BidbutlerMaximumPrice"><?= __('Maximum bid') ?>&nbsp;&nbsp;&nbsp;<?= $number->currencySign($appConfigurations['currency']) ?></label><input class="disabled" name="data[Bidbutler][maximum_price]" type="text" maxlength="6" value="" id="BidbutlerMaximumPrice" />
					<br style="clear:both">
						<?php
					}
					?>
					
					<label class="numberof_bids" for="BidbutlerBids"><?= __('Number of bids') ?></label><input class="disabled" name="data[Bidbutler][bids]" type="text" maxlength="6" value="" id="BidbutlerBids" />
					</fieldset>
				<span class="submit"><input type="submit" value="<?= __('Set Bid') ?>"/></span>
				<p class="bold"><a style="color:#000;" href="/bidbutlers"><?= __('Your Bid Butler settings') ?></a></p>
				</form>
	</div>
	<?php endif;?>
</div>
 


	

	</div>
<div class="col2">
		<div class="content auction-item auction_<?php echo $auction['Auction']['id'];?>" title="<?php echo $auction['Auction']['id'];?>" id="auction_<?php echo $auction['Auction']['id'];?>" style="padding:0;">
		<div class="liveauction"><strong>LIVE</strong> AUCTION</div>               
        <div class="greenline">&nbsp;</div>
        
		<div id="timer_<?php echo $auction['Auction']['id'];?>" class="timer countdown" title="<?php echo $auction['Auction']['end_time'];?>">--:--:--</div>                       
        <div class="bnr_timer_calculation" style="display:none;"><?php echo $sec_left;  ?></div> 
		<div class="closed_status" style="display:none;"><?php echo $auction['Auction']['closed'] ; ?></div>
		
		<div class="greenline grayline">&nbsp;</div>
        
        <div class="usd_price"><strong class="bid-price"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></strong></div>
        
		<div class="minumumprice bid-bidder"><?php  echo ($auction['Leader']['username'] !='') ? $auction['Leader']['username'] : 'No Bids' ;  ?></div>
        
        
        
        
        
						<div class="bid-now">
                        
                        
							<?php
							
							$show_bid_button=true;
									
							eval(AddonManager::hook('views_auctions_view_beforebidbutton'));
							
							?>
							<?php if($show_bid_button && !empty($auction['Auction']['isFuture'])) : ?>
								<div><img src="<?php echo $this->webroot; ?>img/button/b-soon-big.gif" width="199" height="59" alt="Please wait for the auction to begin" title="Please wait for the auction to begin"></div>
							 <?php elseif($show_bid_button && !empty($auction['Auction']['isClosed'])) : ?>
								<div><img src="<?php echo $this->webroot; ?>img/button/b-sold-big.gif" width="199" height="59" alt="" title="オークション終了"></div>
								
								<?php
								if ($buy_it_now) { ?>
									<div class="submit" style="display:none;">
									<input type="submit" 
										onclick="window.location='/auctions/buy/<?php echo $auction['Auction']['id']; ?>'" 
										value="Buy it now!">
									</div>
									<?php 
								} ?>
								
							 <?php elseif ($show_bid_button) :?>
								 <?php if($session->check('Auth.User')):?>
									<div class="bid-loading" style="display: none"><?php echo $html->image('ajax-arrows-white.gif');?></div>
                                                 
									<?php eval(AddonManager::hook('views_auctions_view_beforebidbutton2')); ?>
									
									<?php if ($show_bid_button): ?>
									<div class="bid-button "><a class="b-login-big bid-button-link" title="<?php echo $auction['Auction']['id'];?>" href="/bid.php?scheck=<?php echo $csrf;?>&id=<?php echo $auction['Auction']['id'];?>">Bid Now</a></div>
									<?php endif; ?>
									
									<?php
									if ($buy_it_now) { ?>
										<div class="submit" style="display:none1;">
										<input type="submit" 
											onclick="window.location='/auctions/buy/<?php echo $auction['Auction']['id']; ?>'" 
											value="Buy it now!">
										</div>
										<?php 
									} ?>
								<?php else:?>
									<div class="bid-button"><a href="/users/login" class="b-login-big">Bid <label>x2</label></a></div>
								<?php endif;?>
								
								
							<?php endif; ?>

						</div>
                        
                        
                        
                        
                        
                        <?php if(!empty($auction['Product']['fixed']) && empty($auction['Auction']['isClosed'])):?>
							<div class="note"><?php if(!empty($auction['Auction']['free'])):?><?php __('Free listing! Costs nothing.');?> <br /><?php endif; ?>
                            <?php __('To the highest bidder, flat rate pricing:');?><span class="side_2px bold blk"><?php echo $number->currency($auction['Product']['fixed_price'], $appConfigurations['currency']);?></span><?php __('You can bid.');?></div>
						<?php endif; ?>
						<?php if(empty($auction['Auction']['isClosed']) && empty($auction['Auction']['isFuture']) && empty($auction['Product']['fixed'])):?>
							<div class="note" style="<?php if ($buy_it_now) { ?>margin-top:3px; <?php } ?>">
                            <div style="float:left;padding-bottom:8px;padding-left:29px;">
							<?php if(!empty($auction['Auction']['free'])):?><?php __('Free listing! Costs nothing.');?> <br />
							<?php endif; ?>

							<?php if(!isset($is_unique)): ?>
							<span style="float:left;"><?= __('With each bid, the auction price') ?> <?php if ($auction['Auction']['reverse']) echo __('decreases by'); else echo __('increases by'); ?> </span>
                            
                            <span class="side_2px bold blk price-increment"><?php echo $number->currency($bidIncrease, $appConfigurations['currency']);?></span></div>
							<?php endif; ?>
							</div>
						<?php endif; ?>

                        
                        
                        
            
                        
                        
                         
                      
                        
						
						<?php if(empty($auction['Auction']['isFuture']) && empty($auction['Auction']['isClosed'])):?>
						<div class="bid-msg">
						<div class="bid-message" style="display: none"></div>
						</div>
						<?php endif; ?>

						
					</div>

							
						
	

				</div>                         		    
<div class="auction_col2_bottom"> 
                       <dl>
							
							<dt>AUCTION PRICE</dt>
							<dd><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?> 
</dd>
						
                            <br style="clear:both;">

							
							<?php if($buy_it_now):?>
								<dt>BUYNOW PRICE</dt>
                                
								<dd><?php echo $number->currency($auction['Product']['buy_now'], $appConfigurations['currency']); ?></dd>
							<?php endif; ?>
                            
                    	<br style="clear:both;">
                        <dt class="green_color">YOU SAVE</dt>
                                                        
                            <dd class="green_color">
                 <?php if(empty($auction['Auction']['isFuture'])):?><?php echo $number->currency($auction['Auction']['savings']['price'], $appConfigurations['currency']);?>
		<?php endif; ?>
                            </dd>
                            
							
						</dl>
                       
                       <div class="bidbuddy">                                                       
<ul class="tabs">
	<li id="bid-h" style="margin-right:7px!important;"><strong style="text-transform:uppercase;"> <?php __('Bid');?> </strong> <?php __('BUDDY');?> </li>
    <div class="greenline">&nbsp;</div>
</ul>

 <?php if(empty($auction['Auction']['isFuture']) && empty($auction['Auction']['isClosed']) && empty($auction['Auction']['nail_bitter']) && $session->check('Auth.User')):?>
	<div class="bid-history bid-histories">
    <?php echo $form->create('Bidbutler', array('url' => '/bidbutlers/add/'.$auction['Auction']['id']));?>

 	<p>
	<?= __('BidAgent monitors your auctions when you cannot be on line,
    or when you would like to have bids placed automatically for
    you.') ?> <a href="/bidbutlers"> Manage  >> </a>
    </p>
			
<br style="clear:both;" />            
					
				
					
					<label for="BidbutlerBids"><?= __('BIDS REMAINING') ?></label><input class="disabled set_input" name="data[Bidbutler][bids]" type="text" maxlength="6" value="" id="BidbutlerBids" />
					</fieldset>
<br style="clear:both;" />
				<div class="submit" style="display:inline-block;clear:both;float:none;"><input type="submit" value="<?= __('Set') ?>"/></div>
				</form>
	</div>
	<?php endif;?>

</div> 
                        
						</div>                                
                        
</div>


 
</div>
</div>
</div>
 




      
      
        
        
             