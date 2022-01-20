<?php if($this->params['action'] == 'home'){ ?>
<LINK rel="stylesheet" type="text/css" href="<?php echo $appConfigurations['nml_url'];?>/css/slide/style_slide.css">
<LINK rel="stylesheet" type="text/css" href="<?php echo $appConfigurations['nml_url'];?>/css/slide/skin_slide.css">

<SCRIPT type="text/javascript">  
  function mycarousel_initCallback(carousel)
  {
    // Disable autoscrolling if the user clicks the prev or next button.
    carousel.buttonNext.bind('click', function() {
      carousel.startAuto(0);
    });
 
    carousel.buttonPrev.bind('click', function() {
      carousel.startAuto(0);
    });
 
    // Pause autoscrolling if the user moves with the cursor over the clip.
    carousel.clip.hover(function() {
      carousel.stopAuto();
    }, function() {
      carousel.startAuto();
    });
  };
   
  jQuery(document).ready(function() {
    jQuery('#mycarousel').jcarousel({
      auto: 4,
      wrap: 'last',
	  animation: 1000,
      initCallback: mycarousel_initCallback
    });
  });
  </SCRIPT>



<div class="bnrbg">
  <DIV class="slider">
    <DIV class=" jcarousel-skin-tango">
      <DIV class="jcarousel-container jcarousel-container-horizontal" style="position: relative; display: block; ">
        <DIV class="jcarousel-clip jcarousel-clip-horizontal" style="overflow-x: hidden; overflow-y: hidden; position: relative; ">
          <UL id="mycarousel" class="jcarousel-list jcarousel-list-horizontal" style="overflow-x: hidden; overflow-y: hidden; position: relative; top: 0px; margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; width: 1800px; left: -900px; ">
			<li><img src="<?php echo $this->webroot;?>img/slide1.png"/></li>           
            <li><img src="<?php echo $this->webroot;?>img/slide2.png"/></li>
            <li><img src="<?php echo $this->webroot;?>img/slide1.png"/></li>
          </UL>
        </DIV>
        <DIV class="jcarousel-prev jcarousel-prev-horizontal" style="display: block; " disabled="false"></DIV>
        <DIV class="jcarousel-next jcarousel-next-horizontal" style="display: block; " disabled="false"></DIV>
        
      </DIV>
    </DIV>
  </DIV>

 
</div>


<?php } ?>

