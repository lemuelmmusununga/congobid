<style>
fieldset .text label, fieldset.contact .text label, fieldset.contact .select label, fieldset.contact .textarea label{
	float:none;
	display:inline-block;
	width: auto;
}
fieldset .text input, fieldset .password input, fieldset .select select, fieldset .textarea textarea{
	width: 250px;
	padding: 9px 2% 7px 6px;
}

.perfect_text{width:249px;}
.perfect_text{position:absolute;top:-90px;}
.totalresults{ 
	display:none;
}
.package_box li {
	margin-bottom:90px;
	color: #fff;
}
fieldset label { width:201px; } 
div.submit{display: inline-block;float: none;}
fieldset .form-container, fieldset .input{
	display: inline-block;
	clear: none;
	min-width: 383px;
}
div.submit input{
	padding: 0px 15px !important;
	width: auto;
}
.footerbg {
    margin-top: 0px;
	display:none;
}
</style>
<div class="box clearfix">
<div class="step_titel">
<div class="doc_width"><h1><?php __('Buy Bids');?></h1></div>
</div>
<div class="main_content">
 <div class="doc_width shadow_bg package_page">	
<div class="padd_30"> 


<div class="text-center">
<h2 class="mar_b_0"> <h2> <?php __('Which Package Is Right For You?');?></h2></h2>
<h2> <?php echo $_GET['message'];?></h2>
 </div>


 


        
	            

				<?php if(!empty($packages)) : ?>

		
             <div class="text-center mar_b_30">
                <?php if(Configure::read('App.coupons')):?>
					<?php if($coupon = Cache::read('coupon_user_'.$session->read('Auth.User.id'))):?>
						<?php echo sprintf(__('Coupon code applied : %s', true), $coupon['Coupon']['code']);?>
						(<?php echo $html->link(__('Remove Coupon', true), array('action' => 'removecoupon'));?>)
					<?php else:?>
						<p  style="margin-top:0px;"><?php __('If you have a coupon or discount code enter it in below to receive a discount.');?></p>
						<fieldset>
							<legend></legend>
							<?php echo $form->create('Package', array('action' => 'applycoupon'));?>
							<?php echo $form->input('Coupon.code', array('label' => __('Coupon Code:', true)));?>
							<?php //echo $form->end(__('Apply Coupon', true));?>
							<div class="submit" style="padding: 7px 25px;">					
							<input type="submit" value="<?php __('Apply Coupon');?>">
							</div>
						</fieldset>
						      
                
					<?php endif;?>
				<?php endif;?>
              </div> 
                
                
                
                
                
                
                <div class="perfect_text"><?php __('Perfect For Beginners');?>  </div> 
                <div class="package_box">
                <ul>
                
                <?php
				$i = 0;
				foreach ($packages as $package):
					$class = null;
					if ($i++ % 2 == 0) {
						$class = ' class="altrow"';
					}
					/*
					if($package['Package']['id'] == 1){ $package['Package']['bids'] = 10;	}	 
					if($package['Package']['id'] == 2){ $package['Package']['bids'] = 35;	}	 
					if($package['Package']['id'] == 3){ $package['Package']['bids'] = 75;	}	 
					if($package['Package']['id'] == 4){ $package['Package']['bids'] = 200;	}	
*/					
				?>
                
                
                <li>
                <?php if($package['Package']['popular'] == 1 ){ ?><div class="mostpopular">&nbsp;</div> <?php } ?>
               <label><?php echo $package['Package']['name']; ?> </label> 
               
               <div class="pack_img"><img src="/img/bids_<?php echo $package['Package']['bids']; ?>.png"></div>
               
                <span class="hide"><strong><?php echo $package['Package']['bids']; ?></strong> <?php __('Bids');?></span>
				<?php if($package['Package']['bids1'] > 0){?>
					<p>+ <?php echo $package['Package']['bids1']; ?> <?php __('Bids');?> </p> 
				<?php } ?>

				<p><?php echo $number->currency($package['Package']['price'],$appConfigurations['currency']); ?></p>
               

                <div class="package_btn">					
							<?php if(Configure::read('Paypal.email')<>'') : ?>
							<a style="margin-top: 5px;" class="btn_new  left-animated btn-orange btn-white" href="/payment_gateways/paypal/package/<?php echo $package['Package']['id']; ?>"> <?php __('Paypal');?> </a>						
							<a style="margin-top: 5px;" class="btn_new  left-animated btn-orange btn-white" href="/payment_gateways/payle/package/<?php echo $package['Package']['id']; ?>"> <?php __('Carte bancaire');?> </a>						
							<a style="margin-top: 5px;" class="btn_new  left-animated btn-orange btn-white" href="/payment_gateways/mobile/package/<?php echo $package['Package']['id']; ?>/1"> <?php __('Mobile Money');?> </a>						
 	
							<?php endif; ?>
							 
                
                 </div>             

                </li>
                
                <?php endforeach; ?>
                
                
                </ul>
                </div>
                
             
                
	<?php echo $this->element('pagination'); ?>

				<?php else:?>
					<p><?php __('There are no packages at the moment.');?></p>
				<?php endif;?>				      
        </div>
    </div> 
    </div>
    </div>
            
