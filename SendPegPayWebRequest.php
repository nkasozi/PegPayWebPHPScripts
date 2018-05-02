<?php

//globals
$VendorCode = "WATOTO-CHURCH";
$Item_Total = $_POST['Item_Total'];; // Make sure this value is supplied
$Item_Description = "Offertory";
$Currency = "UGX";
$ReturnUrl = "http://watotochurch.com/transact";
$Password = "T3rr1613";
$SecretKey = 'T3rr16132016';
$HashAlgorithm = 'sha256';
$MerchantId = "100138";


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
