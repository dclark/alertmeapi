/***************************************************************
 * Alertme API PHP Library
 * @author     Darren Clark <darren@clark.uk.com>
 * @copyright  Darren Clark
 * @version    $Id$
 * @compat     PHP5+
 *             Ensure curl support is enabled
 *             Tested With PHP 5.2 Linux
 *                         PHP 5.2 Windows 
 * 
 * Usage
 * 
 * 1. In includes copy config_dist.inc.php to config.inc.php
 * 2. Update the config.inc.php with your own values
 * 3. Create a new php file such as:
 *
 * <?php
 * require_once("includes/config.inc.php");
 * require_once("includes/AlertmeAPI.inc.php");
 * 
 * $alertme = new AlertmeAPI($config);
 * $alertme->api('getUserInfo');
 * $alertme->logout();
 *
 * 4. Run via the command line
 * php yourfile.php
 *
 * 5. API Tests
 * Full testing of the api can be run by changing directory to
 * includes/tests
 *
 * php all_tests.php
 * 
/***************************************************************
