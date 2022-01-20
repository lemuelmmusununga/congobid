<div class="box clearfix">
<div class="step_titel step_titel_step bold_title">
<div class="doc_width"><h1><?php __('Future Auctions'); ?></h1></div>
</div>
<div class="main_content">        
<div class="main_content_middle">			
			<?php if(!empty($auctions)) : ?>
				<?php echo $this->element('auctions'); ?>
				<?php echo $this->element('pagination'); ?>
			<?php else: ?>
				<div class="align-center off_message"><p><?php __('There are no future auctions at the moment.');?></p></div>
			<?php endif; ?>
		<br class="clear_l">
		<div class="crumb_bar">
			<?php
			$html->addCrumb(__('Future Auctions', true), '/auctions/future');
			echo $this->element('crumb_auction');
			?>
		</div>


            </div>  
</div>
</div>        