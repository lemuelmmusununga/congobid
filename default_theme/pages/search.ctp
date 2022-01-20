<?php 
$i = 1;
foreach($pages as $page): ?>
<div class="box clearfix">
	<div class="f-top-w clearfix">
		<h2>
			<?php echo $html->link($page['Page']['name'], array('controller' => 'pages', 'action'=>'view', $page['Page']['slug'])); ?> 
		</h2>
	</div>
	<div class="f-repeat-l clearfix">
		<div class="content pages_content">
			<?php echo $page['Page']['meta_description']; ?>
		</div>
	</div>
	<?php if(count($pages)==$i): ?>
	<div class="f-bottom-top clearfix"><p class="page_top"><a href="#" id="link_to_top">PAGE TOP</a></p></div>
	<?php else: ?>
	<div class="f-bottom-top clearfix"><p class="page_top"></p></div>
	<?php endif; ?>
</div>
<?php $i++; ?>
<?php endforeach; ?>