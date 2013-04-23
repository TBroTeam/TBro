#!/usr/bin/php
<?php
define('IMPORTERS_DIR', __DIR__.'/../includes/importers');
require_once IMPORTERS_DIR.'/Importer_Annotations_Interpro.php';

$importer = new Importer_Annotations_Interpro();
$importer->fromShell();
?>
