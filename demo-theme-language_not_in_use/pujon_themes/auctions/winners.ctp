<div class="top_heading">
<div class="doc_width"><h1><?php __('Won Auctions'); ?></h1></div>
</div>

<div class="main_content">
        
		<div class="main_content_middle">			

		<?php if(!empty($auctions)) : ?>
				<?php echo $this->element('auctions'); ?>
				<?php echo $this->element('pagination'); ?>
			<?php else: ?>
				<div class="align-center off_message"><p><?php __('There are no won auctions at the moment.', true);?></p></div>
			<?php endif; ?>
	<br class="clear_l">
	<div class="crumb_bar">
			<?php
			$html->addCrumb(__('Winners', true), '/auctions/winners');
			echo $this->element('crumb_auction');
			?>
	</div>  
	</div>  
	</div>
        
        
        
        
        
        
        