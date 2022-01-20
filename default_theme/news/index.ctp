 <div class="box clearfix">
<div class="step_titel">
<div class="doc_width"><h1><?php __('Latest News');?></h1></div>
</div>
<div class="doc_width shadow_bg">
<div class="padd_25">			
			<?php
			$html->addCrumb(__('Latest News', true), '/admin/news');
			echo $this->element('crumb');
			?>
			
			<?php if(!empty($news)) : ?>
			
			<?php echo $this->element('pagination'); ?>
			<ul class="news">
			<?php foreach ($news as $news): ?>
				<li>
					<h2 class="heading"><?php echo $html->link($news['News']['title'], array('action'=>'view', $news['News']['id'])); ?></h2>
					<p><?php echo $news['News']['brief']; ?>...<?php echo $html->link('more', array('action'=>'view', $news['News']['id'])); ?></p>
					<div class="meta"> <?php __('Date & Time Posted');?> <?php echo $time->niceShort($news['News']['created']); ?></div>
				</li>
			<?php endforeach; ?>
			</ul>
			<?php echo $this->element('pagination'); ?>
			
			<?php else: ?>
				<p><?php __('There is no news at the moment.');?></p>
			<?php endif; ?>

    </div> 
 </div>
  </div>
