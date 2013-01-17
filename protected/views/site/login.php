
<style type="text/css" scoped="scoped" >
	span.required {
		color: red;
	}
</style>

<h1 style="margin-bottom: 30px; ">Login</h1>

<div class="row">
	<div class="span12">
		<?php $form = $this->beginWidget('CActiveForm', array(
			'htmlOptions' => array('class' => 'form-horizontal'),
		)); ?>
			<fieldset>
				<legend>Please fill out the following form with your login credentials:</legend>

				<?php echo $form->errorSummary($model); ?>

				<div class="controls-group" style="margin-bottom: 18px; ">
					<?php echo $form->labelEx($model, 'email_address', array('class' => 'control-label')); ?>

					<div class="controls">
						<?php echo $form->textField($model, 'email_address', array('class' => 'input-xlarge')); ?>
					</div>
				</div>

				<div class="controls-group">
					<?php echo $form->labelEx($model, 'password', array('class' => 'control-label')); ?>

					<div class="controls">
						<?php echo $form->passwordField($model, 'password', array('class' => 'input-xlarge')); ?>
					</div>
				</div>

				<div class="controls-group">
					<div class="controls">
						<label for="LoginForm_rememberMe" class="checkbox" >
							<?php echo $form->checkBox($model, 'rememberMe'); ?>
							Remember me next time
						</label>
					</div>
				</div>

				<div class="form-actions">
					<?php echo CHtml::submitButton('Login', array('class' => 'btn btn-primary')); ?>
				</div>
			</fieldset>
		<?php $this->endWidget(); ?>
	</div>
</div>







<?php /*

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php //echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php //echo $form->error($model,'password'); ?>
		<p class="hint">
			Hint: You may login with <tt>demo/demo</tt> or <tt>admin/admin</tt>.
		</p>
	</div>

	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php //echo $form->error($model,'rememberMe'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Login'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
*/
?>