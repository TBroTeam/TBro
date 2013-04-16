<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('biomaterial_id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->biomaterial_id), array('view', 'id' => $data->biomaterial_id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('taxon_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->taxon)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('biosourceprovider_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->biosourceprovider)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('dbxref_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->dbxref)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('name')); ?>:
	<?php echo GxHtml::encode($data->name); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('description')); ?>:
	<?php echo GxHtml::encode($data->description); ?>
	<br />

</div>