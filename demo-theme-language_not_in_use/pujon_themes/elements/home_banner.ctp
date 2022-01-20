
<?php echo $javascript->link('slider_js/jquery.flow.1.0'); ?>
<script type="text/javascript">
$(document).ready(function(){

	$("#myController").jFlow({
		slides: "#mySlides",
		width: "1102px",
		height: "507px",
		duration: 400
	});
});


</script>

<div class="bnrbg">
     <div id="header_lower">
        <div class="slider-wrap">
          <div class="slider">
            <div id="mySlides">
				<div><img src="<?php echo $this->webroot; ?>img/sl_1.png" alt="" /></div>
				<div><img src="<?php echo $this->webroot; ?>img/sl_2.png" alt="" /></div>
				<div><img src="<?php echo $this->webroot; ?>img/sl_3.png" alt="" /></div>
				<div><img src="<?php echo $this->webroot; ?>img/sl_4.png" alt="" /></div>                
           </div>
          </div>
        </div>
        <div class="slider_nav">
          <div class="slider_nav_left">
            <div id="myController"> 
            <span class="jFlowControl">&nbsp;</span> 
            <span class="jFlowControl">&nbsp;</span> 
            <span class="jFlowControl">&nbsp;</span> 
            <span class="jFlowControl">&nbsp;</span>             
            </div>
          </div>
        </div>
      </div>
  </div>

