<?php

use \PDO;

require_once SHARED . 'classes/CLI_Command.php';

/**
 * import a mapping of ec numbers to KEGG pathways
 */
class EC2PathwayMapping implements \CLI_Command {

    public static function CLI_checkRequiredOpts(\Console_CommandLine_Result $command) {
        
    }

    public static function CLI_commandDescription() {
        return "Bring relationships between ECs and KEGG pathways into CHADO.";
    }

    public static function CLI_commandName() {
        return "addEC2PathwayMapping";
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
            $param_ec_number = null;

            //statement to add pathway as dbxref and cvterm
            $statement_insert_cvterm_relationship = $db->prepare(<<<EOF
WITH new_values (type_id, subject_id, object_id) AS (
SELECT :type_id::int, subject.cvterm_id, object.cvterm_id FROM 
	(SELECT cvterm_id 
		FROM cvterm 
		WHERE dbxref_id=
			(SELECT dbxref_id 
				FROM dbxref 
				WHERE accession=:kegg_id 
				AND db_id=
					(SELECT db_id FROM db WHERE name='KEGG' LIMIT 1) 
				LIMIT 1
			)
	) as subject, 
	(SELECT cvterm_id 
		FROM cvterm 
		WHERE dbxref_id=
			(SELECT dbxref_id 
				FROM dbxref 
				WHERE accession=:ec_number 
				AND db_id=
					(SELECT db_id FROM db WHERE name='EC' LIMIT 1) 
				LIMIT 1
			)
	) as object
)
INSERT INTO cvterm_relationship (type_id, subject_id, object_id)
SELECT type_id, subject_id, object_id FROM new_values
WHERE NOT EXISTS (SELECT 1 FROM cvterm_relationship AS cvr WHERE cvr.subject_id=new_values.subject_id AND cvr.object_id=new_values.object_id)
EOF
            );
            // type_id = 46 means 'contains' so read $kegg_id contains $ec_number
            $statement_insert_cvterm_relationship->bindValue('type_id', 46, PDO::PARAM_INT);
            $statement_insert_cvterm_relationship->bindParam('kegg_id', $param_kegg_id, PDO::PARAM_STR);
            $statement_insert_cvterm_relationship->bindParam('ec_number', $param_ec_number, PDO::PARAM_STR);

            foreach ($command->args['input_files'] as $infilename) {
                $file = fopen($infilename, 'r');
                while (($line = fgetcsv($file, 0, $separator)) !== false) {
                    if (count($line) == 0)
                        continue;
                    $param_ec_number = $line[0];
                    $param_kegg_id = $line[1];

                    $statement_insert_cvterm_relationship->execute();
                    $descriptions_added+=$statement_insert_cvterm_relationship->rowCount();
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
        printf("Relationships read:\t%s\n", $lines_imported);
        printf("New relationships:\t%s\n", $descriptions_added);
    }

    /**
     * @inheritDoc
     */
    public static function CLI_longHelp() {
        return <<<EOF
Add EC number to KEGG-pathway relationship.
        
Tab-Separated file with column 1: ec_number and column 2: kegg_id
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
