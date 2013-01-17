
<div class="row-fluid">
	<div class="span12">
		<?php $form = $this->beginWidget('CActiveForm', array(
			'htmlOptions' => array('class' => 'form-horizontal')
		)); ?>
			<fieldset>
				<legend><?php echo $legend; ?></legend>

				<?php if(Yii::app()->user->hasFlash('accounts')): ?>
					<div class="row-fluid">
						<div class="span6">
							<div class="alert alert-success">
								<a class="close" data-dismiss="alert">&times;</a>
								<h4>Congratulation!</h4>
								<br />
								<?php echo Yii::app()->user->getFlash('accounts'); ?>
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
					<?php echo $form->labelEx($model, 'account_type_id', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->dropDownList($model, 'account_type_id', AccountType::model()->findAllAsDropDownListSource(), array('class' => 'input-xlarge')); ?>
					</div>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($model, 'name', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->textField($model, 'name', array('class' => 'input-xlarge')); ?>
					</div>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($model, 'initial_balance', array('class' => 'control-label')); ?>
					<div class="controls">
						<div class="input-prepend input-append">
                                                    
							<?php echo $form->textField($model, 'initial_balance', array('class' => 'input-xlarge span1 currency-control')); ?><span class="add-on"><?php echo User::getLoggedInUser()->defaultCurrency->iso_code; ?></span>
						</div>
					</div>
				</div>

				<div class="form-actions">
					<?php echo CHtml::submitButton($submitValue, array('class' => 'btn btn-primary')); ?>
					&nbsp;
					<?php echo CHtml::link('Cancel', array('/accounts'), array('class' => 'btn')); ?>
				</div>
			</fieldset>
		<?php $this->endWidget(); ?>
	</div>
</div>
