<style>
fieldset .text label, fieldset.contact .text label, fieldset.contact .select label, fieldset.contact .textarea label{
	float:none;
	display:inline-block;
	width: auto;
}
fieldset .text input, fieldset .password input, fieldset .select select, fieldset .textarea textarea{
	width: 250px;
	padding: 9px 2% 7px 6px;
}

.perfect_text{width:249px;}
.perfect_text{position:absolute;top:-90px;}
.totalresults{
	display:none;
}
.package_box li {
	margin-bottom:90px;
	color: #fff;
}
fieldset label { width:201px; } 
div.submit{display: inline-block;float: none;}
fieldset .form-container, fieldset .input{
	display: inline-block;
	clear: none;
	min-width: 383px;
}



</style>
<div class="box clearfix input_only_line">
<div class="step_titel">
<div class="doc_width"><h1><?php __('Paiement mobile');?></h1></div>
</div>
<div class="main_content">
 <div class="doc_width shadow_bg package_page">	
<div class="padd_30"> 

<?php if($step == 1){ ?>
  <!--  <h2 class="padd_b_20"><?php __('Conform / update your Phone number');?> </h2> -->
    <h2 class="padd_b_20"><?php __('Confirmez le numero ci-dessous ou renseignez un autre');?> </h2>
    
    <form name="f" method="post" action="/payment_gateways/mobile/<?php echo $model ?>/<?php echo $id ?>/2">
		<div class="edit_user">
            <div class="full_input">
                <label>Votre numero de paiement</label>
                <input type="tel" value="<?php echo $username ?>" name="user_phone" pattern=".{12,12}" required title="Invalid Phone number Eg: 243975695002 "   /> <br />
            </div>
		</div>		
		<p class="phone_hint">
       Format du numero (243xxxxxxxx)
		</p>	
		<br />
	  <div class="submit">	
     <input type="submit" class="btn_new  " value="Continuez" name="phone"  />
	 </div>
    </form>

<?php } ?>
<?php if($step == 2){
        $_SESSION['user_phone'] = $_POST['user_phone'];
        $datap['merchantkey'] = '25f8b192358c752f93860c522b9ddce4'; //test: 928845da33ec284f4365eac7a3e8a98d live: 25f8b192358c752f93860c522b9ddce4
        $url = 'https://apixpaygw1.exact-it.net/api/paymentmethods.php';  
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($datap));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        $result_arr = json_decode($result);
        $token = $result_arr->token ;
        $payment_options = $result_arr->data ; 
     
    ?>
     <h2 class="padd_b_20"><?php __('Choisissez votre service de Paiement');?> </h2>
    
    <form name="f" method="post" action="/payment_gateways/mobile/<?php echo $model ?>/<?php echo $id ?>/3">
       
    <div class="edit_user edit_user_break">
        <div class="full_input">
                <label>le numero de paiement</label>
                <input type="tel" value="<?php echo $_SESSION['user_phone'] ?>" name="user_phone" readonly />
                <input type="hidden" value="<?php echo $token  ?>" name="token" readonly      />
            </div>
	</div>
    

    <div class="edit_user edit_user_break">
        <div class="full_input">
<!--<label>Select Payment option:</label> -->
                <label>Clickez et choisisser votre service:</label>
                <select name="payment_option_id" id="payment_option_id">
                    <?php foreach($payment_options as $key=>$val){?>
                        <option value="<?php echo $val->id?>"><?php echo $val->name ?></option>
                    <?php } ?>
                </select>
            </div>
	</div>
        
		<br class="clear_br">
        <div class="submit">	
            <input type="submit" class="btn_new  " value="Payez" name="phone"  />
        </div>
 
    </form>

<?php } ?>


<?php if($step == 3){ ?>
    <h2><?php __('Verifiez et confirmer le paiement sur votre telephone');?> </h2>
    
   <?php 
    $data['token'] = $_POST['token'];
    $data['paymentmethodid'] = $_POST['payment_option_id'];
    $data['agentname'] =  $payle['first_name'];
    $data['agentphone'] = $_SESSION['user_phone'];
    $data['amount'] = $payle['amount']   ;
    $data['currency'] = 'USD'; // USD OR CDF
    $data['invoicenumber'] = $payle['key'];

    $url = 'https://apixpaygw1.exact-it.net/api/RequestPayment.php';
    $ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

 	$result1 = curl_exec($ch);  
 	$result2 = json_decode($result1); 
     $msg['eng']  = $result2->Message->EN;
     $msg['fre']  = $result2->Message->FR;
     $ref  = $result2->referencetrans ;
     $code  = $result2->Code ;
      if($code != 200){ echo '<script>window.location.href="/packages/index?error=1";</script>' ; }
     ?>
     
     <h3>MSG: <?php echo $msg[$appConfigurations['language']]; ?> </h3>  
      <h3>Referencetrans: <?php echo $ref ; ?> </h3>  

   <?php } ?>


        
	            

			 
</div> 
                
                
                
                
                
                
                 
             
                
 
				 			      
        </div>
    </div> 
    </div>
    </div>
            
