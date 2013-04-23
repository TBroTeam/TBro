#!/usr/bin/php
<?php
define('IMPORTERS_DIR', __DIR__.'/../includes/importers');
require_once IMPORTERS_DIR.'/Importer_Expressions.php';

$importer = new Importer_Expressions();
$importer->fromShell();
?>
