<?php
    include "ws-security.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Equipamentos</title>
</head>
<body>

<?php

$options = array( 'location' => 'https://servicos.saude.gov.br/cnes/EquipamentoService/v1r0', 
                  'encoding' => 'utf-8', 
                  'soap_version' => SOAP_1_2,
                  'connection_timeout' => 180,
                  'trace'        => 1, 
                  'exceptions'   => 1 );

$client = new SoapClient('https://servicos.saude.gov.br/cnes/EquipamentoService/v1r0?wsdl', $options);   
$client->__setSoapHeaders(soapClientWSSecurityHeader('CNES.PUBLICO', 'cnes#2015public'));

$function = 'consultarEquipamentos';

$arguments = array( 'equ' => array(
  						'CodigoCNES' => array(
  	                         'codigo' => '2530031'
  						)
                    )
                );

$result = $client->__soapCall($function, $arguments);

print("<pre>".print_r($result,true)."</pre>");

?>
	
</body>
</html>