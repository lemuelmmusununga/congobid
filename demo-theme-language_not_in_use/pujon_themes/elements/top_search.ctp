<style>
.top_search li ul.drop_menu {
	display:none;
}
.search-form input{
    border-radius: 8px;
	display:block;
	background:#fff;
	position:absolute;
	padding:6px 10px 5px 6px;
	height:auto;
	z-index:3;
        width: 160px;
	border-top:none!important;
	border:1px solid #fff;
        height: 14px !important;
        line-height: 20px;
    /*width: 230px;*/
}

.top_search li:hover ul.drop_menu {
	border-bottom-right-radius:6px;	
	border-bottom-left-radius:6px;		
	display:block;
	background:#46484a;
	position:absolute;
	width:218px;
	padding:6px;
	height:auto;
	z-index:3;
	left:0px;
	top:43px;
	border-top:none!important;
	border:1px solid #8b8b8b;
}
.top_search li:hover ul.drop_menu li {
	width:197px;
	float:left;
	height:30px;
	text-align:left;
	padding:0px;
}

.top_search li:hover ul.drop_menu li a {
	line-height:18px;
	padding:3px 5px 3px 5px;
	border-bottom:1px solid #5a5c5d;
	margin:0px 0px 0px 0px;
	width:185px;
	float:left;
	background:#46484a;
	text-shadow:0px 0px 0 #fff;			
	color:#fff;
	text-align:left;
	font-size:11px;
	font-weight:normal;
}
.top_search li:hover ul.drop_menu li a:hover {
	color:#efe76a;
	
}

</style>


<ul>
<li><a class="how_itwork" href="<?php echo $this->webroot; ?>page/how-it-works"><?php __('How It Works');?></a></li> 

<li style="padding-left:0px;">

<form method="post" action="/auctions/search">
<input class="search_bg" type="text" onclick="javascript:if(this.value == 'Search live auction, prducts, and more...'){this.value='';}" name="data[Auction][search]" maxlength="40" value="Search live auction, prducts, and more..." id="UserUsername">
<span><input type="image" src="<?php echo $this->webroot; ?>img/search_icon.gif" value=""></span>
</form>

</li>




<li class="drop" style="background-image:none; padding:15px 0px 0px 0px; position:relative;z-index:10">
<a class="cat"  href="/categories/view/<?php echo $menuCategory['Category']['id']; ?>" ><?php __('Categories');?></a>

<ul class="drop_menu">
<?php foreach($menuCategories as $menuCategory): ?>
	<li style="background-image:none;"><a  href="/categories/view/<?php echo $menuCategory['Category']['id']; ?>">
	<?php echo $menuCategory['Category']['name']; ?>(<?php echo $menuCategory['Category']['count']; ?>)</a></li>
<?php endforeach; ?>    
</ul>
</li>



     
</ul>
