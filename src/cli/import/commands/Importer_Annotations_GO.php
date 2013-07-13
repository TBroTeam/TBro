<?php

namespace cli_import;

require_once ROOT . 'classes/Importer_Annotations_Dbxref.php';

/**
 * importer for GO crossreferences
 */
class Importer_Annotations_GO extends Importer_Annotations_Dbxref {

    /**
     * @inheritDoc
     */
    public static function CLI_commandName() {
        return "annotation_go";
    }

    /**
     * @inheritDoc
     */
    public static function CLI_commandDescription() {
        return "import GO annotations";
    }

    /**
     * @inheritDoc
     */
    public static function import($options) {
        return self::_import($options, 0, 1, "\t");
    }

    /**
     * @inheritDoc
     */
    public static function CLI_longHelp() {
        return "Tab-Separated file with column 1: feature_id and column 2: GO Dbxref\n\n" . parent::CLI_longHelp();
    }

}

?>
