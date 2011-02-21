<?php
// $Id: parse_error_test.php 2 2009-05-09 22:35:20Z darren $
require_once('../unit_tester.php');
require_once('../reporter.php');

$test = &new TestSuite('This should fail');
$test->addFile('test_with_parse_error.php');
$test->run(new HtmlReporter());
?>