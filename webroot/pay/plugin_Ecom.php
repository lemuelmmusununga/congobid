<?php

	// function to post generated xml with cUrl 
	function sendOverPost($url,$xml){ 

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);

		//for xml, change the content-type
		curl_setopt($ch, CURLOPT_SSLKEY, dirname(__FILE__) . "/key.pem");
		curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . "/ca.pem");
		curl_setopt($ch, CURLOPT_SSLCERT, dirname(__FILE__) . "/cert.pem");
		
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml")); //  multipart/form-data
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //return results
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		//send and return data to caller
		$result = curl_exec($ch);

		if(curl_errno($ch))
    		print curl_error($ch);
		else
    		curl_close($ch);
    
    	return $result;
 	   	//echo $result;

}
	
	// CREATE ORDER

function createOrder($operation,$language,$merchant,$amount,$currency,$description,$approveURL,$cancelURL,$declineURL,$orderType,$fee){ 
	//xml for create order
	$xw = xmlwriter_open_memory();
	xmlwriter_set_indent($xw, 1);
	$res = xmlwriter_set_indent_string($xw, ' ');

	xmlwriter_start_document($xw, '1.0', 'UTF-8');

	// A first element
	xmlwriter_start_element($xw, 'TKKPG'); // open xml tag

	// Start a child element
	xmlwriter_start_element($xw, 'Request'); // open xml tag

	xmlwriter_start_element($xw, 'Operation'); //open operation xml element
	xmlwriter_text($xw, $operation); //xml operation (data from variables)
	xmlwriter_end_element($xw); // Operation close xml tag

	xmlwriter_start_element($xw, 'Language'); // open language xml element
	xmlwriter_text($xw, $language); //xml language (data from variables)
	xmlwriter_end_element($xw); // Language close xml tag

	xmlwriter_start_element($xw, 'Order'); // open xml tag

	xmlwriter_start_element($xw, 'Merchant'); // open xml tag
	xmlwriter_text($xw, $merchant); //xml merchant (data from variables)
	xmlwriter_end_element($xw); // Merchant close xml tag

	xmlwriter_start_element($xw, 'Amount'); // open xml tag
	xmlwriter_text($xw, $amount); //xml amount
	xmlwriter_end_element($xw); // Amount close xml tag

	xmlwriter_start_element($xw, 'Currency'); // open xml tag
	xmlwriter_text($xw, $currency); //xml currency (data from variables)
	xmlwriter_end_element($xw); // Currency close xml tag

	xmlwriter_start_element($xw, 'Description'); // open xml tag
	xmlwriter_text($xw, $description);// xml description (data from variables)
	xmlwriter_end_element($xw); // Description close xml tag
 
	xmlwriter_start_element($xw, 'ApproveURL'); // open xml tag
	xmlwriter_text($xw, $approveURL); //(data from variables)
	xmlwriter_end_element($xw); // ApproveURL close xml tag

	xmlwriter_start_element($xw, 'CancelURL'); // open xml tag
	xmlwriter_text($xw, $cancelURL); //(data from variables)
	xmlwriter_end_element($xw); // CancelURL close xml tag

	xmlwriter_start_element($xw, 'DeclineURL'); // open xml tag
	xmlwriter_text($xw, $declineURL); //(data from variables)
	xmlwriter_end_element($xw); // DeclineURL close xml tag

	xmlwriter_start_element($xw, 'OrderType'); // open xml tag
	xmlwriter_text($xw, $orderType); //(data from variables)
	xmlwriter_end_element($xw);  //close xml tag

	xmlwriter_end_element($xw); // Order close xml tag

	xmlwriter_end_element($xw); // Request close xml tag

	xmlwriter_end_element($xw); // TKKPG close xml tag

	xmlwriter_end_document($xw);

	$xmlData = xmlwriter_output_memory($xw);

	//$urlReq = "https://acs2test.quipugmbh.com:6443/Exec";
	$urlReq = "https://mpi.quipugmbh.com:6443/Exec";
	//$urlReq = "https://mpi.quipugmbh.com:5443";
	
	$response = sendOverPost($urlReq, $xmlData);// response from server with url and xml
	//echo $response;
    $xmlRes = new SimpleXMLElement($response); //parse xml response

	$orderid = $xmlRes->Response[0]->Order[0]->OrderID; //getting orderID from response
	$sessionid = $xmlRes->Response[0]->Order[0]->SessionID; //getting sessionID from response
	$url = $xmlRes->Response[0]->Order[0]->URL; //getting URL from response

   
	//generate url to redirect browser
    $redirect = $url . "?ORDERID=" . $orderid . "&SESSIONID=" . $sessionid;
    
    header('Location: '.$redirect); 
    return;
}

//--------------------------------------------------------------------------------------------------

     //GET ORDER STATUS
	// accepts 5 variables
function getorderStatus($operation,$language,$merchant,$orderid,$sessionid){ 

    //xml for get order status
	$xw1 = xmlwriter_open_memory();
	xmlwriter_set_indent($xw1, 1);
	$res1 = xmlwriter_set_indent_string($xw1, ' ');

	xmlwriter_start_document($xw1, '1.0', 'UTF-8');

	// A first element
	xmlwriter_start_element($xw1, 'TKKPG'); // open xml tag

	// Start a child element
	xmlwriter_start_element($xw1, 'Request'); // open xml tag

	xmlwriter_start_element($xw1, 'Operation'); //open operation xml element
	xmlwriter_text($xw1, $operation); //xml operation 
	xmlwriter_end_element($xw1); // Operation close element

	xmlwriter_start_element($xw1, 'Language'); // open language xml element
	xmlwriter_text($xw1, $language); //xml language 
	xmlwriter_end_element($xw1); // Language close element

	xmlwriter_start_element($xw1, 'Order'); // open xml tag

	xmlwriter_start_element($xw1, 'Merchant'); // open xml tag
	xmlwriter_text($xw1, $merchant); //xml merchant 
	xmlwriter_end_element($xw1); // Merchant

	xmlwriter_start_element($xw1, 'OrderID'); // open xml tag
	xmlwriter_text($xw1, $orderid);  //xml orderID
	xmlwriter_end_element($xw1); // OrderID

	xmlwriter_end_element($xw1); // Order

	xmlwriter_start_element($xw1, 'SessionID'); // open xml tag
	xmlwriter_text($xw1, $sessionid); //xml sessionID
	xmlwriter_end_element($xw1); // SessionID

	xmlwriter_end_element($xw1); // Request

	xmlwriter_end_element($xw1); // TKKPG

	xmlwriter_end_document($xw1);

	$xmlData1 = xmlwriter_output_memory($xw1);

	
    //order status
    //$urlReq = "https://acs2test.quipugmbh.com:6443/Exec";
	$urlReq = "https://mpi.quipugmbh.com:6443/Exec";
    $orderStatus = sendOverPost($urlReq, $xmlData1);// response from server with url and xml
    return $orderStatus; 
}

//--------------------------------------------------------------------------------------------------

     //STOP AUTO RECUR PAYMENT
	// accepts 5 variables
function stopAutoRecur($operation,$language,$merchant,$orderid,$sessionid){ 

    //xml for get order status
	$xw2 = xmlwriter_open_memory();
	xmlwriter_set_indent($xw2, 1);
	$res2 = xmlwriter_set_indent_string($xw2, ' ');

	xmlwriter_start_document($xw2, '1.0', 'UTF-8');

	// A first element
	xmlwriter_start_element($xw2, 'TKKPG');

	// Start a child element
	xmlwriter_start_element($xw2, 'Request');

	xmlwriter_start_element($xw2, 'Operation'); //open operation xml element
	xmlwriter_text($xw2, $operation); //xml operation 
	xmlwriter_end_element($xw2); // Operation close element

	xmlwriter_start_element($xw2, 'Language'); // open language xml element
	xmlwriter_text($xw2, $language); //xml language 
	xmlwriter_end_element($xw2); // Language close element

	xmlwriter_start_element($xw2, 'Order');

	xmlwriter_start_element($xw2, 'Merchant');
	xmlwriter_text($xw2, $merchant); //xml merchant 
	xmlwriter_end_element($xw2); // Merchant

	xmlwriter_start_element($xw2, 'OrderID');
	xmlwriter_text($xw2, $orderid);  //xml orderID
	xmlwriter_end_element($xw2); // OrderID

	xmlwriter_end_element($xw2); // Order

	xmlwriter_start_element($xw2, 'SessionID');
	xmlwriter_text($xw2, $sessionid); //xml sessionID
	xmlwriter_end_element($xw2); // SessionID

	xmlwriter_end_element($xw2); // Request

	xmlwriter_end_element($xw2); // TKKPG

	xmlwriter_end_document($xw2);

	$xmlData2 = xmlwriter_output_memory($xw2);

	
    //order status
    //$urlReq = "https://acs2test.quipugmbh.com:6443/Exec";
	$urlReq = "https://mpi.quipugmbh.com:6443/Exec";
    $stoAutoRecurStatus = sendOverPost($urlReq, $xmlData2);// response from server with url and xml
    return $stoAutoRecurStatus; 
}

//----------------------------------------------------------------------------------------------------
	// CREATE RECUR PAYMENT
	// accepts 15 variables
function createRecurPayment($operation,$language,$merchant,$amount,$currency,$description,$approveURL,$cancelURL,$declineURL,$recurFrequency,$recurEndRecur,$recurPeriod,$recurRemoveOnDecline,$orderType,$fee){ 
	//xml for create order
	$xw3 = xmlwriter_open_memory();
	xmlwriter_set_indent($xw3, 1);
	$res3 = xmlwriter_set_indent_string($xw3, ' ');

	xmlwriter_start_document($xw3, '1.0', 'UTF-8');

	// A first element
	xmlwriter_start_element($xw3, 'TKKPG');

	// Start a child element
	xmlwriter_start_element($xw3, 'Request');

	xmlwriter_start_element($xw3, 'Operation'); //open operation xml element
	xmlwriter_text($xw3, $operation); //xml operation (data from variables)
	xmlwriter_end_element($xw3); // Operation close element

	xmlwriter_start_element($xw3, 'Language'); // open language xml element
	xmlwriter_text($xw3, $language); //xml language (data from variables)
	xmlwriter_end_element($xw3); // Language close element

	xmlwriter_start_element($xw3, 'Order');

	xmlwriter_start_element($xw3, 'Merchant');
	xmlwriter_text($xw3, $merchant); //xml merchant (data from variables)
	xmlwriter_end_element($xw3); // Merchant

	xmlwriter_start_element($xw3, 'Amount');
	xmlwriter_text($xw3, $amount); //xml amount
	xmlwriter_end_element($xw3); // Amount

	xmlwriter_start_element($xw3, 'Currency');
	xmlwriter_text($xw3, $currency); //xml currency (data from variables)
	xmlwriter_end_element($xw3); // Currency

	xmlwriter_start_element($xw3, 'Description');
	xmlwriter_text($xw3, $description);// xml description (data from variables)
	xmlwriter_end_element($xw3); // Description

	xmlwriter_start_element($xw3, 'ApproveURL');
	xmlwriter_text($xw3, $approveURL); //(data from variables)
	xmlwriter_end_element($xw3); // ApproveURL

	xmlwriter_start_element($xw3, 'CancelURL');
	xmlwriter_text($xw3, $cancelURL); //(data from variables)
	xmlwriter_end_element($xw3); // CancelURL

	xmlwriter_start_element($xw3, 'DeclineURL');
	xmlwriter_text($xw3, $declineURL); //(data from variables)
	xmlwriter_end_element($xw3); // DeclineURL

	xmlwriter_start_element($xw3, 'OrderType');
	xmlwriter_text($xw3, $orderType); //(data from variables)
	xmlwriter_end_element($xw3);

	xmlwriter_start_element($xw3, 'AddParams');
	
	xmlwriter_start_element($xw3, 'Purchase.Recur.frequency');
	xmlwriter_text($xw3, $recurFrequency); 
	xmlwriter_end_element($xw3);

	xmlwriter_start_element($xw3, 'Purchase.Recur.endRecur');
	xmlwriter_text($xw3, $recurEndRecur); 
	xmlwriter_end_element($xw3);

	xmlwriter_start_element($xw3, 'Purchase.Recur.period');
	xmlwriter_text($xw3, $recurPeriod); 
	xmlwriter_end_element($xw3);

	xmlwriter_start_element($xw3, 'Purchase.Recur.removeOnDecline');
	xmlwriter_text($xw3, $recurRemoveOnDecline); 
	xmlwriter_end_element($xw3);

	xmlwriter_end_element($xw3); // AddParams

	xmlwriter_end_element($xw3); // Order

	xmlwriter_end_element($xw3); // Request

	xmlwriter_end_element($xw3); // TKKPG

	xmlwriter_end_document($xw3);

	$xmlData3 = xmlwriter_output_memory($xw3);
	//echo $xmlData3;
	//$urlReq = "https://acs2test.quipugmbh.com:6443/Exec";
	$urlReq = "https://mpi.quipugmbh.com:6443/Exec";
	$result = sendOverPost($urlReq, $xmlData3);// response from server with url and xml
	//echo $result;

    $xmlRes = new SimpleXMLElement($result); //parse xml response

	$orderid = $xmlRes->Response[0]->Order[0]->OrderID; //getting orderID from response
	$sessionid = $xmlRes->Response[0]->Order[0]->SessionID; //getting sessionID from response
	$url = $xmlRes->Response[0]->Order[0]->URL; //getting URL from response

   
	//generate url to redirect browser
    $redirect = $url . "?ORDERID=" . $orderid . "&SESSIONID=" . $sessionid;
    
    header('Location: '.$redirect); 
    return;
}

?>