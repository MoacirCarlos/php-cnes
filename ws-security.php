<?php

/**
* This function implements a WS-Security digest authentification for PHP.
*
* @access private
* @param string $user
* @param string $password
* @return SoapHeader
*/

function soapClientWSSecurityHeader($user, $password)
{
    // Creating date using yyyy-mm-ddThh:mm:ssZ format
    $tm_created = gmdate('Y-m-d\TH:i:s\Z');
    $tm_expires = gmdate('Y-m-d\TH:i:s\Z', gmdate('U') + 180); //only necessary if using the timestamp element

    // Generating and encoding a random number
    $simple_nonce = mt_rand();
    $encoded_nonce = base64_encode($simple_nonce);

    // Initializing namespaces
    $ns_wsse = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';
    $ns_wsu = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd';
    $password_type = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText';
    $encoding_type = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary';

    // Creating WSS identification header using SimpleXML
    $root = new SimpleXMLElement('<root/>');

    $security = $root->addChild('wsse:Security', null, $ns_wsse);

    //the timestamp element is not required by all servers
    $timestamp = $security->addChild('wsu:Timestamp', null, $ns_wsu);
    $timestamp->addAttribute('wsu:Id', 'Timestamp-28');
    $timestamp->addChild('wsu:Created', $tm_created, $ns_wsu);
    $timestamp->addChild('wsu:Expires', $tm_expires, $ns_wsu);

    $usernameToken = $security->addChild('wsse:UsernameToken', null, $ns_wsse);
    $usernameToken->addChild('wsse:Username', $user, $ns_wsse);
    $usernameToken->addChild('wsse:Password', $password, $ns_wsse)->addAttribute('Type', $password_type);
    $usernameToken->addChild('wsse:Nonce', $encoded_nonce, $ns_wsse)->addAttribute('EncodingType', $encoding_type);
    $usernameToken->addChild('wsu:Created', $tm_created, $ns_wsu);

    // Recovering XML value from that object
    $root->registerXPathNamespace('wsse', $ns_wsse);
    $full = $root->xpath('/root/wsse:Security');
    $auth = $full[0]->asXML();

    return new SoapHeader($ns_wsse, 'Security', new SoapVar($auth, XSD_ANYXML), true);
}