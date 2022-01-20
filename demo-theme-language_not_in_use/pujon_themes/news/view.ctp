<div class="box clearfix">
<div class="top_heading">

<div class="doc_width"><h1><?php echo $news['News']['title']; ?></h1></div>

</div>
<div class="main_content">
 
		<div class="main_content_middle main_content_middle2">			
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
