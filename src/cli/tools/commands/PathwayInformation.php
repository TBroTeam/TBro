<?php

use \PDO;

require_once SHARED . 'classes/CLI_Command.php';

/**
 * importer pathway information
 */
class PathwayInformation implements \CLI_Command {

    public static function CLI_checkRequiredOpts(\Console_CommandLine_Result $command) {
        
    }

    public static function CLI_commandDescription() {
        return "Bring (KEGG) pathway information into CHADO.";
    }

    public static function CLI_commandName() {
        return "addPathwayInformationToDB";
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
            $param_kegg_id = null;
            $param_name = null;
            $param_definition = null;

            //statement to add pathway as dbxref and cvterm
            $statement_insert_cvterm = $db->prepare(<<<EOF
WITH new_values (name, definition, cv_id, dbxref_id) as 
    (SELECT :name::varchar, :definition::varchar, :cv_id::int, get_or_insert_dbxref::int FROM  get_or_insert_dbxref('KEGG', :kegg_id)),
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
            $statement_insert_cvterm->bindParam('kegg_id', $param_kegg_id, PDO::PARAM_STR);
            $statement_insert_cvterm->bindParam('definition', $param_definition, PDO::PARAM_STR);

            foreach ($command->args['input_files'] as $infilename) {
                $file = fopen($infilename, 'r');
                while (($line = fgetcsv($file, 0, $separator)) !== false) {
                    if (count($line) == 0)
                        continue;
                    $param_definition = $line[1];
                    $param_kegg_id = $line[0];
                    $param_name = sprintf("KEGG:map%s", $param_kegg_id);

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
        printf("New pathways:\t\t%s\n", $descriptions_added);
    }

    /**
     * @inheritDoc
     */
    public static function CLI_longHelp() {
        return <<<EOF
Add (KEGG) pathway ids and corresponding descriptions.
        
Tab-Separated file with column 1: kegg_id and column 2: pathway_name
Example:
00010   Glycolysis / Gluconeogenesis
00020   Citrate cycle (TCA cycle)
00030   Pentose phosphate pathway
00040   Pentose and glucuronate interconversions
00051   Fructose and mannose metabolism
00052   Galactose metabolism
00053   Ascorbate and aldarate metabolism
00061   Fatty acid biosynthesis
00062   Fatty acid elongation in mitochondria
00071   Fatty acid metabolism

EOF;
    }

}

?>
