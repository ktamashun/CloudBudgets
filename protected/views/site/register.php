
<style type="text/css" scoped="scoped" >
	span.required {
		color: red;
	}
</style>

<div class="row">
	<div class="span12">
		<?php $form = $this->beginWidget('CActiveForm', array(
			'htmlOptions' => array('class' => 'form-horizontal')
		)); ?>
			<fieldset>
				<legend>Please fill out the following form to register: </legend>

				<div class="alert alert-info" >
					Fields with <span class="required">*</span> are required.
				</div>

				<?php echo $form->errorSummary($user); ?>

				<div class="control-group">
					<?php echo $form->labelEx($user, 'name', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->textField($user, 'name', array('class' => 'input-xlarge')); ?>
					</div>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($user, 'username', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->textField($user, 'username', array('class' => 'input-xlarge')); ?>
					</div>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($user, 'email_address', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->textField($user, 'email_address', array('class' => 'input-xlarge')); ?>
					</div>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($user, 'password', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->passwordField($user, 'password', array('class' => 'input-xlarge')); ?>
					</div>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($user, 'password2', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->passwordField($user, 'password2', array('class' => 'input-xlarge')); ?>
					</div>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($user, 'default_currency_id', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->dropDownList($user, 'default_currency_id', Currency::model()->findAllAsDropDownListSource(), array('class' => 'input-xlarge')); ?>
					</div>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($user, 'country_id', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->dropDownList($user, 'country_id', Country::model()->findAllAsDropDownListSource(), array('class' => 'input-xlarge')); ?>
					</div>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($user, 'city', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->textField($user, 'city', array('class' => 'input-xlarge')); ?>
					</div>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($user, 'verifyCode', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->textField($user, 'verifyCode', array('class' => 'input-large span1')); ?>
						<br />
						<?php $this->widget('CCaptcha'); ?>
					</div>
				</div>

				<div class="form-actions">
					<?php echo CHtml::submitButton('Register', array('class' => 'btn btn-primary')); ?>
				</div>
			</fieldset>
		<?php $this->endWidget(); ?>
	</div>
</div>
