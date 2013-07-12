<?php

namespace cli_db;

require_once ROOT . 'classes/AbstractTable.php';

class Feature extends AbstractTable {

    /**
     * @inheritDoc
     */
    public static function getKeys() {
        return array(
            'id' => array(
                'colname' => 'FeatureId',
                'actions' => array(
                    'details' => 'required',
                    'add_synonym' => 'required',
                    'remove_synonym' => 'required',
                ),
                'description' => 'feature id',
                'short_name' => '-f'
            ),
            'name' => array(
                'colname' => 'Name',
                'actions' => array(
                    'list' => 'required',
                ),
                'description' => 'search filter, may contain wildcards, e.g. "*comp21449*"'
            ),
            'synonym' => array(
                'actions' => array(
                    'add_synonym' => 'required',
                    'remove_synonym' => 'required',
                ),
                'description' => 'synonym to be created'
            ),
            'bibsonomy_internal_link' => array(
                'short_name' => '-b',
                'actions' => array(
                    'add_synonym' => 'required',
                ),
                'description' => 'bibsonomy "internal link", you can find this on the publication post page. looks like this: [[publication/<resource>/<username>]]'
            ),
            'bibsonomy_api_key' => array(
                'short_name' => '-k',
                'actions' => array(
                    'add_synonym' => 'required',
                ),
                'description' => 'you can find your api key at http://www.bibsonomy.org/settings?selTab=1'
            ),
            'bibsonomy_username' => array(
                'short_name' => '-u',
                'actions' => array(
                    'add_synonym' => 'required',
                ),
                'description' => 'bibsonomy user name'
            ),
            'type' => array(
                'actions' => array(
                    'add_synonym' => 'required',
                    'remove_synonym' => 'required',
                ),
                'description' => "'symbol' or 'fullname'. defaults to 'symbol'",
                'choices' => array('symbol', 'fullname'),
                'default' => 'symbol',
                'short_name' => '-t'
            ),
        );
    }

    /**
     * @inheritDoc
     */
    public static function CLI_commandDescription() {
        return 'Manipulate Features.';
    }

    /**
     * @inheritDoc
     */
    public static function CLI_commandName() {
        return 'feature';
    }

    /**
     * @inheritDoc
     */
    public static function CLI_longHelp() {
        
    }

    /**
     * @inheritDoc
     */
    public static function getSubCommands() {
        return array('details', 'list', 'add_synonym', 'remove_synonym');
    }

    /**
     * @inheritDoc
     */
    public static function getPropelClass() {
        return '\\cli_db\\propel\\Feature';
    }

    /**
     * @inheritdoc
     * overwritten to make use of required parameter name (see parameter help). lists only a subset, not the complete table
     */
    protected static function command_list($options, $keys) {

        $featureq = new propel\FeatureQuery();
        // filterByName allows for wildcards
        $featureq->filterByName($options['name']);

        $table_keys = array_keys(array_filter($keys, function($val) {
                            return isset($val['colname']);
                        }));
        $results = self::prepareQueryResult($featureq->find());
        self::printTable($table_keys, $results);
    }

    /**
     * adds synonym to this feature. requires bibsonomy link to be passed
     * @param type $options
     * @param type $keys
     */
    protected static function command_add_synonym($options, $keys) {
        $featureq = new propel\FeatureQuery();
        $feature = $featureq->findOneByFeatureId($options['id']);

        if ($feature == null)
            trigger_error(sprintf('No Feature found for id %d', $options['id']), E_USER_ERROR);

        $pub = Publication::getPropelPubFromBibsonomy($options['bibsonomy_internal_link'], $options['bibsonomy_username'], $options['bibsonomy_api_key']);

        $typeq = new propel\CvtermQuery();
        $type = $typeq->findOneByName($options['type']);

        $synonymq = new propel\SynonymQuery();
        $synonymq->filterByTypeId($type->getCvtermId());
        $synonymq->filterByName($options['synonym']);

        $synonym = $synonymq->findOne();
        if ($synonym == null) {
            $synonym = new propel\Synonym();
            $synonym->setName($options['synonym']);
            $synonym->setTypeId($type->getCvtermId());
            $synonym->setSynonymSgml('');
        }


        $feature_synonyms = $synonym->getFeatureSynonymsJoinFeature();
        foreach ($feature_synonyms as $feature_synonym) {
            if ($feature_synonym->getFeature()->getReleaseName() == $feature->getReleaseName()) {
                trigger_error('This release already contains a feature with this synonym.'
                        . ' You can\'t add the same synonym twice to an assembly release.', E_USER_ERROR);
            }
        }
        if ($options['type'] == 'symbol') {
            $feature_synonyms2 = propel\FeatureSynonymQuery::create()->findByFeatureId($options['id']);
            foreach ($feature_synonyms2 as $feature_synonym) {
                if ($feature_synonym->getSynonym()->getTypeId() == $type->getCvtermId()) {
                    trigger_error('This feature is already annotated a symbol.'
                            . 'While you can as many fullname synonyms as you wish, each feature can only have one symbol!', E_USER_ERROR);
                }
            }
        }

        $feature_synonym = new propel\FeatureSynonym();

        $feature_synonym->setFeatureId($options['id']);
        $feature_synonym->setSynonym($synonym);

        $feature_synonym->setPub($pub);

        $feature_synonym->save();
        print "Synonym created successfully.\n";
    }

    /**
     * removes synonym from this feature.
     * @param type $options
     * @param type $keys
     */
    protected static function command_remove_synonym($options, $keys) {
        $typeq = new propel\CvtermQuery();
        $type = $typeq->findOneByName($options['type']);

        $synonymq = new propel\SynonymQuery();
        $synonymq->filterByTypeId($type->getCvtermId());
        $synonymq->filterByName($options['synonym']);

        $synonym = $synonymq->findOne();
        if ($synonym == null) {
            trigger_error('Synonym not found.', E_USER_ERROR);
        }


        $feature_synonyms = $synonym->getFeatureSynonyms();
        foreach ($feature_synonyms as $feature_synonym) {
            if ($feature_synonym->getFeatureId() == $options['id']) {
                if (count($feature_synonyms == 1))
                    $synonym->delete();
                else
                    $feature_synonym->delete();
                print 'Deleted successfully.';
            }
        }

        trigger_error('Combination of synonym and feature not found!.', E_USER_ERROR);
    }

}

?>
