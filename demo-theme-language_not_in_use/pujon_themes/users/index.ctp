<div class="box clearfix">
<div class="step_titel">
<div class="doc_width"><h1><?php echo sprintf(__('My %s', true), $appConfigurations['name']); ?></h1></div>
</div>
<div class="main_content">
 
 
 
		<div class="main_content_middle">			
			<div id="leftcol">
				<?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
			</div>
			<div id="rightcol">
			<div class="rightcol_inner">
				<?php
				$html->addCrumb(__('Dash Board', true), '/users');
				echo $this->element('crumb_user');
				?>
				
				<h3 class="thigstodo"><?php __('Things to do:');?></h3>
				<ul class="to-do">
				<?php if(!empty($userAddress)) : ?>
					<?php foreach($userAddress as $name => $address) : ?>
						<?php if(empty($address)) : ?>
							<?php $count = 1; ?>
							<li><a href="/addresses/add/<?php echo $name; ?>"><?php __('Add a');?> <?php echo $name; ?> <?php __('Address');?></a></li>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
				
				<?php if($bidBalance == 0) : ?>
					<?php $count = 1; ?>
					<li><a href="/packages"><?php __('Purchase some bids');?></a></li>
				<?php endif; ?>
				
				<?php if($unpaidAuctions > 0) : ?>
					<?php $count = 1; ?>
					<li><a href="/auctions/won"><?php __('Pay for an Auction');?></a></li>
				<?php endif; ?>
				
				<?php if(empty($count)) : ?>
					<li><?php __('You have no things to do at the moment.');?></li>
				<?php endif; ?>
				</ul>
				
                
                <div class="users_left_bottom">
				<h3 class="home_icon"><?php __('My Dash Board');?></h3>
				<div class="users_content">
				<p class="graycolor"><?php echo sprintf(__('You currently have %s bids.', true), '<strong>'.$bidBalance.'</strong>');?><br>
<a class="purchase-bid" href="/packages"><?php __('Click here to purchase some bids');?></a></p>
				
				<p class="graycolor"><?php echo sprintf(__('You currently have %s unpaid auction(s).', true), '<strong>'.$unpaidAuctions.'</strong>');?><br>
<a href="/auctions/won"><?php __('View your won auctions');?></a></p>
                </div>
                </div>
                
                
			</div>                
			</div>
        
    </div> 
    </div>
    </div>
            
