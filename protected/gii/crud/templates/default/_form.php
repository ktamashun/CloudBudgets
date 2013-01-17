<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */

$pluralizedName = strtolower($this->pluralize($this->class2name($this->modelClass)));

?>
<div class="row-fluid">
	<div class="span12">
        <?php echo "<?php \$form = \$this->beginWidget('CActiveForm', array(
            'id' => '" . $this->class2id($this->modelClass) . "-form',
			'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
		)); ?>\n"; ?>
			<fieldset>
				<legend><?php echo "<?php echo \$legend; ?>"; ?></legend>

				<?php echo "<?php if(Yii::app()->user->hasFlash('" . $pluralizedName . "')): ?>\n"; ?>
					<div class="row-fluid">
						<div class="span6">
							<div class="alert alert-success">
								<a class="close" data-dismiss="alert">&times;</a>
								<h4>Congratulation!</h4>
								<br />
								<?php echo "<?php echo Yii::app()->user->getFlash('" . $pluralizedName . "'); ?>"; ?>
							</div>
						</div>
					</div>
				<?php echo "<?php endif; ?>\n"; ?>

				<div class="row-fluid">
					<div class="span6">
						<div class="alert alert-info" >
							Fields with <span class="required">*</span> are required.
						</div>
					</div>
				</div>

				<div class="row-fluid">
					<div class="span6">
						<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>
					</div>
				</div>

            <?php foreach($this->tableSchema->columns as $column): ?>
            	<?php
                    if($column->autoIncrement) {
                        continue;
                    }
                    if (in_array($column->name, array('created_at', 'user_id'))) {
                        continue;
                    }
                ?>

            	<div class="control-group">
                    <?php echo "<?php echo " . $this->generateActiveLabel($this->modelClass, $column) . "; ?>\n"; ?>
					<div class="controls">
                        <?php echo "<?php echo " . $this->generateActiveField($this->modelClass, $column) . "; ?>\n"; ?>
					</div>
				</div>
            <?php endforeach; ?>

				<div class="form-actions">
					<?php echo "<?php echo CHtml::submitButton(\$submitValue, array('class' => 'btn btn-primary')); ?>\n"; ?>
					&nbsp;
					<?php echo "<?php echo CHtml::link('Cancel', array('/" . $pluralizedName . "'), array('class' => 'btn')); ?>"; ?>
				</div>
			</fieldset>
		<?php echo "<?php \$this->endWidget(); ?>\n"; ?>
	</div>
</div>
