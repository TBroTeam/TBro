<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'biomaterial' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.cli_db.map
 */
class BiomaterialTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.BiomaterialTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('biomaterial');
        $this->setPhpName('Biomaterial');
        $this->setClassname('cli_db\\propel\\Biomaterial');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('biomaterial_biomaterial_id_seq');
        // columns
        $this->addPrimaryKey('biomaterial_id', 'BiomaterialId', 'INTEGER', true, null, null);
        $this->addForeignKey('taxon_id', 'TaxonId', 'INTEGER', 'organism', 'organism_id', false, null, null);
        $this->addForeignKey('biosourceprovider_id', 'BiosourceproviderId', 'INTEGER', 'contact', 'contact_id', false, null, null);
        $this->addForeignKey('dbxref_id', 'DbxrefId', 'INTEGER', 'dbxref', 'dbxref_id', false, null, null);
        $this->addColumn('name', 'Name', 'LONGVARCHAR', false, null, null);
        $this->addColumn('description', 'Description', 'LONGVARCHAR', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Contact', 'cli_db\\propel\\Contact', RelationMap::MANY_TO_ONE, array('biosourceprovider_id' => 'contact_id', ), 'SET NULL', null);
        $this->addRelation('Dbxref', 'cli_db\\propel\\Dbxref', RelationMap::MANY_TO_ONE, array('dbxref_id' => 'dbxref_id', ), 'SET NULL', null);
        $this->addRelation('Organism', 'cli_db\\propel\\Organism', RelationMap::MANY_TO_ONE, array('taxon_id' => 'organism_id', ), 'SET NULL', null);
        $this->addRelation('AssayBiomaterial', 'cli_db\\propel\\AssayBiomaterial', RelationMap::ONE_TO_MANY, array('biomaterial_id' => 'biomaterial_id', ), 'CASCADE', null, 'AssayBiomaterials');
        $this->addRelation('BiomaterialDbxref', 'cli_db\\propel\\BiomaterialDbxref', RelationMap::ONE_TO_MANY, array('biomaterial_id' => 'biomaterial_id', ), 'CASCADE', null, 'BiomaterialDbxrefs');
        $this->addRelation('BiomaterialRelationshipRelatedByObjectId', 'cli_db\\propel\\BiomaterialRelationship', RelationMap::ONE_TO_MANY, array('biomaterial_id' => 'object_id', ), null, null, 'BiomaterialRelationshipsRelatedByObjectId');
        $this->addRelation('BiomaterialRelationshipRelatedBySubjectId', 'cli_db\\propel\\BiomaterialRelationship', RelationMap::ONE_TO_MANY, array('biomaterial_id' => 'subject_id', ), null, null, 'BiomaterialRelationshipsRelatedBySubjectId');
        $this->addRelation('BiomaterialTreatment', 'cli_db\\propel\\BiomaterialTreatment', RelationMap::ONE_TO_MANY, array('biomaterial_id' => 'biomaterial_id', ), 'CASCADE', null, 'BiomaterialTreatments');
        $this->addRelation('Biomaterialprop', 'cli_db\\propel\\Biomaterialprop', RelationMap::ONE_TO_MANY, array('biomaterial_id' => 'biomaterial_id', ), 'CASCADE', null, 'Biomaterialprops');
        $this->addRelation('Quantificationresult', 'cli_db\\propel\\Quantificationresult', RelationMap::ONE_TO_MANY, array('biomaterial_id' => 'biomaterial_id', ), null, 'CASCADE', 'Quantificationresults');
        $this->addRelation('Treatment', 'cli_db\\propel\\Treatment', RelationMap::ONE_TO_MANY, array('biomaterial_id' => 'biomaterial_id', ), 'CASCADE', null, 'Treatments');
    } // buildRelations()

} // BiomaterialTableMap
