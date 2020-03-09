<html>
<head>
  <meta charset="UTF-8">
 <title>My LIFF v2</title>
</head>
<body>
  <?php
  
$client = new SoapClient('http://localhost:52108/WebService.asmx?WSDL',array('trace'=>true));
  try
  {
  $params = array('a'=>5,''b=>8);
  $result = $client->countnum($params)->countnumResult;
  }catch(SoapFault $ex){
    print $ex
  }
  echo "hello".$result

?>
</body>
</html>
