<div class="box clearfix">
<div class="step_titel">

<div class="doc_width"><h1><?php echo $news['News']['title']; ?></h1></div>

</div>
<div class="doc_width shadow_bg">
<div class="padd_25">		
			<?php
			$html->addCrumb(__('Latest News', true), '/admin/news');
			$html->addCrumb($news['News']['title'], '/admin/news/view/'.$news['News']['id']);
			echo $this->element('crumb');
			?>
			
			<p><?php echo $news['News']['content']; ?></p>
			
			<div class="meta"> <?php __('Date & Time Posted');?>  <?php echo $time->niceShort($news['News']['created']); ?></div>
			
			<p><?php echo $html->link('<< Back to news', array('action'=>'index')); ?></p>
    </div> 
    </div>
    </div>
