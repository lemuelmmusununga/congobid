<style>
.totalresults{
	display:none;
}
div.submit{
	min-width: 250px;
}
</style>
<?php 
$total  = $auction['Auction']['price'] + $auction['Product']['delivery_cost'];
?>

 <div class="box clearfix">
 <div class="step_titel">
<div class="doc_width"><h1>  <?php __('Pay for an Auction');?> </h1>
<?php
	$html->addCrumb(__('Won Auctions', true), '/auctions/won');
	$html->addCrumb(__('Pay for an Auction', true), '/auctions/pay/'.$auction['Auction']['id']);
	echo $this->element('crumb_user');
	
	
	//echo '<pre>';print_r($auction);echo '</pre>'; exit; 
	
	?>
</div>
</div>
<div class="main_content">
 <?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
	<div class="doc_width shadow_bg">

<div class="inner_heading text-center"><h1>
<?php echo $auction['Product']['title'] ?>

</h1></div>
	
			<div id="rightcol">
			<div class="rightcol_inner">            
				
             

	<p><?php __('You are about to pay');?>
	<strong>
	<?php if($auction['Product']['fixed'] > 0) : ?>
		<?php echo $number->currency($auction['Product']['fixed_price'], $appConfigurations['currency']); ?>
	<?php else: ?>
		<?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?>
	<?php endif; ?>
	</strong>
	<?php if(!empty($auction['Product']['delivery_cost'])):?>
	<?php __('+');?> <strong><?php echo $number->currency($auction['Product']['delivery_cost'], $appConfigurations['currency']); ?></strong>
	<?php __('for delivery');?><?php endif;?> 
	
	<?php __('for the auction titled', true);?>: 
	
	<strong><?php echo $number->currency( $total ) ;?></strong>
	

	</p>
	<p class="pay_img"> <img src="/img/<?php echo $auction['Auction']['image']; ?>"  alt=""/> 	</p> 

	<?php if(!empty($auction['Product']['delivery_information'])):?>
		<h3 class="font-20"><?php __('Delivery Information');?></h3>
		<p><?php echo $auction['Product']['delivery_information']; ?></p>
	<?php endif;?>

	<p><?php __('Please confirm that your address details are correct before paying for this item');?>:</p>

	<?php if(!empty($address)) : ?>
		<?php foreach($address as $name => $address) : ?>
		<br class="clearfix" style="float:none">
			<h2 class="font-20"><?php __($name);?></h2>
			<br class="clearfix" style="float:none">
			<?php if(!empty($address)) : ?>
				<div class="table-responsive">
				<table class="results" cellpadding="0" cellspacing="0">
				<tr>
					<th><?php __('Name');?></th>
					<th><?php __('Address');?></th>
					<th><?php __('Suburb / Town');?></th>
					<th><?php __('City / State / County');?></th>
					<th><?php __('Postcode');?></th>
					<th><?php __('Country');?></th>
					<th><?php __('Phone Number');?></th>
					<th class="actions"><?php __('Options');?></th>
				</tr>

				<tr>
					<td><?php echo $address['Address']['name']; ?></td>
					<td><?php echo $address['Address']['address_1']; ?><?php if(!empty($address['Address']['address_2'])) : ?>, <?php echo $address['Address']['address_2']; ?><?php endif; ?></td>
					<td><?php if(!empty($address['Address']['suburb'])) : ?><?php echo $address['Address']['suburb']; ?><?php else: ?>n/a<?php endif; ?></td>
					<td><?php echo $address['Address']['city']; ?></td>
					<td><?php echo $address['Address']['postcode']; ?></td>
					<td><?php echo $address['Country']['name']; ?></td>
					<td><?php if(!empty($address['Address']['phone'])) : ?><?php echo $address['Address']['phone']; ?><?php else: ?>n/a<?php endif; ?></td>
					<td><a class="btn_new  animated-btn animated-1 small_btn" href="/addresses/edit/<?php echo $name; ?>"><?php __('Edit');?></a></td>
				</tr>
				</table>
				</div>
			<?php else: ?>
				<p><a class="btn_new  animated-btn animated-1 small_btn" href="/addresses/add/<?php echo $name; ?>"><?php __('Add a ');?><?php echo $name; ?> <?php __('Address');?></a></p>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php if(!empty($addressRequired) && $auction['Product']['category_id'] != 83) : ?>
		<h2><?php __('Missing Address information');?></h2>
		
		<p>
		<?php __('Before purchasing the item please');?>
		<p>
		
		<a class="btn_new  animated-btn animated-1 small_btn" href="/addresses"><?php __('Update Address Information');?></a>
		
	<?php else : ?>	
	<br class="clearfix" style="float:none">
		<p> <?php __('If you feel that there may have been an error, please');?>  
	 
		<strong> <a  href="/contact">  <?php __('contact us before paying for your auction');?></a></strong>
		</p>

		 

		<?php if($total > 0) : ?>
			<h2><?php __('Payment Methods');?></h2>

		       					
				 
					<p> <?php __('To pay with a card, click PAY, then PAY WITH DEBIT OR CREDIT CARD on the next page');?> </p>
					<p>
<a style="margin-top: 5px;" class="btn_new  left-animated btn-blue blue_fill small_btn" href="/payment_gateways/paypal/auction/<?php echo $package['Package']['id']; ?>"> <?php __('Paypal');?> </a>						
<a style="margin-top: 5px;" class="btn_new  left-animated btn-blue blue_fill small_btn" href="/payment_gateways/payle/auction/<?php echo $package['Package']['id']; ?>"> <?php __('Carte bancaire');?> </a>						
<a style="margin-top: 5px;" class="btn_new  left-animated btn-blue blue_fill small_btn" href="/payment_gateways/mobile/auction/<?php echo $package['Package']['id']; ?>/1"> <?php __('Mobile Money');?> </a>						

					</p>
			 

			 
		<?php else : ?>
			<?php echo $form->create('Auction', array('url' => '/auctions/pay/'.$auction['Auction']['id']));?>
			<?php echo $form->hidden('id', array('value' => $auction['Auction']['id'])); ?>
			<?php echo $form->end(__('Confirm Your Details >>', true)); ?>
		<?php endif; ?>
	<?php endif; ?>
                </div>
			</div>
    </div> 
    </div>
    </div>



