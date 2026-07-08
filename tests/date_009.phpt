--TEST--
DateTime default constructor does not pass null to parent
--SKIPIF--
<?php if (!extension_loaded('timecop')) print 'skip'; ?>
--FILE--
<?php
$dt = new DateTime();
echo $dt instanceof DateTime ? "ok\n" : "fail\n";
?>
--EXPECT--
ok
