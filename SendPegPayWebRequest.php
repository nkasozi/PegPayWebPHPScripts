<?php

//globals...stuff that needs to be defined before we can proceed
// you should fetch these values from a db or have user supply them
//depends on your app
$VendorCode = "TheVendorCodePegasusGaveYou";  //Make sure this value is suppliede.g $_POST['Item_Total']
$Item_Total = "500"; // Make sure this value is suppliede.g $_POST['Item_Total']
$Item_Description = "A brief Description of the Item Purchased"; // Make sure this value is suppliede.g $_POST['Item_Total']
$Currency = "UGX";
$ReturnUrl = "http://your.website.com/Reciept.php";//this URL will be called at the end of the payment and customer will be redirected there
$Password = "ThePasswordPegasusGaveYou"; // Make sure this value is suppliede.g $_POST['Item_Total']
$SecretKey = 'TheSecretKeyPegasusGaveYou'; //Make sure this value is suppliede.g $_POST['Item_Total']
$HashAlgorithm = 'sha256';
$MerchantId = "TheMerchantCodePegasusGaveYou";// Make sure this value is suppliede.g $_POST['Item_Total']
$UniqueTransactionId="AUniqueIdentifierForThisTransactionInYourSystem";//maybe fetch this from the database


function SendPhpWebRequest($VendorCode,$UniqueTransactionId, $Item_Total, $Item_Description, $ReturnUrl, $Password, $SecretKey, $MerchantId)
{
	//globals
	$Currency = "UGX";
	$HashAlgorithm = 'sha256';
	$URL_TO_API = "http://41.210.174.210:8019/TestPegasusPaymentsGateway/Default.aspx?";

	// quick way to generate a unique ID..
	// ideally you should generate this from the DB if u want to use later to trace the payment
	// VendorTranId means unique ID from your system which u can use later to trace a transaction 
	// e.g if u want to give a receipt
	$VendorTranId = $UniqueTransactionId;

	// password and digital signature hashing
	$password = hash_hmac($HashAlgorithm,$Password,$SecretKey);
	$dataToSign = $VendorCode.$MerchantId.$Item_Total.$Item_Description.$Currency.$ReturnUrl.$VendorTranId;
	$Digital_Signature = hash_hmac($HashAlgorithm, $dataToSign, $SecretKey);
	$data_string = "VENDORCODE=".$VendorCode."&PASSWORD=".$password."&VENDOR_TRANID=".$VendorTranId."&ITEM_TOTAL=".$Item_Total."&ITEM_DESCRIPTION=".$Item_Description."&CURRENCY=".$Currency."&RETURN_URL=".$ReturnUrl."&DIGITAL_SIGNATURE=".$Digital_Signature."&MERCHANTCODE=".$MerchantId; 

	// we have it all, lets generate full URL with GET Parameters
	$url= $URL_TO_API.$data_string;

	// quick way to redirect browser to a URL
	echo '<script>location.href="'.$URL.'";</script>';
}

?>
