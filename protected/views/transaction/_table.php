<?php if (!isset($account)) { $account = null; } ?>
<?php if (!isset($showBalance)) { $showBalance = true; } ?>

<?php if (count($transactions) === 0): ?>
	<div class="alert alert-warning" >
		<h4 class="alert-heading" >There are no trancactions to display.</h4>

		<br />
		We don't have any transactions here. Why not create some <?php echo (null === $account ? CHtml::link('now', array('transaction/create')) : CHtml::link('now', array('transaction/create', 'account_id' => $account->id))); ?>?
	</div>
<?php else: ?>
	<?php echo $pager->render(); ?>
	<table class="table table-striped table-condensed ">
		<thead>
			<tr>
				<th style="width: 100px; " >Date</th>
				<th>Description</th>
				<th style="width: 120px; " >Amount</th>
                <?php if ($showBalance): ?>
    				<th style="width: 110px; " >Balance</th>
                <?php endif; ?>
				<?php /*th style="width: 110px; " >Balance 2</th*/ ?>
				<th>Account</th>
				<th>Category</th>
				<th style="width: 130px; " >&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<?php for ($i = 0; $i < 1; $i++): ?>
				<?php $balance = $transactions[0]->getBalance($this->user, $account); ?>
				<?php foreach ($transactions as $transaction): ?>
					<?php $this->renderPartial('application.views.transaction._row', array('transaction' => $transaction, 'account' => $account, 'balance' => $balance, 'showBalance' => $showBalance)); ?>
					<?php $balance -= ($transaction->isTransfer() && $account === null) ? 0 : $transaction->amount; ?>
				<?php endforeach; ?>
			<?php endfor; ?>
		</tbody>
	</table>
	<?php echo $pager->render(); ?>
<?php endif; ?>
