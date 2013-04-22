<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('protocol_id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->protocol_id), array('view', 'id' => $data->protocol_id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('type_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->type)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('pub_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->pub)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('dbxref_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->dbxref)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('name')); ?>:
	<?php echo GxHtml::encode($data->name); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('uri')); ?>:
	<?php echo GxHtml::encode($data->uri); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('protocoldescription')); ?>:
	<?php echo GxHtml::encode($data->protocoldescription); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('hardwaredescription')); ?>:
	<?php echo GxHtml::encode($data->hardwaredescription); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('softwaredescription')); ?>:
	<?php echo GxHtml::encode($data->softwaredescription); ?>
	<br />
	*/ ?>

</div>