<div class="box clearfix">
<div class="step_titel">
<div class="doc_width">
<h1><?php echo $category['Category']['name']; ?></h1>
</div>


</div>




<div class="main_content">
<div class="main_content_middle">			

	<?php if(!empty($categories)) : ?>
				<?php if(!empty($auctions)) : ?>
				<h2><?php __('Subcategories'); ?></h2>
				<?php endif; ?>
				<?php echo $this->element('categories'); ?>
			<?php endif; ?>
			
			<?php if(!empty($auctions)) : ?>
				<?php echo $this->element('auctions'); ?>
				<?php echo $this->element('pagination'); ?>
			<?php elseif(empty($categories)) : ?>
				<div class="align-center off_message"><p><?php __('There are no auctions in this category at the moment.');?></p></div>
			<?php endif; ?>

		<div class="crumb_bar">
			<?php
			$html->addCrumb(__('Categories', true), '/categories');
			if(!empty($parents)) :
				foreach($parents as $parent) :
					$html->addCrumb($parent['Category']['name'], '/categories/view/'.$parent['Category']['id']);
				endforeach;
			endif;
			echo $this->element('crumb_auction');
			?>
		</div>

</div> 

</div>
</div>
