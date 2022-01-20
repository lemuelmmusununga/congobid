<div class="box clearfix">
<div class="step_titel">
<div class="doc_width">
<h1><?php __('Plans'); ?></h1>
</div>


</div>




<div class="main_content">
<div class="main_content_middle">			
	 
<ul class="categories">
<?php foreach($appConfigurations['subscription_pack'] as $key=>$category): if($key == 0) continue;  ?>
	<li>
		<div class="align-center auction-item">
			<div class="title">
				<h3><?php echo  $category ; ?></h3>
				<p>Price: <?php echo $appConfigurations['subscription_pack_price'][$key] ; ?> bids </p>
				<p>Bidding Slab: Up to <?php echo $number->currency($appConfigurations['subscription_pack_rrp'][$key] ,$appConfigurations['currency']);  ?></p>
			</div>
			<div class="thumb hide">
 					<?php echo $html->link($html->image('category_images/thumbs/'.$category['Category']['image'], array('border' => 0)), AppController::CategoryLink($category['Category']['id'], $category['Category']['name']), null, null, false); ?>
			 
			</div>
		</div>
	</li>
<?php endforeach;?>
</ul>	 
	 
</div> 

</div>
</div>
