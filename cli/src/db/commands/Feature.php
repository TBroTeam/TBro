<?php

namespace cli_db;

require_once ROOT . 'classes/AbstractTable.php';

class Feature extends AbstractTable {

    public static function getKeys() {
        return array(
            'id' => array(
                'colname' => 'FeatureId',
                'actions' => array(
                    'details' => 'required',
                    'add_alias' => 'required',
                    'remove_alias' => 'required',
                ),
                'description' => 'feature id'
            ),
            'name' => array(
                'colname' => 'Name',
                'description' => 'name'
            ),
            'uniquename' => array(
                'colname' => 'Uniquename',
                'actions' => array(
                    'list' => 'required',
                ),
                'description' => 'search filter, may contain wildcards, e.g. "*comp21449*"'
            ),
            'alias' => array(
                'actions' => array(
                    'add_alias' => 'required',
                    'remove_alias' => 'required',
                ),
                'description' => 'feature id'
            ),
        );
    }

    public static function CLI_commandDescription() {
        return 'Manipulate Features.';
    }

    public static function CLI_commandName() {
        return 'feature';
    }

    public static function CLI_longHelp() {
        
    }

    public static function getSubCommands() {
        return array('details', 'list', 'add_alias', 'remove_alias');
    }

    public static function getPropelClass() {
        return '\\cli_db\\propel\\Feature';
    }

    protected static function command_list($options, $keys) {
        $featureq = new propel\FeatureQuery();
        $featureq->filterByUniquename($options['uniquename']);

        $table_keys = array_keys(array_filter($keys, function($val) {
                            return isset($val['colname']);
                        }));
        $results = self::prepareQueryResult($featureq->find());
        self::printTable($table_keys, $results);
    }

    protected static function command_add_alias($options, $keys, $type='symbol') {
        $alias_name = $options['alias'];
        $feature_id = $options['feature_id'];
        
        $typeq = new propel\CvtermQuery();
        $type=$typeq->findByName($type);
        
        $synonymq = new propel\SynonymQuery();
        $synonymq->filterByTypeId($type->getCvtermId());
        $synonymq->filterByName($alias_name);
        
        
        $synonym = new propel\Synonym();
        $synonym->setName($alias_name);
        
        
        
        $feature_synonym = new propel\FeatureSynonym();
        $feature_synonym->setFeatureId($feature_id);
        $feature_synonym->setSynonym($synonym);
        
        $feature_synonym->save();
    }

    protected static function command_remove_alias($options, $keys) {
        die('TODO'); //TODO
    }

}

?>
