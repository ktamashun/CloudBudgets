
<div class="row-fluid">
	<div class="span12">
		<?php $form = $this->beginWidget('CActiveForm', array(
			'htmlOptions' => array('class' => 'form-horizontal', 'id' => 'DeleteConfirm')
		)); ?>
			<fieldset>
				<legend>What do you want to do with the transactions on '<?php echo $account->name ?>' account?</legend>

				<div class="control-group">
					<div class="controls">
						<label class="radio">
							<input type="radio" name="DeleteConfirm[deleteMethod]" id="deleteMethod1" value="1" />
							Delete every transaction on this account.
						</label>

						<label class="radio">
							<input type="radio" name="DeleteConfirm[deleteMethod]" id="deleteMethod2" value="2" checked="checked" />
							Move them to the following account:
						</label>
						<select name="DeleteConfirm[move_to_account_id]" >
							<?php foreach ($this->user->accounts as $userAccount): ?>
								<?php if ($account->id === $userAccount->id) continue; ?>
								<option value="<?php echo $userAccount->id; ?>"><?php echo $userAccount->name; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>

				<div class="form-actions">
					<?php echo CHtml::submitButton('Delete account', array('class' => 'btn btn-danger', 'onclick' => "return confirm('Are you sure you want to delete this account?'); ")); ?>
					&nbsp;
					<?php echo CHtml::link('Cancel', array('/accounts'), array('class' => 'btn')); ?>
				</div>
			</fieldset>
		<?php $this->endWidget(); ?>
	</div>
</div>
