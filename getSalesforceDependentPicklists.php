//Insert login environment variables (may need to add logins to userAuth.php as well), modify file paths, download the Salesforce PHP toolkit, download partner wsdl from your org

<html><body>
<?php
// SOAP_CLIENT_BASEDIR - folder that contains the PHP Toolkit and your WSDL
// $USERNAME - variable that contains your Salesforce.com username (must be in the form of an email)
// $PASSWORD - variable that contains your Salesforce.com password

define("USERNAME", "INSERT USERNAME");
define("PASSWORD", "INSERT PASSWORD+SECURITY TOKEN");
$wsdl = '/wsdl.xml';

define("SOAP_CLIENT_BASEDIR", "/home/ubuntu/workspace/Force.com-Toolkit-for-PHP-master/soapclient");
require_once (SOAP_CLIENT_BASEDIR.'/SforcePartnerClient.php');
require_once (SOAP_CLIENT_BASEDIR.'/SforceHeaderOptions.php');
require_once ('../samples/userAuth.php');

try {
  $mySforceConnection = new SforcePartnerClient();
  $mySoapClient = $mySforceConnection->createConnection(SOAP_CLIENT_BASEDIR.'/partner.wsdl.xml');
  $mylogin = $mySforceConnection->login($USERNAME, $PASSWORD);
  $result = $mySforceConnection->describeSObject('Opportunity');
  
  for($i=0; $i < count($result->fields); $i++){
	if($result->fields[$i]->name == "INSERT_PARENT_PICKLIST__c"){
		$sub = count($result->fields[$i]->picklistValues);
		for($j=0;$j < $sub; $j++){
 			$finalApplicableOptions[$j][0] = $result->fields[$i]->picklistValues[$j]->label;
			$finalApplicableOptions[$j][1] = array();
		                                       }
	                           }
  }
  //print_r($finalApplicableOptions);
  for($i=0;$i < count($result->fields); $i++){
	if($result->fields[$i]->name == "INSERT_CHILD_PICKLIST__c"){
		for($j=0;$j < count($result->fields[$i]->picklistValues); $j++){
			$byteArr = $result->fields[$i]->picklistValues[$j]->validFor;
			$maparray = array();
			$map = "";
			foreach(str_split($byteArr) as $c)
				$maparray [] = sprintf("%08b", ord($c));
			$map = implode("", $maparray );
			for ($k = 0; $k < strlen($map); $k++){
 				if($map{$k} == "1")
 					$finalApplicableOptions[$k][1][] =
  						$result->fields[$i]->picklistValues[$j]->label;
			                                                            }
		                                                   }
	                                            }
}
	print_r($finalApplicableOptions);

} catch (Exception $e) {
  echo $mySforceConnection->getLastRequest();
  echo $e->faultstring;
}
?> 

</body>
</html>
