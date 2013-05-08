<?php

namespace cli_db;

require_once SHARED . '/classes/CLI_Command.php';

class Publication extends AbstractTable {

    public static function getKeys() {
        return array(
            'id' => array(
                'colname' => 'PubId',
                'actions' => array(
                    'details' => 'required',
                    'delete' => 'required',
                ),
                'description' => 'publication id'
            ),
            'title' => array('colname' => 'Title'),
            'volumetitle' => array('colname' => 'Volumetitle'),
            'miniref' => array('colname' => 'Miniref'),
            'bibsonomy_internal_link' => array(
                'short_name' => '-b',
                'actions' => array(
                    'link_bibsonomy' => 'required',
                ),
                'description' => 'bibsonomy "internal link", you can find this on the publication post page. looks like this: [[publication/<resource>/<username>]]'
            ),
            'api_key' => array(
                'short_name' => '-k',
                'actions' => array(
                    'link_bibsonomy' => 'required',
                ),
                'description' => 'only necessary to access private posts, in combination with --username. you can find your api key at http://www.bibsonomy.org/settings?selTab=1'
            ),
            'username' => array(
                'short_name' => '-u',
                'actions' => array(
                    'link_bibsonomy' => 'required',
                ),
                'description' => 'only necessary to access private posts, in combination with --api_key.'
            ),
            'feature_id' => array(
                'short_name' => '-f',
                'actions' => array(
                    'link_bibsonomy' => 'required',
                ),
                'description' => 'feature id.'
            ),
            'unlink_feature_id' => array(
                'short_name' => '-f',
                'actions' => array(
                    'delete' => 'optional',
                ),
                'description' => 'feature id. if you specify this option, the publication will only be unlinked from the given feature. if the given feature was the last feature, the publication will be deleted nonetheless.'
            )
        );
    }

    public static function CLI_commandDescription() {
        return 'Add or remove publications.';
    }

    public static function CLI_commandName() {
        return 'publication';
    }

    public static function CLI_longHelp() {
        
    }

    public static function getSubCommands() {
        return array('link_bibsonomy', 'delete', 'details', 'list');
    }

    public static function getPropelClass() {
        return '\\cli_db\\propel\\Pub';
    }

    public static function command_link_bibsonomy($options, $keys) {
        $matches = null;
        if (!preg_match('{^\[\[(?<type>.*)/(?<resource>.*)/(?<user>.*)\]\]$}', $options['bibsonomy_internal_link'], $matches)) {
            trigger_error('wrong format for option --bibsonomy_internal_link', E_USER_ERROR);
        }

        $url = sprintf('http://www.bibsonomy.org/api/posts?resource=%s&resourcetype=bibtex', $matches['resource']);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERPWD, sprintf('%s:%s', $options['username'], $options['api_key']));
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        $xmlStr = curl_exec($curl);
        curl_close($curl);


        //<editor-fold defaultstate="collapsed" desc="bibtexType xsd, see http://www.bibsonomy.org/help/doc/xmlschema.html">
        /**
         * lines marked with * get stored to DB
          <xsd:complexType name="BibtexType">
         * <xsd:attribute name="title" type="xsd:string" use="required"/>
          <xsd:attribute name="bibtexKey" type="xsd:string" use="required"/>
          <xsd:attribute name="bKey" type="xsd:string"/>
          <xsd:attribute name="misc" type="xsd:string"/>
          <xsd:attribute name="bibtexAbstract" type="xsd:string"/>
         * <xsd:attribute name="entrytype" type="xsd:string" use="required"/>
          <xsd:attribute name="address" type="xsd:string"/>
          <xsd:attribute name="annote" type="xsd:string"/>
         * <xsd:attribute name="author" type="xsd:string"/>
          <xsd:attribute name="booktitle" type="xsd:string"/>
          <xsd:attribute name="chapter" type="xsd:string"/>
          <xsd:attribute name="crossref" type="xsd:string"/>
          <xsd:attribute name="edition" type="xsd:string"/>
          <xsd:attribute name="editor" type="xsd:string"/>
          <xsd:attribute name="howpublished" type="xsd:string"/>
          <xsd:attribute name="institution" type="xsd:string"/>
          <xsd:attribute name="organization" type="xsd:string"/>
         * <xsd:attribute name="journal" type="xsd:string"/>
          <xsd:attribute name="note" type="xsd:string"/>
         * <xsd:attribute name="number" type="xsd:string"/>
         * <xsd:attribute name="pages" type="xsd:string"/>
         * <xsd:attribute name="publisher" type="xsd:string"/>
          <xsd:attribute name="school" type="xsd:string"/>
         * <xsd:attribute name="series" type="xsd:string"/>
         * <xsd:attribute name="volume" type="xsd:string"/>
          <xsd:attribute name="day" type="xsd:string"/>
          <xsd:attribute name="month" type="xsd:string"/>
         * <xsd:attribute name="year" type="xsd:string" use="required"/>
          <xsd:attribute name="type" type="xsd:string"/>
          <!-- <xsd:attribute name="scraperId" type="xsd:positiveInteger"/>  -->
          <xsd:attribute name="url" type="xsd:string"/>
          <xsd:attribute name="privnote" type="xsd:string"/>

          <!-- hash value identifying this resource -->
          <xsd:attribute name="intrahash" type="xsd:string"/>
          <xsd:attribute name="interhash" type="xsd:string"/>
          <!-- link to all posts of this bibtex -->
          <xsd:attribute name="href" type="xsd:anyURI"/>
          </xsd:complexType>
         */
        //</editor-fold>

        $bibsonomy = new \SimpleXMLElement($xmlStr);
        if ($bibsonomy['stat'] == 'fail') {
            trigger_error($bibsonomy->error, E_USER_ERROR);
        }


        if (count($bibsonomy->posts->post) != 1) {
            trigger_error(sprintf('Bibsonomy post %s not found!', $options['bibsonomy_internal_link']), E_USER_ERROR);
        }
        $bibtex = $bibsonomy->posts->post->bibtex;

        $uniquename = sprintf('bibsonomy_%s', $matches['resource']);

        $pubq = new propel\PubQuery();
        $pub = $pubq->findOneByUniquename($uniquename);
        if ($pub == null) {
            $pub = new propel\Pub();
            $pub->setTitle($bibtex['title']);
            $pub->setUniquename($uniquename);
            $pub->setVolumeTitle($bibtex['journal']);
            $pub->setVolume($bibtex['volume']);
            $pub->setSeriesName($bibtex['series']);
            $pub->setIssue($bibtex['number']);
            $pub->setPyear($bibtex['year']);
            $pub->setPages($bibtex['pages']);
            $pub->setMiniref(sprintf('http://www.bibsonomy.org/bibtex/%s/%s', $bibtex['intrahash'], $matches['user']));
            $pub->setPublisher($bibtex['publisher']);
            $typequery = new propel\CvtermQuery();
            $type = $typequery->findOneByName($bibtex['entrytype']);
            if ($type != null) {
                $pub->setTypeId($type->getPrimaryKey());
            } else {
                trigger_error(sprintf('type %s not found in cvterm, proceeding without type', $bibtex['entrytype']), E_USER_WARNING);
            }

            $authors = explode(' and ', $bibtex['author']);
            $i = 0;
            foreach ($authors as $author) {
                list ($surname, $givennames) = explode(',', $author, 2);

                $pubauthor = new propel\Pubauthor();
                $pubauthor->setGivennames($givennames);
                $pubauthor->setSurname($surname);
                $pubauthor->setRank($i++);

                $pub->addPubauthor($pubauthor);
            }
        }

        $fq = new propel\FeatureQuery();
        $feature = $fq->findOneByFeatureId($options['feature_id']);

        $feature_pub = new propel\FeaturePub();
        $feature_pub->setFeature($feature);

        $pub->addFeaturePub($feature_pub);

        $pub->save();

        printf("successfully added Pub '%s' to Feature '%s'\n", $pub->getTitle(), $feature->getUniquename());
    }

    protected static function command_delete($options, $keys) {
        $pubq = new propel\PubQuery();
        $pub = $pubq->findOneByPubId($options['id']);
        if ($pub == null) {
            trigger_error(sprintf("No Publication found for ID %d. Exiting.\n", $options['id']), E_USER_ERROR);
        }
        $featurepubs = $pub->getFeaturePubs();
        if (isset($options['unlink_feature_id']) && count($featurepubs) > 1) {
            foreach ($featurepubs as $featurepub) {
                if ($featurepub->getFeatureId() == $options['unlink_feature_id'])
                    break;
            }
            if ($featurepub->getFeatureId() != $options['unlink_feature_id']) {
                trigger_error(printf("No Link from Publication %d to Feature %d found. Exiting.\n", $options['id'], $options['unlink_feature_id']), E_USER_ERROR);
            }
            if (!self::command_delete_confirm($options, sprintf("Delete Link from Publication %d  to Feature %d.\n", $options['id'], $options['unlink_feature_id']))) {
                return;
            }
            $featurepub->delete();
            printf("Row successfully deleted.\n");
            return;
        }
        if (!self::command_delete_confirm($options, sprintf("This Publication is linked to %d Features.\n", count($featurepubs)))) {
            return;
        }
        $pub->delete();
        printf("Row successfully deleted.\n");
    }

}

?>
