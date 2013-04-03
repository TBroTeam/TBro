<?php


require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../constants.php';
require_once INC.'/libs/php-progress-bar.php';

class Importer_GO_OBO {

    static function import($filename) {

        $lines_total = trim(`wc -l $filename | cut -d' ' -f1`);
        
        global $db;
        $db->beginTransaction();
        $statement_insert_dbxrefprop = $db->prepare(
                'INSERT INTO dbxrefprop (dbxref_id, type_id, value) VALUES (get_or_insert_dbxref(:dbname, :accession, :description), :type, :value)'
        );
        
        $lines_imported = 0;

        $param_accession = null;
        $param_dbname = null;
        $param_namespace = null;
        $param_description=null;
        
        $statement_insert_dbxrefprop->bindParam('accession', $param_accession, PDO::PARAM_STR);
        $statement_insert_dbxrefprop->bindParam('dbname', $param_dbname, PDO::PARAM_STR);
        $statement_insert_dbxrefprop->bindValue('type', CV_GO_NAMESPACE, PDO::PARAM_STR);
        $statement_insert_dbxrefprop->bindParam('value', $param_namespace, PDO::PARAM_STR);
        $statement_insert_dbxrefprop->bindParam('description', $param_description, PDO::PARAM_STR);

        $file = fopen($filename, 'r');

        while (($line = fgets($file)) !== false) {
            $line = trim($line);
            $match = null;
            if (preg_match('{namespace: (?<namespace>.*)}', $line, $match))
                $param_namespace = $match['namespace'];
            if (preg_match('{id: (?<db>.*):(?<accession>.*)}', $line, $match)) {
                $param_accession = $match['accession'];
                $param_dbname = $match['db'];
            }
            
            if (preg_match('{name: (?<description>.*)}', $line, $match))
                $param_description = $match['description'];

            // we have reached a new term or the end of file. in both cases, current term is closed, saved to DB
            if ($line == '[Term]' || feof($file)) {
                if ($param_accession != null && $param_dbname != null && $param_namespace != null) {
                    //insert into DB
                    $statement_insert_dbxrefprop->execute();
                }

                $param_accession = null;
                $param_namespace = null;
                $param_dbname = null;
                $param_description=null;
            }
            $lines_imported++;
            if ($lines_imported%200==0) php_progress_bar_show_status($lines_imported, $lines_total, 60);
        }
        php_progress_bar_show_status($lines_imported, $lines_total, 60);
        $db->commit();
        return array(LINES_IMPORTED => $lines_imported);
    }

}

?>
