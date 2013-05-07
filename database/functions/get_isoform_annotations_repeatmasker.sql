CREATE FUNCTION
    get_isoform_annotations_repeatmasker(_isoform_ids integer[])
RETURNS
    TABLE (isoform_id int, uniquename text, fmin integer, fmax integer, strand smallint, repeat_name text, repeat_family text, repeat_class text)
AS $$
BEGIN
        RETURN QUERY
        SELECT
            featureloc.srcfeature_id AS isoform_id, repeatmasker.uniquename, featureloc.fmin, featureloc.fmax, featureloc.strand, repeat_name.value AS repeat_name, repeat_family.value AS repeat_family, repeat_class.value AS repeat_class
        FROM
            feature AS repeatmasker
            INNER JOIN featureloc ON (repeatmasker.feature_id = featureloc.feature_id)
            LEFT OUTER JOIN featureprop AS repeat_name ON (repeat_name.feature_id = repeatmasker.feature_id AND repeat_name.type_id = {PHPCONST('CV_REPEAT_NAME')})
            LEFT OUTER JOIN featureprop AS repeat_family ON (repeat_family.feature_id = repeatmasker.feature_id AND repeat_family.type_id = {PHPCONST('CV_REPEAT_FAMILY')})
            LEFT OUTER JOIN featureprop AS repeat_class ON (repeat_class.feature_id = repeatmasker.feature_id AND repeat_class.type_id = {PHPCONST('CV_REPEAT_CLASS')})
        WHERE
            featureloc.srcfeature_id = any(_isoform_ids) AND
            repeatmasker.type_id = {PHPCONST('CV_ANNOTATION_REPEATMASKER')};
END;
$$ LANGUAGE 'plpgsql';