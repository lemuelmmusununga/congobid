<?php //echo '<pre>';print_r($product['Image'][0]['image']);echo '</pre>'; exit; ?><div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<script type="text/javascript">
$(document).ready(function(){
	
	$('ul.tabs_s li').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('ul.tabs_s li').removeClass('current');
		$('.tab-content').removeClass('current');

		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
	})

})
</script>

<style>
.buybids_btn{width:100%;text-align:center;}
.buybids_btn a{float:none;padding:10px 50px}
#auction-details .col3{float:right;width:275px;}
.col2_descrition h1{padding-bottom:10px;}
.retail_price2{margin-bottom:5px;}
.retail_price2 span{width:46%;padding:7px 5px 7px 10px;}
.retail_price2 span{color:#000;}
.col2_descrition{width:414px;float:left;margin-left:21px;}
.margin_seg{margin-right:5px;}
#auction-details .col1{width:400px;}
#auction-details .thumbs{float:left;clear:both;width:auto;}
ul.tabs_s li{padding:0px 10px;width:auto;}
#auction-details .col1 .auction-image img{width:325px;}
ul.tabs{font-size:20px;font-weight:bold;color:#fff;text-align:center;}
#auction-details .col1 .auction-image img{width:auto;}
#auction-details .col3{min-height:369px;}
#auction-details .col2{min-height:360px;}
#auction-details .col1{min-height:370px;}
#auction-details .col1 .auction-image img{width:100%}


ul.tabs {
	background: #25272a;
	padding: 8px;
	list-style: none;
	height: 27px;
	margin: 0 !important;
}



</style>
 



<div class="box clearfix">

<div class="main_content">

<div class="main_content_middle main_content_middle2">			
<div id="auction-details">
<div class="col1">
<div class="content">
 <div class="center_img">
					<div class="auction-image">
						<?php if(!empty($product['Image'])):?>
							<?php echo $html->image('/img/product_images/max/'.$product['Image'][0]['image'], array('class'=>'productImageMax', 'alt' => $product['Product']['title'], 'title' => $product['Product']['title']));?>
						<?php else:?>
							<?php echo $html->image('product_images/max/no-image.gif', array('alt' => $product['Product']['title'], 'title' => $product['Product']['title']));?>
						<?php endif; ?>
					</div>
                    </div>
					<div class="thumbs">
						<?php if(!empty($product['Image']) && count($product['Image']) > 1):?>
								<?php 
								$i = 0;
								foreach($product['Image'] as $image):  $i++; 
									if($i > 3){ continue; }
								?>
									<?php if(!empty($image['ImageDefault'])) : ?>
								<div class="margin_seg"><div class="center_img_thumb"><span><?php echo $html->link($html->image('default_images/'.$appConfigurations['serverName'].'/thumbs/'.$image['ImageDefault']['image']), '/img/'.$appConfigurations['currency'].'/default_images/max/'.$image['ImageDefault']['image'], array('class' => 'productImageThumb'), null, false);?></span></div></div>                                
								<?php else: ?>
								<div class="margin_seg"><div class="center_img_thumb"><span><?php echo $html->link($html->image('product_images/thumbs/'.$image['image']), '/img/product_images/max/'.$image['image'], array('class' => 'productImageThumb'), null, false);?></span></div></div>                                                                
								<?php endif; ?>
							<?php endforeach;?>
			                                                                			
						<?php endif;?>
					<div class="right_like" style="margin-top:10px;">

                    
                    
                    <label> <div class="fb-like" data-href="https://www.facebook.com/pujon" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div> </label>                     
                    
                    </div>
					</div>
                    
                
					 
                     
                     
				</div>
			</div>
            
            

<div class="col2_descrition auction-item4" title="<?php echo $product['Product']['id'];?>" id="auction_<?php echo $product['Auction']['id'];?>" style="padding:0;">
<h1><?php echo $product['Product']['title']; ?></h1>

<div class="retail_price2">
<span>Buy now Price:</span> <span><?php echo $number->currency($product['Product']['buy_now'], $appConfigurations['currency']); ?></span>
</div>



                     
							
							<div class="retail_price2">
							<span>Retail price:</span>
							<span><?php echo $number->currency($product['Product']['rrp'], $appConfigurations['currency']); ?></span>
                            </div>
                            
                          

							
                            <div class="retail_price2">
							<?php if(!empty($product['Product']['rrp'])) : ?>
							<span>Savings:</span>
							<span><?php echo $number->currency($product['Product']['rrp'] - $product['Product']['buy_now'], $appConfigurations['currency']); ?></span>
							<?php endif; ?>
                            </div>
                           
							
							<?php if($buy_it_now):?>
                            <div class="retail_price2">
								<span>
								
                                <?php __('Buy it now :');?>
								</span>
								<span class="price_bin">
								<?php echo $number->currency($product['Product']['buy_now'], $appConfigurations['currency']); ?>
								<br /></span>
                                </div>
							<?php endif; ?>
							
						
                       






<div class="buybids_btn">
<a href="/products/buy/<?php echo $product['Product']['id']?>">Buy Now</a>
</div>




</div>   


<div class="col3">
<ul class="tabs">
Buyer Protection
</ul>

<div class="panes panes2">    
<p>Returns accepted if product not as described.</p>

<p>Know the Rules, and follow them!</p>

<p>Don't let others use your account, especially minors.</p>
</div>

  
</div>         
            
            
            
            
            
            
            
            
            
		 

</div>



<br style="clear:both" />
<div class="tab_con">

	<ul class="tabs_s">
		<li data-tab="tab-1" class="tab-link current left"><?php __('Product Description');?></li>
		<li data-tab="tab-2" class="tab-link center_line"><?php __('Shipping Details');?></li>
		</ul>

	<div class="tab-content current" id="tab-1">
    
   
    <h2><?php echo $product['Product']['title']; ?></h2>
    
	 <p>
	<?php echo $product['Product']['description'];?>
    </p>
	</div>
    
    
    
	<div class="tab-content" id="tab-2">
<div class="Shipping_info">
				<strong><?php __('Shipping information:');?></strong>
				<?php if(!empty($product['Product']['delivery_information'])) : ?>
					<p><?php echo $product['Product']['delivery_information'];?></p>
				<?php else: ?>
				<p class="align-center" style="padding:4px;"><?php __('None provided');?></p>
				<?php endif;?>
				</div>
</div>


</div>


</div>
</div>
</div>







      
      
        
        
             