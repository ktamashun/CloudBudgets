<div class="row-fluid">
	<div class="span12">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'budget-form',
			'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
		)); ?>
			<fieldset>
				<legend><?php echo $legend; ?></legend>

				<?php if(Yii::app()->user->hasFlash('budgets')): ?>
					<div class="row-fluid">
						<div class="span6">
							<div class="alert alert-success">
								<a class="close" data-dismiss="alert">&times;</a>
								<h4>Congratulation!</h4>
								<br />
								<?php echo Yii::app()->user->getFlash('budgets'); ?>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<div class="row-fluid">
					<div class="span6">
						<div class="alert alert-info" >
							Fields with <span class="required">*</span> are required.
						</div>
					</div>
				</div>

				<div class="row-fluid">
					<div class="span6">
						<?php echo $form->errorSummary($model); ?>
					</div>
				</div>

				
				<div class="control-group">
					<?php echo $form->labelEx($model, 'category_id', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php $this->widget('UserCategoriesSelect', array(
							'form' => $form,
							'user' => $this->user,
							'model' => $model,
							'model_name' => 'Budget',
							'attribute' => 'category_id',
						)); ?>
					</div>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($model, 'limit', array('class' => 'control-label')); ?>
					<div class="controls">
						<div class="input-prepend input-append">
							<?php echo $form->textField($model, 'limit', array('class' => 'input-xlarge span1 currency-control')); ?><span class="add-on"><?php echo $this->user->defaultCurrency->iso_code; ?></span>
						</div>
					</div>
				</div>

				<div class="form-actions">
					<?php echo CHtml::submitButton($submitValue, array('class' => 'btn btn-primary')); ?>
					&nbsp;
					<?php echo CHtml::link('Cancel', array('/budgets'), array('class' => 'btn')); ?>
				</div>
			</fieldset>
		<?php $this->endWidget(); ?>
	</div>
</div>
