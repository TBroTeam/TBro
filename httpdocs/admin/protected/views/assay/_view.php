<div class="view">

    <?php echo GxHtml::encode($data->getAttributeLabel('assay_id')); ?>:
    <?php echo GxHtml::link(GxHtml::encode($data->assay_id), array('view', 'id' => $data->assay_id)); ?>
    <br />

    <?php echo GxHtml::encode($data->getAttributeLabel('name')); ?>:
    <?php echo GxHtml::encode($data->name); ?>
    <br />
    <?php echo GxHtml::encode($data->getAttributeLabel('description')); ?>:
    <?php echo GxHtml::encode($data->description); ?>
    <br />
    <?php echo GxHtml::encode($data->getAttributeLabel('protocol_id')); ?>:
    <?php echo GxHtml::encode(GxHtml::valueEx($data->protocol)); ?>
    <br />
    <?php echo GxHtml::encode($data->getAttributeLabel('assaydate')); ?>:
    <?php echo GxHtml::encode($data->assaydate); ?>
    <br />
    <?php echo GxHtml::encode($data->getAttributeLabel('operator_id')); ?>:
    <?php echo GxHtml::encode(GxHtml::valueEx($data->operator)); ?>
    <br />
    <?php echo GxHtml::encode($data->getAttributeLabel('dbxref_id')); ?>:
    <?php echo GxHtml::encode(GxHtml::valueEx($data->dbxref)); ?>
    <br />
    <?php /*
      <?php echo GxHtml::encode($data->getAttributeLabel('arraydesign_id'));
      ?>:
      <?php echo GxHtml::encode(GxHtml::valueEx($data->arraydesign)); ?>
      <br />

      <?php echo GxHtml::encode($data->getAttributeLabel('arrayidentifier')); ?>:
      <?php echo GxHtml::encode($data->arrayidentifier); ?>
      <br />
      <?php echo GxHtml::encode($data->getAttributeLabel('arraybatchidentifier')); ?>:
      <?php echo GxHtml::encode($data->arraybatchidentifier); ?>
      <br />
     */
    ?>

</div>