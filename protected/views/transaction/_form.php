
<div class="row-fluid">
	<div class="span12">
		<?php $form = $this->beginWidget('CActiveForm', array(
			'htmlOptions' => array('class' => 'form-horizontal')
		)); ?>
			<fieldset>
				<legend><?php echo $legend; ?></legend>

				<?php if(Yii::app()->user->hasFlash('transaction')): ?>
					<div class="row-fluid">
						<div class="span6">
							<div class="alert alert-success">
								<a class="close" data-dismiss="alert">&times;</a>
								<h4>Congratulation!</h4>
								<br />
								<?php echo Yii::app()->user->getFlash('transaction'); ?>
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
					<?php echo $form->labelEx($model, 'date', array('class' => 'control-label')); ?>
					<div class="controls">
						<div class="input-prepend input-append">
							<?php $this->widget('DatePicker', array(
								'form' => $form,
								'model' => $model,
								'attribute' => 'date',
							)); ?>
						</div>
					</div>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($model, 'description', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->textField($model, 'description', array('class' => 'input-xlarge')); ?>
					</div>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($model, 'transaction_type_id', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->dropDownList($model, 'transaction_type_id', TransactionType::model()->findAllAsDropDownListSource(), array('class' => 'input-xlarge')); ?>
					</div>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($model, 'account_id', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->dropDownList($model, 'account_id', $this->user->getAccountsAsDropDownListSource(), array('class' => 'input-xlarge')); ?>
					</div>
				</div>

				<div class="control-group" id="to_account_control" style="display: none; " >
					<?php echo $form->labelEx($model, 'to_account_id', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->dropDownList($model, 'to_account_id', $this->user->getAccountsAsDropDownListSource(), array('class' => 'input-xlarge')); ?>
					</div>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($model, 'category_id', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php $this->widget('UserCategoriesSelect', array(
							'form' => $form,
							'user' => $this->user,
							'model' => $model,
							'model_name' => 'Transaction',
							'attribute' => 'category_id',
						)); ?>
					</div>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($model, 'amount', array('class' => 'control-label')); ?>
					<div class="controls">
						<div class="input-prepend input-append">
							<?php echo $form->textField($model, 'amount', array('class' => 'input-xlarge span1 currency-control')); ?><span class="add-on"><?php echo $this->user->defaultCurrency->iso_code; ?></span>
						</div>
					</div>
				</div>

				<div class="form-actions">
					<?php echo CHtml::submitButton($submitValue, array('class' => 'btn btn-primary')); ?>
					&nbsp;
					<?php echo CHtml::link('Cancel', array('application/dashboard'), array('class' => 'btn')); ?>
				</div>

				<script type="text/javascript" >

					function transactionTypeChange()
					{
						if ($('#Transaction_transaction_type_id').val() == <?php echo Transaction::TYPE_TRANSFER; ?>) {
							$('#to_account_control').show();
							$('#to_account_control select').attr('name', 'Transaction[to_account_id]');
						} else {
							$('#to_account_control').hide();
							$('#to_account_control select').attr('name', 'Transaction[to_account_id_hidden]');
						}
					}

					$('#Transaction_transaction_type_id').change(transactionTypeChange);

					transactionTypeChange();

				</script>
			</fieldset>
		<?php $this->endWidget(); ?>
