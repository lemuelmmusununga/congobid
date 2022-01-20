<?php if(!isset($_COOKIE['promotional_popup'])) { ?> 
<div class="popubg" style="display:none1;">
<div class="popup_box">
<?php 
$promotion_popup = mysql_fetch_array(mysql_query("SELECT content FROM pages WHERE id = '25'"), MYSQL_ASSOC);
	echo 	$promotion_popup['content'] ; 	
?>
<div class="gotit_btn"><a class="promotional_popup_close" href="javascript:void(0)">Got it</a></div>


</div>
</div>

<script> 
$('.promotional_popup_close').click(function(){
		$('.popubg').hide();
		var now = new Date();
		var time = now.getTime();
		time += 3600 * 1000; // 1 hour
		now.setTime(time);
		document.cookie = 
		'promotional_popup=1; expires='+ now.toUTCString()+'; path=/'; 
});
</script> 
<?php } ?>