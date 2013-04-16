<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('biomaterial_relationship_id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->biomaterial_relationship_id), array('view', 'id' => $data->biomaterial_relationship_id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('subject_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->subject)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('type_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->type)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('object_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->object)); ?>
	<br />

</div>