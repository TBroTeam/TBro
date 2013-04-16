<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('acquisition_id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->acquisition_id), array('view', 'id' => $data->acquisition_id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('assay_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->assay)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('protocol_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->protocol)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('channel_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->channel)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('acquisitiondate')); ?>:
	<?php echo GxHtml::encode($data->acquisitiondate); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('name')); ?>:
	<?php echo GxHtml::encode($data->name); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('uri')); ?>:
	<?php echo GxHtml::encode($data->uri); ?>
	<br />

</div>