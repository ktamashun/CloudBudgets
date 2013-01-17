			<tr>
				<td><?php echo $account->created_at; ?></td>
				<td><?php echo $account->name; ?></td>
				<td><?php echo $account->accountType->name; ?></td>
				<td style="text-align: right; " ><?php $this->widget('HtmlMoneyValue', array('account' => $account, 'value' => $account->initial_balance)); ?></td>
				<td style="text-align: right; " ><?php $this->widget('HtmlMoneyValue', array('account' => $account, 'value' => $account->actual_balance)); ?></td>
				<td style="text-align: right; " >
					<?php echo CHtml::link('<span class="icon-folder-open" ></span> Open', array('accounts/view', 'id' => $account->id), array('class' => 'btn btn-action')); ?>
					<?php echo CHtml::link('<span class="icon-pencil" ></span> Edit', array('accounts/update', 'id' => $account->id), array('class' => 'btn btn-action')); ?>
					<?php echo CHtml::link('<span class="icon-trash icon-white" ></span> Delete', array('accounts/delete', 'id' => $account->id), array('class' => 'btn btn-action btn-danger')); ?>
				</td>
			</tr>