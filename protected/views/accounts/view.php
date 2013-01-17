<h2><?php echo $account->name; ?></h2>

<div class="row-fluid toolbar">
	<div class="span6" style="height: 18px; padding-top: 6px; " >
		<strong>Account balance: <em><?php $this->widget('HtmlMoneyValue', array('value' => $account->actual_balance, 'account' => $account)); ?></em></strong>
	</div>
	<div class="span6 button-container">
		<?php echo CHtml::link('<span class="icon-pencil" ></span> Edit Account', array('accounts/update', 'id' => $account->id), array('class' => 'btn')); ?>
		<?php echo CHtml::link('<span class="icon-th-large" ></span> Dashboard', array('application/dashboard'), array('class' => 'btn')); ?>
	</div>
</div>

<?php echo $this->renderPartial('application.views.transaction._table', array('transactions' => $transactions, 'account' => $account, 'pager' => $pager, 'balance' => $account->actual_balance)); ?>
