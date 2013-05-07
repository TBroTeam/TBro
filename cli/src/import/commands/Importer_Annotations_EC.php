<?php

require_once ROOT . 'classes/Importer_Annotations_Dbxref.php';

class Importer_Annotations_EC extends Importer_Annotations_Dbxref {

    public static function CLI_commandName() {
        return "annotation_ec";
    }

    public static function CLI_commandDescription() {
        return "import EC annotations";
    }

    public static function import($options) {
        return self::_import($options, 0, 1, "\t");
    }

    public static function CLI_longHelp() {
        return "Tab-Separated file with column 1: feature_id and column 2: EC Dbxref\n\n" . parent::CLI_longHelp();
    }

}

?>
