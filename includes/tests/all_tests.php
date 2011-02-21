<?php
/***************************************************************
*
*  @package    alertmeapi
*  @author     Darren Clark <darren@clark.uk.com>
*  @copyright  Darren Clark
*  @version    $Id: all_tests.php 2 2009-05-09 22:35:20Z darren $
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

/* Testing Framework for API */

$dir = dirname(__FILE__).'/../';
set_include_path($dir);

require_once('simpletest/autorun.php');
require_once("AlertmeAPI.inc.php");

Class TestOfAlertmeAPI extends UnitTestCase {

    var $alertme;
    var $alertmeDevices;
   

    function setUp() {
	require('config.inc.php');

	$this->alertme = new AlertmeAPI($config);
    }

    function testAll() {
	$this->_getUserInfo();
	$this->_getAllHubs();
	$this->_getHubStatus();
	$this->_getAllBehaviours();
	$this->_getEventLog();
	$this->_getAllServiceStates();
	$this->_getCurrentServiceState();
	$this->_sendCommand();
	$this->_getAllDevices();
	$this->_getDeviceDetails();
	$this->_getAllDeviceChannels();
	$this->_getDeviceChannelLog();
	$this->_getDeviceChannelValue();
    }
	
    function _getUserInfo() {
	$this->alertme->api('getUserInfo');
	$_response = $this->alertme->response;
	$this->assertPattern('/firstname\|(.*?)\,lastname\|(.*?),username\|(.*)$/',$_response);
    }

    function _getAllHubs() {
	$this->alertme->api('getAllHubs');
	$_response = $this->alertme->response;
	$this->assertPattern('/(.*?)\|(.*?)$/',$_response);
    }
    
    // Skipped _setHub method
    function _setHub() {
    }

    function _getHubStatus() {
	$this->alertme->api('getHubStatus');
	$_response = $this->alertme->response;
	$this->assertNoPattern('/faultString/',$_response);
    }
    
    function _getAllBehaviours() {
	$this->alertme->api('getAllBehaviours');
	$_response = $this->alertme->response;
	$this->assertNoPattern('/faultString/',$_response);
    }

    function _getEventLog() {
	$this->alertme->api('getEventLog',array('null','50',strtotime('now - 1 day'),strtotime('now + 1 day'), 'true'));
	$_response = $this->alertme->response;
	$this->assertNoPattern('/faultString/',$_response);
    }

    function _getAllServiceStates() {
	$this->alertme->api('getAllServiceStates',array('IntruderAlarm'));
	$_response = $this->alertme->response;
	$this->assertNoPattern('/faultString/',$_response);

	$this->alertme->api('getAllServiceStates',array('EmergencyAlarm'));
	$_response = $this->alertme->response;
	$this->assertNoPattern('/faultString/',$_response);

	$this->alertme->api('getAllServiceStates',array('Doorbell'));
	$_response = $this->alertme->response;
	$this->assertNoPattern('/faultString/',$_response);
    }
    
    function _getCurrentServiceState() {
	$this->alertme->api('getCurrentServiceState');
	$_response = $this->alertme->response;
	$this->assertNoPattern('/faultString/',$_response);
    }

    function _sendCommand() {
	$this->alertme->api('sendCommand',array('IntruderAlarm','disarm'));
	$_response = $this->alertme->response;
	$this->assertIdentical('ok',$_response);
    }

    function _getAllDevices() {
	$this->alertme->api('getAllDevices');
	$_response = $this->alertme->response;
	$_devices = explode(',',$_response);
	foreach($_devices as $_device) {

	    list($_deviceName,$_deviceId,$_deviceType) = split('[|]',$_device);

	    $this->alertmeDevices[] = array('name' => $_deviceName,
					    'id'   => $_deviceId,
                                            'type' => $_deviceType
					    );
	}

	$this->assertNotEqual(0,count($this->alertmeDevices));
    }

    function _getDeviceDetails() {
	$_deviceId = $this->alertmeDevices[0]['id'];
	$this->alertme->api('getDeviceDetails',array($_deviceId));
	$_response = $this->alertme->response;
	$this->assertPattern('/Software Version/',$_response);
    }

    function _getAllDeviceChannels() {
	$_deviceId = $this->alertmeDevices[0]['id'];
	$this->alertme->api('getAllDeviceChannels',array($_deviceId));
	$_response = $this->alertme->response;
	$this->assertNoPattern('/faultString/',$_response);
    }

    function _getDeviceChannelLog() {
	$_deviceId = $this->alertmeDevices[0]['id'];
	$this->alertme->api('getDeviceChannelLog',array($_deviceId,'LQI','100',strtotime('now - 1 days'),strtotime("now")));
	$_response = $this->alertme->response;
	$this->assertNoPattern('/faultString/',$_response);
    }

    function _getDeviceChannelValue() {
	$_deviceId = $this->alertmeDevices[0]['id'];
	$this->alertme->api('getDeviceChannelValue',array($_deviceId));
	$_response = $this->alertme->response;
      	$this->assertPattern('/BatteryLevel/',$_response);
    }
}