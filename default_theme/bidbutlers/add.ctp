<style>
fieldset div.submit {
    margin: 5px 0px 0px 209px !important;
}
.actions{margin-left: 210px;}
fieldset .text label, fieldset.contact .text label, fieldset.contact .select label, fieldset.contact .textarea label{
width:auto;
}
fieldset .text .error-message, fieldset .select .error-message, fieldset .textarea .error-message, fieldset .checkbox .error-message, fieldset .password .error-message{
margin-left: 150px;
}
</style>
<div class="box clearfix input_line input_only_line">
 <div class="step_titel">
<div class="doc_width"><h1> <?php __('Add BIDBUDDY');?> </h1></div>
</div>
<div class="main_content">
 <?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
		<div class="doc_width shadow_bg">			
			
			<div id="rightcol">
			<div class="rightcol_inner">            
				<?php echo $form->create(null, array('url' => '/bidbutlers/add/'.$auction['Auction']['id']));?>
				<?php __('Add a Bid Buddy for Auction');?> <a  href="/auctions/view/<?php echo $auction['Auction']['id']; ?>"><?php echo $auction['Product']['title']; ?></a>
				
				<fieldset>
					
					<p><?php __('Your bids will be used when the counter reaches');?> <?php echo Configure::read('Settings.bid_butler_time'); ?> <?php __('seconds.');?></p>
			
					<?php if($appConfigurations['bidButlerType'] == 'advanced') : ?>
						<p><?php __('The minimum price must be at least');?> <?php echo $number->currency(0.01, $appConfigurations['currency']);?> <?php __('higher than the current bid.');?></p>
					<?php endif; ?>
				<?php
					if($appConfigurations['bidButlerType'] == 'advanced') :
						echo $form->input('minimum_price', array('label' => __('Minimum Price *', true)));
						echo $form->input('maximum_price', array('label' => __('Maximum Price *', true)));
					endif;
					echo $form->input('bids', array('label' => __('Number of Bids to use *', true)));
				?>
				<?php echo $form->end(__('ADD A BID BUDDY', true));?>
				</fieldset>
			
			<div class="actions">
				<ul>
					<li><?php echo $html->link(__('<< Back to the auction', true), array('controller' => 'auctions', 'action' => 'view', $auction['Auction']['id']));?></li>
					<li><?php echo $html->link(__('<< Back to my Bid Buddies', true), array('action' => 'index'));?></li>
				</ul>
			</div>
                </div>
			</div>
    </div> 
    </div>
    </div>




