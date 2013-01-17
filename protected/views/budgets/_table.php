<?php if (count($budgets) === 0): ?>
	<div class="alert alert-warning" >
		<h4 class="alert-heading" >No budgets to display.</h4>

		<br />
		You don't have any budgets yet. Why not create one <?php echo CHtml::link('now', array('budgets/create')); ?>?
	</div>
<?php else: ?>
	<table class="table table-striped ">
		<thead>
			<tr>
                        	            	
                <th>Created At</th>
                        	            	
                <th>Name</th>
                        	
                <th>Value</th>
            
                <th style="width: 200px; " >&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($budgets as $budget): ?>
				<?php $this->renderPartial('application.views.budgets._row', array('budget' => $budget)); ?>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>
