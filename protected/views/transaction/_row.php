			<tr>
				<td><?php echo $transaction->date; ?></td>
				<td><?php echo $transaction->description; ?></td>
				<td style="text-align: right; " ><?php $this->widget('HtmlMoneyValue', array('transaction' => $transaction, 'account' => $account)); ?></td>
                <?php if ($showBalance): ?>
    				<td style="text-align: right; " ><?php $this->widget('HtmlMoneyValue', array('value' => $balance)); ?></td>
                <?php endif; ?>
				<?php /*td style="text-align: right; " ><?php $this->widget('HtmlMoneyValue', array('value' => $transaction->getBalance($this->user, $account))); ?></td*/ ?>
				<td>
					<?php if ($transaction->isTransfer()): ?>
						<?php if (null === $transaction->to_account_id): ?>
							<?php echo $transaction->getConnectedTransaction()->account->name; ?> <span class="icon-arrow-right" ></span> <?php echo $transaction->account->name; ?>
						<?php else: ?>
							<?php echo $transaction->account->name; ?> <span class="icon-arrow-right" ></span> <?php echo $transaction->getConnectedTransaction()->account->name; ?>
						<?php endif; ?>
					<?php else: ?>
						<?php echo $transaction->account->name; ?>
					<?php endif; ?>
				</td>
				<td><?php echo $transaction->category->name; ?></td>
				<td style="text-align: right; " >
					<?php echo CHtml::link('<span class="icon-pencil" ></span> Edit', array('transaction/update', 'id' => $transaction->id), array('class' => 'btn btn-action')); ?>
					<?php echo CHtml::link('<span class="icon-trash icon-white" ></span> Delete', array('transaction/delete', 'id' => $transaction->id), array('class' => 'btn btn-action btn-danger', 'onclick' => "return confirm('Are you sure you want to delete this transaction?'); ")); ?>
				</td>
			</tr>