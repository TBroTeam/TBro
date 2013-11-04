<?php

use \PDO;

require_once SHARED . 'classes/CLI_Command.php';

/**
 * importer pathway information
 */
class ECInformation implements \CLI_Command {

    public static function CLI_checkRequiredOpts(\Console_CommandLine_Result $command) {
        
    }

    public static function CLI_commandDescription() {
        return "Bring EC information into CHADO.";
    }

    public static function CLI_commandName() {
        return "addECInformationToDB";
    }

    public static function CLI_getCommand(\Console_CommandLine $parser) {
        $command = $parser->addCommand(self::CLI_commandName(), array(
            'description' => self::CLI_commandDescription()
        ));

        $command->addArgument('input_files', array('multiple' => true));

        return $command;
    }

    public static function CLI_execute(\Console_CommandLine_Result $command, \Console_CommandLine $parser) {
        $separator = "\t";

        global $db;
        $lines_imported = 0;
        $descriptions_added = 0;
        try {
            $db->beginTransaction();
            #shared parameters
            $param_name = null;
            $param_ec_id = null;
            $param_definition = null;

            //statement to add pathway as dbxref and cvterm
            $statement_insert_cvterm = $db->prepare(<<<EOF
WITH new_values (name, definition, cv_id, dbxref_id) as 
    (SELECT :name::varchar, :definition::varchar, :cv_id::int, get_or_insert_dbxref::int FROM  get_or_insert_dbxref('EC', :ec_id)),
upsert as
(
    UPDATE cvterm c
        SET (name, definition) = (nv.name, nv.definition)
    FROM new_values nv
    WHERE c.dbxref_id = nv.dbxref_id
	AND c.cv_id = nv.cv_id
    RETURNING c.*
)
INSERT INTO cvterm (name, definition, cv_id, dbxref_id)
SELECT name, definition, cv_id, dbxref_id FROM new_values
WHERE NOT EXISTS (SELECT 1 FROM upsert up WHERE up.dbxref_id = new_values.dbxref_id)
EOF
            );
            // cv_id = 2 means 'local' if conflicting needs to be changed to speciel kegg-cv
            $statement_insert_cvterm->bindValue('cv_id', 2, PDO::PARAM_INT);
            $statement_insert_cvterm->bindParam('name', $param_name, PDO::PARAM_STR);
            $statement_insert_cvterm->bindParam('definition', $param_definition, PDO::PARAM_STR);
            $statement_insert_cvterm->bindParam('ec_id', $param_ec_id, PDO::PARAM_STR);

            foreach ($command->args['input_files'] as $infilename) {
                $file = fopen($infilename, 'r');
                while (($line = fgetcsv($file, 0, $separator)) !== false) {
                    if (count($line) == 0)
                        continue;
                    $param_definition = $line[1];
                    $param_ec_id = $line[0];
                    $param_name = sprintf("EC:%s", $param_ec_id);

                    $statement_insert_cvterm->execute();
                    $descriptions_added+=$statement_insert_cvterm->rowCount();
                    $lines_imported++;
                }
            }
            if (!$db->commit()) {
                $err = $db->errorInfo();
                throw new \ErrorException($err[2], ERRCODE_TRANSACTION_NOT_COMPLETED, 1);
            }
        } catch (\Exception $error) {
            $db->rollback();
            throw $error;
        }
        printf("Descriptions added/updated:\t%s\n", $lines_imported);
        printf("New EC numbers:\t\t%s\n", $descriptions_added);
    }

    /**
     * @inheritDoc
     */
    public static function CLI_longHelp() {
        return <<<EOF
Add EC ids and corresponding descriptions.
        
Tab-Separated file with column 1: EC_numer and column 2: description
Example:
1.1.1.1 Alcohol dehydrogenase.
1.1.1.2 Alcohol dehydrogenase (NADP(+)).
1.1.1.3 Homoserine dehydrogenase.
1.1.1.4 (R,R)-butanediol dehydrogenase.
1.1.1.5 Transferred entry: 1.1.1.303 and 1.1.1.304.
1.1.1.6 Glycerol dehydrogenase.
1.1.1.7 Propanediol-phosphate dehydrogenase.
1.1.1.8 Glycerol-3-phosphate dehydrogenase (NAD(+)).
1.1.1.9 D-xylulose reductase.
1.1.1.10    L-xylulose reductase.
...
EOF;
    }

}

?>
