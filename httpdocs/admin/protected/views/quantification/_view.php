<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('quantification_id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->quantification_id), array('view', 'id' => $data->quantification_id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('acquisition_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->acquisition)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('operator_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->operator)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('protocol_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->protocol)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('analysis_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->analysis)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('quantificationdate')); ?>:
	<?php echo GxHtml::encode($data->quantificationdate); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('name')); ?>:
	<?php echo GxHtml::encode($data->name); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('uri')); ?>:
	<?php echo GxHtml::encode($data->uri); ?>
	<br />
	*/ ?>

</div>