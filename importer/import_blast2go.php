#!/usr/bin/php
<?php
define('IMPORTERS_DIR', __DIR__.'/../includes/importers');
require_once IMPORTERS_DIR.'/Importer_Annotations_Blast2Go.php';

$importer = new Importer_Annotations_Blast2Go();
$importer->fromShell();
?>
