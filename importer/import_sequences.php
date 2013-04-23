#!/usr/bin/php
<?php
define('IMPORTERS_DIR', __DIR__.'/../includes/importers');
require_once IMPORTERS_DIR.'/Importer_Sequences.php';

$importer = new Importer_Sequences();
$importer->fromShell();
?>
