SELECT 
  parent_biomaterial.name AS parent_biomaterial_name, 
  feature_relationship.type_id, 
  parent_feature.name AS parent_feature_name, 
  feature.name AS feature_name, 
  biomaterial.name AS biomaterial_name, 
  quantificationresult.value, 
  quantificationresult.type_id
FROM 
  public.quantificationresult, 
  public.biomaterial, 
  public.biomaterial_relationship, 
  public.biomaterial parent_biomaterial, 
  public.feature, 
  public.feature parent_feature, 
  public.feature_relationship, 
  public.quantification
WHERE 
  biomaterial.biomaterial_id = biomaterial_relationship.subject_id AND
  biomaterial.biomaterial_id = quantificationresult.biomaterial_id AND
  biomaterial_relationship.object_id = parent_biomaterial.biomaterial_id AND
  feature.feature_id = quantificationresult.feature_id AND
  feature.feature_id = feature_relationship.subject_id AND
  feature_relationship.object_id = parent_feature.feature_id AND
  quantification.quantification_id = quantificationresult.quantification_id AND
  biomaterial_relationship.type_id = 32 AND 
  feature_relationship.type_id = 962 AND
  parent_feature.uniquename IN (%s)
 ORDER BY feature_name, biomaterial_name;
