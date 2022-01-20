<?php

//set CKEditor settings
$oCKeditor->config['filebrowserBrowseUrl']=$this->webroot.'js/kcfinder/browse.php?type=files';
$oCKeditor->config['filebrowserImageBrowseUrl'] = $this->webroot.'js/kcfinder/browse.php?type=images';
$oCKeditor->config['filebrowserFlashBrowseUrl'] = $this->webroot.'js/kcfinder/browse.php?type=flash';
$oCKeditor->config['filebrowserUploadUrl'] = $this->webroot.'js/kcfinder/upload.php?type=files';
$oCKeditor->config['filebrowserImageUploadUrl'] = $this->webroot.'js/kcfinder/upload.php?type=images';
$oCKeditor->config['filebrowserFlashUploadUrl'] = $this->webroot.'js/kcfinder/upload.php?type=flash';


//set KCFinder session settings
$_SESSION['KCFINDER'] = array();
$_SESSION['KCFINDER']['disabled'] = false;
$_SESSION['KCFINDER']['uploadURL'] = "/webroot/img/content";
$_SESSION['KCFINDER']['uploadDir'] = "";