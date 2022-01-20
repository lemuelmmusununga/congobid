<?php
if(!empty($auctions_end_soon)) : ?>


<div class="main_content">

<div class="doc_width">
<h1 class="home_heading"><?php __('Live Auctions');?></h1>    
<?php echo $this->element('auctions', array('auctions'=>$auctions_end_soon)); ?>


<h1 class="home_heading"><?php __('Future Auctions');?></h1>  
<?php echo $this->element('auctions_undated', array('auctions'=>$auctions_undated)); ?>



 
 


</div>
</div>
 
<?php endif; ?>

 

<?php if(!$_COOKIE['shown_video']){?>
<div id="videoModal">
	<div class="modal-dialog">
	<div class="modal-content">
	<span class="close-btn"></span>
		<video  controls loop="true" autoplay="true" id="theVideo">
		<source src="<?php echo $this->webroot;?>img/video1.mp4" type="video/mp4" />
		</video>
	</div>
	
	</div>
</div>
<?php  setcookie("shown_video", 1,  time()+7200  ); 
} ?>
<script>
$('.close-btn').click(function() {
	close();
});
$( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) { // ESC
		close();	 
    }
});
function close(){
	$('#videoModal').fadeOut('slow');  
	$('#theVideo').get(0).pause();
	$('#theVideo').get(0).currentTime = 0;
	setcookie("shown_video", 1, <?php echo time()+7200 ?>);  /* expire in 1 hour */
}

</script>