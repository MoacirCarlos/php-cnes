# php-cnes
Consumo dos serviços do CNES fornecidos pelo DATASUS-MS/DF

## ws-security.php
Arquivo responsável por adicionar os namespaces XSD oasis de segurança ao header da requisição SoapClient.

## estabelecimento.php
Consulta do método responsável por trazer as informações básicas da unidade de saúde.

Verifique as credenciais na "linha 23".

    <?php
        $client->__setSoapHeaders(soapClientWSSecurityHeader('CNES.PUBLICO', 'cnes#2015public'));
    ?>

Informe o código do estabelecimento na "linha 30".
    
    'codigo'      => '0010456'
    
## estabelecimento-profissionais.php
Consulta do método responsável por trazer a lista de profissionais vinculados a um determinado estabelecimento de saúde.

Verifique as credenciais na "linha 23".

    <?php
        $client->__setSoapHeaders(soapClientWSSecurityHeader('CNES.PUBLICO', 'cnes#2015public'));
    ?>

Informe o código do estabelecimento na "linha 30".
    
    'codigo'     => '2530031'
