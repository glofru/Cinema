<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
require_once 'Utility/autoload.inc.php';
require_once 'StartSmarty.php';

StartSmarty::configuration();
if (Installator::checkInstall())
{
    $cmain = new CMain();
    $cmain->run("");
}
else
{
    Installator::install();
}
print "<b>Ciao</b>";