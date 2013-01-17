
<?php if (count($accounts) === 0): ?>
	<div class="alert alert-warning" >
		<h4 class="alert-heading" >No accounts to display.</h4>

		<br />
		You don't have any accounts yet. Why not create one <?php echo CHtml::link('now', array('accounts/create')); ?>?
	</div>
<?php else: ?>
	<table class="table table-striped ">
		<thead>
			<tr>
				<th>Created at</th>
				<th>Name</th>
				<th>Type</th>
				<th style="text-align: center; " >Initial balance</th>
				<th style="text-align: center; " >Actual balance</th>
				<th style="width: 200px; " >&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($accounts as $account): ?>
				<?php $this->renderPartial('application.views.accounts._row', array('account' => $account)); ?>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>
