<?php
/***************************************************************
*
*  @package    alertmeapi
*  @author     Darren Clark <darren@clark.uk.com>
*  @copyright  Darren Clark
*  @compat     PHP5+
*  @version    $Id: AlertmeAPI.inc.php 3 2009-05-09 22:42:21Z darren $
*
*  This script is part of the alertmeapi project. The project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*  A copy is found in the textfile GPL.txt and important notices to the license
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
***************************************************************/

require_once("xmlrpc/xmlrpc.inc.php");

Class AlertmeAPI {

    var $api;
    var $username;
    var $password;
    var $clientName;
    var $client;
    var $debug = 0; // Set debug to 0 for less messages
    var $err = 0;
    var $errMsg;
    var $response;
    var $sessionToken;

    function __construct($args=array()) {
	foreach($args as $arg => $value) {
	    $this->$arg = $value;
	}
	$this->_login();
    }

    /*
     * Call API
     * @param string $name  API Call
     * @param array  $arguments  API Arguments
     */
    function api($name,$arguments=array()) {
	
	switch ($name) {
	    
	default:
	    
	    // The default api call is to call the method passing the sessionToken
	    // any additional arguments will be passed to service
	    
	    $_args = array($this->sessionToken);
	    foreach($arguments as $arg) {
		$_args[] = $arg;
	    }
	    $_payload = $this->_createPayload($name,$_args);
	    $this->_sendPayload($_payload);
	}
    }
    
    /**
     * Logout
     */
    function logout() {
	$_payload = $this->_createPayload('logout',array($this->sessionToken));
	$this->_sendPayload($_payload);
    }
    
    /**
     * Login
     */
    function _login() {
	$_payload = $this->_createPayload('login',array($this->username,
							$this->password,
							$this->clientName
							)
					  );
	if ($this->debug) {
	    print "Created Payload ". $_payload->serialize();
	}
	
	$this->_sendPayload($_payload);
	
	if (!$this->err) {
	    $this->sessionToken = $this->response;
	}
    }
    
    /*
     * Create Payload
     *
     * @param string $name Name of payload
     * @param array $args Api method arguments
     */ 
    function _createPayload($name,$args=array()) {
	
	$this->err = 0;
	$this->errMsg = '';
	$this->response = '';

	$this->client = new xmlrpc_client($this->api);
	$this->client->setDebug($this->debug);
	$_payLoad = array();
	foreach($args as $arg => $value) {
	    $_payLoad[] = new xmlrpcval($value, 'string');
	}
	
        return new xmlrpcmsg($name,$_payLoad);
    }

    /**
     * Send Payload
     * @param string xmlrpcmsg
     */
    function _sendPayload($payload) {
	if ($this->debug) {
	    print "Sending Payload ". $payload->serialize(). " Awaiting response from server:";
	}
	$response= &$this->client->send($payload);
	
	if (!$response->faultCode()) {
	    $_response = $response->serialize();
	    if (preg_match("/<string>(.*?)<\/string>/",$_response,$_responseMatches)) {
		$this->response = $_responseMatches[1];
	    }
	}
	else {
	    $this->err = 1;
	    $this->errMsg = "An error occurred sending the payload";
	    $this->errMsg .= "Code: ".$response->faultCode();
	    $this->errMsg .= "Reason: ".$response->faultString();
	    $this->response = $response->serialize();
	}
    }	    
}
