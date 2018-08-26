<?php
 //if  its a valid pegasus response then these values will be set
 $Status = isset($_GET["Status"])?$_GET["Status"]:"";
 $Reason = isset($_GET["Reason"])?$_GET["Reason"]:"";
 $VendorTranId = isset($_GET["VendorID"])?$_GET["VendorID"]:"";
 $DigitalSignature = isset($_GET["DigitalSignature"])?$_GET["DigitalSignature"]:"";
 $SecretKey = "TheSecretKeyThatWasSharedWithYou";//change this btw
 $DataToVerify= $Status.$Reason.$VendorTranId;
 $HashAlgorithm = 'sha256';
 
 //verify authenticity of response by confirming 
 //it has not been tampered with (verify digitalSignature)
 $ComputedDigitalSignature = hash_hmac($HashAlgorithm,$DataToVerify,$SecretKey);
 
  
 //something is wrong with this response..its not authentic
 if($ComputedDigitalSignature!=$DigitalSignature)
 {
	 $result = '<div class="alert alert-danger">INVALID RESPONSE. PLEASE CONTACT System ADMINISTRATORS</div>';
	 echo $result;
	 return;
 }
 
 $TransactionId = isset($_GET["TranRef"])?$_GET["TranRef"]:"";
 
 //response is authentic and 
 //transaction failed
 if ($Status != "SUCCESS") 
 {
	$result = '<div class="alert alert-danger">Transaction Failed :'.$Reason.'</div>';
	echo $result;
	return;
 }
 
 //transaction succeeded
 $result = '<div class="alert alert-success">Transaction Completed. Receipt Number:'.$TransactionId.'</div>';
 echo $result;
 return;
?> 
