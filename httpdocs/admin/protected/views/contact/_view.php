<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('contact_id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->contact_id), array('view', 'id' => $data->contact_id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('type_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->type)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('name')); ?>:
	<?php echo GxHtml::encode($data->name); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('description')); ?>:
	<?php echo GxHtml::encode($data->description); ?>
	<br />

</div>