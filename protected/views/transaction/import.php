
<div class="row-fluid">
	<div class="span12">
		<?php $form = $this->beginWidget('CActiveForm', array(
			'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'method' => 'post')
		)); ?>
			<fieldset>
				<legend>Import transactions</legend>

				<?php if(Yii::app()->user->hasFlash('transaction_error')): ?>
					<div class="row-fluid">
						<div class="span6">
							<div class="alert alert-error">
								<a class="close" data-dismiss="alert">&times;</a>
								<h4>Something went wrong!</h4>
								<br />
								<?php echo Yii::app()->user->getFlash('transaction_error'); ?>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<div class="alert alert-block">
					<h4 class="alert-heading">Important Information!</h4>

					<br />

					<p>
						The CSV file needs to contain the following cols:
						<ul>
							<li>Date</li>
							<li>Description</li>
							<li>Type</li>
							<li>Amount</li>
							<li>Account</li>
							<li>Category</li>
						</ul>
					</p>
				</div>

				<div class="row-fluid">
					<div class="span6">
						<?php //echo $form->errorSummary($model); ?>
					</div>
				</div>

				<div class="control-group">
					<?php echo CHtml::label('Upload CSV file', 'importFile', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo CHtml::fileField('importFile', '', array('id' => 'importFile', 'class' => 'input-file')); ?>
						<p class="help-block">NOTE: You can only import CSV files.</p>
					</div>
				</div>

				<div class="form-actions">
					<?php echo CHtml::submitButton('Upload file', array('class' => 'btn btn-primary')); ?>
					&nbsp;
					<?php echo CHtml::link('Cancel', array('/application/dashboard'), array('class' => 'btn')); ?>
				</div>
			</fieldset>
		<?php $this->endWidget(); ?>
	</div>
</div>
