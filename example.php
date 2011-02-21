<?php
/***************************************************************
*
*  @package    alertmeapi
*  @author     Darren Clark <darren@clark.uk.com>
*  @copyright  Darren Clark
*  @version    $Id: example.php 2 2009-05-09 22:35:20Z darren $
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

require_once("includes/config.inc.php");
require_once("includes/AlertmeAPI.inc.php");

$alertme = new AlertmeAPI($config);

$alertme->api('getUserInfo');

print $alertme->response."\n";

$alertme->api('getAllHubs');
		  
print $alertme->response."\n";
			  
$alertme->api('getHubStatus');

print $alertme->response."\n";

$alertme->api('getAllBehaviours');

print $alertme->response."\n";
			  
$alertme->api('getBehaviour')."\n";

print $alertme->response."\n";

$alertme->api('getEventLog',array('null','50',strtotime('now - 1 day'),strtotime('now + 1 day'), 'true'));;

print $alertme->response."\n";
                         
$alertme->api('getAllServices');

print $alertme->response."\n";

$alertme->api('getAllServiceStates',array('History'));

print $alertme->response."\n";
                         
$alertme->api('getAllServiceStates',array('IntruderAlarm'));

print $alertme->response."\n";

$alertme->api('getCurrentServiceState');
			  
print $alertme->response."\n";

$alertme->api('sendCommand',array('IntruderAlarm','disarm'));

print $alertme->response."\n";

$alertme->api('getAllDevices');

print $alertme->response."\n";
			  
$alertme->logout();
				  
?>
