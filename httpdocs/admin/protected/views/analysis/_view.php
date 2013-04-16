<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('analysis_id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->analysis_id), array('view', 'id' => $data->analysis_id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('name')); ?>:
	<?php echo GxHtml::encode($data->name); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('description')); ?>:
	<?php echo GxHtml::encode($data->description); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('program')); ?>:
	<?php echo GxHtml::encode($data->program); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('programversion')); ?>:
	<?php echo GxHtml::encode($data->programversion); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('algorithm')); ?>:
	<?php echo GxHtml::encode($data->algorithm); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('sourcename')); ?>:
	<?php echo GxHtml::encode($data->sourcename); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('sourceversion')); ?>:
	<?php echo GxHtml::encode($data->sourceversion); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('sourceuri')); ?>:
	<?php echo GxHtml::encode($data->sourceuri); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('timeexecuted')); ?>:
	<?php echo GxHtml::encode($data->timeexecuted); ?>
	<br />
	*/ ?>

</div>