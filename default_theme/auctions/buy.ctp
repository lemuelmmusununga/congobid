<style>
fieldset div.submit{
	margin-left:0px!important;
	margin-top:5px!important;
}
</style>
<?php
	$auction['Product']['title'] =  $auction['Product']['title_eng']  ;	
?>
 <div class="box clearfix">
 <div class="step_titel">
<div class="doc_width"><h1> <?php __('Buy This Auction Now:');?> 
<span style="opacity:0.7;"><?php echo $auction['Product']['title']; ?></span> </h1></div>
</div>
<div class="main_content canel">
 <?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
 
		<div class="doc_width shadow_bg">			
		
			<div id="rightcol">
			<div class="rightcol_inner">                        
		<p><?php __('You are about to purchase this auction now for:');?> 
		<strong><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></strong></p>
			
			<p>
				<?php echo $form->create('Auction', array('url' => '/auctions/buy/'.$auction['Auction']['id']));?>
				<?php echo $form->hidden('id', array('value' => $auction['Auction']['id'])); ?>
				<?php echo $form->end(__('Purchase this Auction Now >>', true)); ?>
			</p>
               
			</div>
            </div>
    </div> 
    </div>
    </div>
