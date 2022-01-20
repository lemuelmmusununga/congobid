<div class="box clearfix">
<div class="step_titel step_titel_step bold_title">
<div class="doc_width"><h1><?php __('Closed Auctions'); ?></h1></div>
</div>
<div class="main_content">
<div class="main_content_middle">
<p class="padding_left" style="margin-top:15px;margin-bottom:10px;"><?php __('These auctions have ended. Look out for more great bargains!');?></p>


<?php if(!empty($auctions)) : ?>
				<?php if(!empty($appConfigurations['endedLimit'])) : ?>
<p class="padding_left" style="padding-bottom:10px;"><strong><?php __('Showing the last');?> <?php echo $appConfigurations['endedLimit']; ?> <?php __('auctions.');?></strong></p>	
				<?php else : ?>	
				<?php endif; ?>
					
				<?php echo $this->element('auctions'); ?>
					
				<?php echo $this->element('pagination'); ?>

			<?php else: ?>
				<div class="align-center off_message"><p><?php __('There are no closed auctions at the moment.');?></p></div>
			<?php endif; ?>
	
	<br class="clear_l">

	<div class="crumb_bar">
			<?php
			$html->addCrumb(__('Closed Auctions', true), '/auctions/closed');
			echo $this->element('crumb_auction');
			?>
	</div>


</div>        			
			
</div>			
  </div>

				
        