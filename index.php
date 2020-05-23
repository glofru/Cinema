<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
require_once 'Utility/autoload.inc.php';
require_once 'StartSmarty.php';

if (Installator::checkInstall())
{
    print "<b>TODO</b>";
}
else
{
    Installator::start();
}