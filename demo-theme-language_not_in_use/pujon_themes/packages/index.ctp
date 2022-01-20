<style>
.totalresults{
	display:none;
}
.package_box li{margin-bottom:45px;}
</style>
<div class="box clearfix">
<div class="step_titel">
<div class="doc_width"><h1><?php __('Buy bids');?></h1></div>
</div>
<div class="main_content">
 <div class="main_content_middle package_page">			
<h2> <?php __('Which Package Is Right For You?');?></h2>
 


<div class="perfect_text"><?php __('Perfect For Beginners');?>  </div>         
	            

				<?php if(!empty($packages)) : ?>

		
            
                
                
                
                
                
                
                
                <div class="package_box">
                <ul>
                
                <?php
				$i = 0;
				foreach ($packages as $package):
					$class = null;
					if ($i++ % 2 == 0) {
						$class = ' class="altrow"';
					}
					 
				?>
                
                
                <li>
                <?php if($package['Package']['id'] == 3 ){ ?><div class="mostpopular">&nbsp;</div> <?php } ?>
               <label><?php echo $number->currency($package['Package']['price'],$appConfigurations['currency']); ?> </label> 
               
               
               
                <span><strong><?php echo $package['Package']['bids']; ?></strong> <?php __('Bids');?></span>
                <p><strong>+ <?php echo $package['Package']['free_bids']; ?></strong> <?php __('Free bids');?></p>
                <div class="gray_dotted" style="width:46px;margin:25px auto;"></div>
                

                <div class="package_btn">					
							<?php if(Configure::read('Paypal.email')<>'') : ?>
								<?php echo $html->link(__('Purchase Using Paypal', true), array('controller' => 'payment_gateways', 'action' => 'paypal', 'package', $package['Package']['id'])); ?><br>
							<?php endif; ?>
							<?php if(Configure::read('PaymentGateways.GoogleCheckout.merchant_id')) : ?>
								<?php echo $html->link(__('Purchase Using Google Checkout', true), array('controller' => 'payment_gateways', 'action' => 'google_checkout', 'package', $package['Package']['id'])); ?><br>	
							<?php endif; ?>
							<?php if(Configure::read('PaypalProUk.username')) : ?>
								<?php if(Configure::read('debug') == 0) : ?>
									<?php echo $html->link(__('Purchase Using Credit Card', true), str_replace('http://', 'https://', $appConfigurations['url']).'/packages/creditcard/'.$package['Package']['id']); ?><br>
								<?php else: ?>
									<?php echo $html->link(__('Purchase Using Credit Card', true), array('action' => 'creditcard', $package['Package']['id'])); ?>
								<?php endif; ?>
							<?php endif; ?>
							<?php if(Configure::read('PaymentGateways.Paybox.active')) : ?>
								<?php echo $html->link(__('Purchase Using PayBox', true),'/payment_gateways/paybox/package/'.$package['Package']['id']); ?><br>
							<?php endif; ?>
							<?php if(Configure::read('PaymentGateways.Usaepay.active')) : ?>
								<?php echo $html->link(__('Purchase Using USA ePay', true),'/payment_gateways/usaepay/package/'.$package['Package']['id']); ?><br>
							<?php endif; ?>
							<?php if(Configure::read('PaymentGateways.Nbepay.active')) : ?>
								<?php echo $html->link(__('Purchase Using NBePay', true),'/payment_gateways/nbepay/package/'.$package['Package']['id']); ?><br>
							<?php endif; ?>

							<?php if(Configure::read('PaymentGateways.iPay88.active')) : ?>
								<?php echo $html->link(__('Purchase Using iPay88', true),'/payment_gateways/ipay88/package/'.$package['Package']['id']); ?><br>
							<?php endif; ?>

							<?php if(Configure::read('PaymentGateways.Pagseguro.active')) : ?>
								<?php echo $html->link(__('Purchase Using Pagseguro', true),'/payment_gateways/pagseguro/package/'.$package['Package']['id']); ?><br>
							<?php endif; ?>

							<?php if(Configure::read('PaymentGateways.Firstdata.active')) : ?>
								<?php echo $html->link(__('Purchase Using Firstdata', true),'/payment_gateways/firstdata/package/'.$package['Package']['id']); ?><br>
							<?php endif; ?>
							<?php if(Configure::read('PaymentGateways.Beanstream.active')) : ?>
								<?php echo $html->link(__('Purchase Using Beanstream', true),'/payment_gateways/beanstream/package/'.$package['Package']['id']); ?><br>
							<?php endif; ?>
							<?php if(Configure::read('PaymentGateways.Payfast.active')) : ?>
								<?php echo $html->link(__('Purchase Using Payfast', true),'/payment_gateways/payfast/package/'.$package['Package']['id']); ?><br>
							<?php endif; ?>
							<?php if(Configure::read('PaymentGateways.Multisafepay.active')) : ?>
								<?php echo $html->link(__('Purchase Using Multisafepay', true),'/payment_gateways/multisafepay/package/'.$package['Package']['id']); ?><br>
							<?php endif; ?>
							<?php if(Configure::read('PaymentGateways.AuthorizeNet.login')) : ?>
								<?php echo $html->link(__('Purchase Using Credit Card', true),'/payment_gateways/authorizenet/package/'.$package['Package']['id']); ?><br>
							<?php endif; ?>

							<?php if(Configure::read('PaymentGateways.Dotpay.id')) : ?>
								<?php echo $html->link(__('Purchase Using Dotpay', true), array('controller' => 'payment_gateways', 'action' => 'dotpay', 'package', $package['Package']['id'])); ?><br>
							<?php endif;?>
							
							<?php if(Configure::read('PaymentGateways.iDeal.layout')) : ?>
								<?php echo $html->link(__('Purchase Using iDeal', true), array('controller' => 'payment_gateways', 'action' => 'ideal', 'package', $package['Package']['id'])); ?><br>
							<?php endif;?>

							<?php if(Configure::read('PaymentGateways.DIBS.merchant')) : ?>
								<?php echo $html->link(__('Purchase Using DIBS', true), array('controller' => 'payment_gateways', 'action' => 'dibs', 'package', $package['Package']['id'])); ?><br>
							<?php endif;?>
								
							<?php if(Configure::read('PaymentGateways.Dalpaycheckout.merchant')) : ?>
								<?php echo $html->link(__('Purchase Using DalPay MasterCard', true), array('controller' => 'payment_gateways', 'action' => 'dalpaycheckout', 'package', $package['Package']['id'], 'mastercard')); ?><br>
							<?php endif;?>
							<?php if(Configure::read('PaymentGateways.Dalpaycheckout.merchant')) : ?>
								<?php echo $html->link(__('Purchase Using DalPay Visa', true), array('controller' => 'payment_gateways', 'action' => 'dalpaycheckout', 'package', $package['Package']['id'], 'visa')); ?><br>
							<?php endif;?>
								<?php if(Configure::read('PaymentGateways.Dalpaycheckout.merchant')) : ?>
								<?php echo $html->link(__('Purchase Using DalPay American Express', true), array('controller' => 'payment_gateways', 'action' => 'dalpaycheckout', 'package', $package['Package']['id'], 'amex')); ?><br>
							<?php endif;?>
							<?php if(Configure::read('PaymentGateways.Ogone.active')) : ?>
								<?php echo $html->link(__('Purchase Using Ogone', true), array('controller' => 'payment_gateways', 'action' => 'ogone', 'package', $package['Package']['id'])); ?><br>
							<?php endif;?>
                
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
            
