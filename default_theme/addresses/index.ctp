<style>
.shadow_bg{width: 1360px!important;}
</style>
<div class="step_titel">

<div class="doc_width"><h1><?php __('My Address');?></h1>
<?php
				$html->addCrumb('My Addresses', '/addresses');
				echo $this->element('crumb_user');
				?>
</div>


</div>
<div class="main_content">
<?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>

		<div class="doc_width shadow_bg">			
			<div class="inner_heading text-center"><h1><?php __('Address');?></h1></div>
			<div id="rightcol">
            <div class="rightcol_inner text-center">
				
				
				<?php if(!empty($address)) : ?>
					<?php foreach($address as $name => $address) : ?>
					
						<?php if(!empty($address)) : ?>
							
								<div class="address_table">							
								
								<div class="row">
								<div class="inner_heading text-center"><h1><?php __($name);?></h1></div>
								
								</div>
								
								<div class="row">
								<strong><?php __('Name');?> : </strong>
								<?php echo $address['Address']['name']; ?>
								</div>
							
								
								<div class="row">
								<strong><?php __('Address');?> : </strong>
								<?php echo $address['Address']['address_1']; ?>
								
								<?php if(!empty($address['Address']['address_2'])) : ?>, <?php echo $address['Address']['address_2']; ?><?php endif; ?>								
								</div>
								
								
								<div class="row">
								<strong><?php __('Suburb / Town');?> : </strong>
								<?php if(!empty($address['Address']['suburb'])) : ?><?php echo $address['Address']['suburb']; ?><?php else: ?>n/a<?php endif; ?>
								</div>
								
								
								<div class="row">
								<strong><?php __('City / State / County');?> : </strong>
								<?php echo $address['Address']['city']; ?>
								</div>
								
								
								<div class="row">
								<strong><?php __('Postcode');?> : </strong>
								<?php echo $address['Address']['postcode']; ?>
								</div>
								
								<div class="row">
								<strong><?php __('Country');?>: </strong>
								<?php echo $address['Country']['name']; ?>
								</div>
								
								
								<div class="row">
								<strong><?php __('Phone Number');?> : </strong>
								<?php if(!empty($address['Address']['phone'])) : ?><?php echo $address['Address']['phone']; ?><?php else: ?>n/a<?php endif; ?>
								</div>
								
								<div class="row">
								<a class="btn_new  animated-btn animated-1" href="/addresses/edit/<?php echo $name; ?>"><?php __('Edit');?></a>
								</div>
								</div>
													
						<?php else: ?>
							<p class="add text-center"><a class="btn_new  animated-btn animated-1 small_btn orange_btn" href="/addresses/add/<?php echo $name; ?>"><?php echo sprintf(__('Add a %s address', true), $name); ?></a></p>
                            
						<?php endif; ?>
					<?php endforeach; ?>
                    
				<?php endif; ?>
                
                
                </div>
			</div>
</div> 
    </div>
