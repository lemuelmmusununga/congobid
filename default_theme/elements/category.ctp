<style>
.step_titel{margin-bottom: 0px;}
</style>
<div class="category-outer">
<div class="category" onscroll="myFunction()">
<div class="doc_width">
<ul>
<?php foreach($menuCategories as $menuCategory): ?>
	<li><a  href="/categories/view/<?php echo $menuCategory['Category']['id']; ?>">
	<?php echo $menuCategory['Category']['name']; ?> </a></li>
<?php endforeach; ?>
</ul>
</div>
</div>
</div>
 <script> 
  function myFunction() {
    var scrollbar = $('.category').scrollLeft();
      if(scrollbar > 10){
	    $('.category').addClass('scroll');
	  }
	  else{
	  $('.category').removeClass('scroll');
	  }
 	}	
   </script>