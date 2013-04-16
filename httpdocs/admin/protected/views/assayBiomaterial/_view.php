<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('assay_biomaterial_id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->assay_biomaterial_id), array('view', 'id' => $data->assay_biomaterial_id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('assay_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->assay)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('biomaterial_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->biomaterial)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('channel_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->channel)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('rank')); ?>:
	<?php echo GxHtml::encode($data->rank); ?>
	<br />

</div>