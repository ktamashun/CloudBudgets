<?php
$pluralizedName = strtolower($this->pluralize($this->class2name($this->modelClass)));
?>
<h2><?php echo ucfirst($pluralizedName); ?></h2>

<?php echo "<?php if(Yii::app()->user->hasFlash('" . $pluralizedName . "')): ?>"; ?>
	<br />
	<div class="row-fluid">
		<div class="span12">
			<div class="alert alert-success">
				<h4>Congratulation!</h4>
				<br />
				<?php echo "<?php echo Yii::app()->user->getFlash('" . $pluralizedName . "'); ?>"; ?>
			</div>
		</div>
	</div>
<?php echo "<?php endif; ?>"; ?>

<div class="row-fluid toolbar">
	<div class="span6" style="height: 18px; padding-top: 6px; " >
		&nbsp;
	</div>
	<div class="span6 button-container">
		<?php echo "<?php echo CHtml::link('<span class=\"icon-plus\" ></span> Add " . $this->modelClass . "', array('/" . $pluralizedName . "/create'), array('class' => 'btn')); ?>"; ?>
		<?php echo "<?php echo CHtml::link('<span class=\"icon-th-large\" ></span> Dashboard', array('/application/dashboard'), array('class' => 'btn')); ?>"; ?>
	</div>
</div>

<?php echo "<?php echo \$this->renderPartial('application.views." . $pluralizedName . "._table', array('" . $pluralizedName . "' => \$" . $pluralizedName . ")); ?>"; ?>
