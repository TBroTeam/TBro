<?php

namespace cli_db\propel;

use cli_db\propel\om\BaseBiomaterial;


/**
 * Skeleton subclass for representing a row from the 'biomaterial' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.cli_db
 */
class Biomaterial extends BaseBiomaterial
{
    function getType(){
        $props = $this->getBiomaterialprops(BiomaterialpropQuery::create()->filterByTypeId(CV_BIOMATERIAL_TYPE));
            if (isset($props[0])) return $props[0]->getValue();
        return "unknown";
    }
        
    function setType($value){
        $props = $this->getBiomaterialprops(BiomaterialpropQuery::create()->filterByTypeId(CV_BIOMATERIAL_TYPE));
        if (count($props)>0)
            $prop = $props[0];
        else {
            $prop = new Biomaterialprop();
            $prop->setTypeId(CV_BIOMATERIAL_TYPE);
            $this->addBiomaterialprop($prop);
        }
        $prop->setValue($value);
    }
    
    function getParent(){
        $parent_relationship = $this->getBiomaterialRelationshipsRelatedBySubjectId();
        
        if (isset($parent_relationship[0]))
            return BiomaterialQuery::create()->findOneByBiomaterialId($parent_relationship[0]->getObjectId())->getName();
    }

    function setParent(Biomaterial $parent_biomaterial){
        $parent_q = new BiomaterialRelationshipQuery();
        $parent_q->filterBySubjectId($this->getBiomaterialId());
        $parent_q->filterByTypeId(CV_BIOMATERIAL_ISA);
        $parent_rel = $parent_q->findOneOrCreate();
        
        $parent_rel->setObjectId($parent_biomaterial->getBiomaterialId());
        $this->addBiomaterialRelationshipRelatedBySubjectId($parent_rel);
    }
}
