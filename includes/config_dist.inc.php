<?php
/***************************************************************
*
*  @package    alertmeapi
*  @author     Darren Clark <darren@clark.uk.com>
*  @copyright  Darren Clark
*  @version    $Id: config_dist.inc.php 2 2009-05-09 22:35:20Z darren $
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

/** 
 * Configuration Variables template
 *
 * Copy this file to config.inc.php and then edit the values
 */

$config['api']        = 'https://api.alertme.com/webapi/v2';
$config['username']   = '';
$config['password']   = '';
$config['clientName'] = 'AlertmeAPI PHP Client'; // Enter the client name that will show in the alertme logs

?>
