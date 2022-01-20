<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-MFPGMKQP4P"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-MFPGMKQP4P');
</script>

<title>phpPennyAuction Software (v2.5)</title>
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '348268960193235');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=348268960193235&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="a.validate.01" content="d0c4dd47536efb5f7c456f49a16e1f77cccd" />
</head>
<body>
	<div class="container">
		<div class="span-24 last colborder box" style="background-color:#395584; text-align:center; padding:10px">
        <p style="font-size:20px; color:White">phpPennyAuction</p>
		</div>
		
		<div class="span-24">
		<script type="text/javascript">

$(document).ready(function () {
	$('input#install_radio1').click(function () {
		$('input#custom_dir').attr('readonly','readonly')
	});
	$('input#install_radio2').click(function () {
		$('input#custom_dir').removeAttr('readonly').focus();
	});
		
	$('input#custom_dir').attr('readonly','readonly').click(function () {
		$(this).removeAttr('readonly');
		$('input#install_radio2').attr('checked', 'checked');
	});
});

</script>

<h1>phpPennyAuction is not yet completely installed.</h1>

<p>Please check the following:</p>

<ol>
	<li>That both of your .htaccess files are present and correct.</li>
	<li>That your server has mod_rewrite installed</li>
	<li>That your server is configured with <b>AllowOverride</b> set to <b>All</b></li>
</ol>

<p>If you need further assistance, please contact <a href="https://members.phppennyauction.com" target="_blank">phpPennyAuction Support</a>.

		</div>
		
		<div class="last span-24 quiet box prepend-top">
		All contents &copy; 2012 Scriptmatix Ltd. <a href="http://www.phppennyauction.com" target="_blank">phpPennyAuction</a>

		</div>
	</div>
</body>
</html>
