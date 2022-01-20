<style>
ul.horizontal-bid-list li h3{ padding:9px 0 3px;}
.auction_price{font-size:28px;color:#ff9100;margin-bottom:12px;}
</style>
<div class="box clearfix">
<div class="top_heading">
<div class="doc_width"><h1><?php __('Products'); ?></h1></div>
</div>
<div class="main_content">
   
<div class="main_content_middle">
    <?php if(!empty($products)) : ?>
   

  <ul class="horizontal-bid-list">
	<?php foreach($products as $product):?>
	<li class="auction-item3" title="<?php echo $product['Product']['id'];?>" id="auction_<?php echo $product['Product']['id'];?>"><?php if(!empty($product['Product']['fixed'])):?><a href="<?php echo AppController::ProductLinkFlat($product['Product']['id'], $auction['Product']['title']); ?>"><span class="fixed"></span></a><?php endif; ?><?php if(!empty($product['Product']['free'])) : ?><a href="<?php echo AppController::AuctionLinkFlat($product['Product']['id'], $auction['Product']['title']); ?>"><span class="free"></span></a><?php endif; ?>
		<div class="content">
        
        

            <h3><?php echo $html->link($text->truncate($product['Product']['title'],25), AppController::ProductLink($product['Product']['id'], $product['Product']['title']));?></h3>
            <div class="thumb clearfix">
            
				<a href="<?php echo AppController::ProductLinkFlat($product['Product']['id'], $product['Product']['title']); ?>"><span class="<?php if(!empty($product['Product']['penny'])):?> penny<?php endif;?><?php if(!empty($product['Product']['peak_only'])):?> peak_only<?php endif;?><?php if(!empty($product['Product']['beginner'])):?> beginner<?php endif;?> <?php if(!empty($product['Product']['nail_bitter'])):?> nail<?php endif;?><?php if(!empty($product['Product']['featured'])):?> featured<?php endif;?>"></span>
				<?php
				if(!empty($product['Image']) && !empty($product['Image'][0]['image'])) {
					echo $html->image('product_images/thumbs/'.$product['Image'][0]['image']);
				} else {
					echo $html->image('product_images/thumbs/no-image.gif');
				} 
				?>
				</a>
			</div>
            
            
            
<div class="retail_price"><span><?php __('Retail Price');?>: </span> <span class=""> <?php echo $number->currency($product['Product']['rrp'], $appConfigurations['currency']); ?></span></div>
<div class="minimum_price"><span><?php __('Saving Price');?>: </span><?php echo $number->currency($product['Product']['rrp'] - $product['Product']['buy_now'] , $appConfigurations['currency']); ?></div>            

      <div class="dots"></div>
      <div class="auction_price bid-price"><?php echo $number->currency($product['Product']['buy_now'], $appConfigurations['currency']); ?> </div>
      

       
       
              
            
                      
            
            
                 
       
		<div class="bid-now"> 
		<div class="bid-button"><a href="<?php echo AppController::ProductLinkFlat($product['Product']['id'], $product['Product']['title']); ?>" class="b-login">Buy Now</a></div>
					 
			</div>
           
			<div class="bid-msg">
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
        <?php __('There are no shop products at the moment.');?>
      </p>
    </div>
    <?php endif; ?>
 
  
  </div>
  
</div>
</div>
