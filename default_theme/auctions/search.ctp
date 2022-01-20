
<div class="box clearfix">
<div class="step_titel">
<div class="doc_width">
<h1><?php __('Your Search for:'); ?> <?php echo $search; ?></h1>
</div>


</div>




<div class="main_content">
<div class="doc_width shadow_bg">
<div class="padd_25">			

			<?php if(!empty($auctions)) : ?>
				<?php echo $this->element('auctions'); ?>
				<?php echo $this->element('pagination'); ?>
			<?php else: ?>
				<p><?php __('Your search returned no results, please try again.');?></p>
			<?php endif; ?>

		</div>
	<br class="clear_l">
	<div class="crumb_bar">
<?php
$html->addCrumb(__('Your Search', true), '/auctions/search/'.$search);
echo $this->element('crumb_auction');
?>
	</div>

</div> 
</div> 

</div>
</div>
