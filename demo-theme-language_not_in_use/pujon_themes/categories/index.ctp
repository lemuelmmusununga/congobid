<div class="box clearfix">
<div class="step_titel">
<div class="doc_width">
<h1><?php __('Categories'); ?></h1>
</div>


</div>




<div class="main_content">
<div class="main_content_middle">			
	<?php if(!empty($categories)) : ?>
				<?php echo $this->element('categories'); ?>
			<?php else: ?>
				<p><?php echo $j['no_categories']; ?></p>
			<?php endif; ?>
		<br class="clear_l">
		<div class="crumb_bar">
			<?php
			$html->addCrumb(__('Categories', true), '/categories');
			echo $this->element('crumb_auction');
			?>
		</div>
</div> 

</div>
</div>
