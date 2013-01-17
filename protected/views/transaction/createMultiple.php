
<div class="row-fluid">
	<div class="span12">
		<?php $form = $this->beginWidget('CActiveForm', array(
			'htmlOptions' => array('class' => 'form-horizontal')
		)); ?>
			<fieldset>
				<legend>Create multiple transactions</legend>

				<?php if(Yii::app()->user->hasFlash('accounts')): ?>
					<div class="row-fluid">
						<div class="span6">
							<div class="alert alert-success">
								<h4>Congratulation!</h4>
								<br />
								<?php echo Yii::app()->user->getFlash('accounts'); ?>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<div class="row-fluid">
					<div class="span6">
						<?php if (null !== $firstInValid): ?>
							<?php echo $form->errorSummary($firstInValid); ?>
						<?php endif; ?>
					</div>
				</div>

				<table class="table" >
					<thead>
						<tr>
							<th style="width: 120px; " >Date</th>
							<th>Description</th>
							<th style="width: 100px; " >Amount</th>
							<th style="width: 200px; " >Account</th>
							<th style="width: 130px; " >Type</th>
							<th style="width: 130px; " >Category</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($transactions as $i => $transaction): ?>
							<tr>
								<td>
									<div class="input-prepend input-append">
										<?php echo CHtml::activeTextField($transaction,"[$i]date", array('class' => 'datepicker')); ?><span class="add-on btn" onclick="$('#Transaction_<?php echo $i; ?>_date').trigger('focus'); "><span class="icon-calendar"></span></span>
									</div>
								</td>
								<td>
									<?php echo CHtml::activeTextField($transaction,"[$i]description", array('style' => 'width: 100%; ')); ?>
								</td>
								<td style="width: 110px; " >
									<div class="input-prepend input-append">
										<?php echo CHtml::activeTextField($transaction,"[$i]amount", array('class' => 'input-xlarge span1 currency-control')); ?><span class="add-on"><?php echo $this->user->defaultCurrency->iso_code; ?></span>
									</div>
								</td>
								<td>
									<?php echo CHtml::dropDownList("Transaction[$i][account_id]", $transaction->account_id, $this->user->getAccountsAsDropDownListSource(), array('class' => 'input-xlarge', 'style' => 'width: 200px; ')); ?>
								</td>
								<td>
									<?php echo CHtml::dropDownList("Transaction[$i][transaction_type_id]", $transaction->transaction_type_id, TransactionType::model()->findAllAsDropDownListSource(), array('class' => 'input-xlarge', 'style' => 'width: 130px; ')); ?>
								</td>
								<td>
									<?php $value = null === $transaction->category ? '' : $transaction->category->name; ?>
									<input data-provide="typeahead" data-items="4" data-source='["<?php echo implode('","', $this->user->getCategoriessAsDropDownListSource()); ?>"]' name="<?php echo "Transaction[{$i}][category_id]"; ?>" id="<?php echo "Transaction_{$i}_category_id"; ?>" type="text" autocomplete="off" value="<?php echo $value; ?>" style="width: 130px; " />
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

				<div class="form-actions" style="padding-left: 10px; ">
					<?php echo CHtml::submitButton('Create transactions', array('class' => 'btn btn-primary')); ?>
					&nbsp;
					<?php echo CHtml::link('Cancel', array('/application'), array('class' => 'btn')); ?>
				</div>
			</fieldset>
		<?php $this->endWidget(); ?>
	</div>
</div>
