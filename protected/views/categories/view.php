<h2><?php echo $category->name; ?></h2>

<div class="row-fluid toolbar">
	<div class="span12 button-container">
		<?php echo CHtml::link('<span class="icon-pencil" ></span> Edit Category', array('categories/update', 'id' => $category->id), array('class' => 'btn')); ?>
		<?php echo CHtml::link('<span class="icon-tags" ></span> Back to categories', array('categories/'), array('class' => 'btn')); ?>
	</div>
</div>

<?php echo $this->renderPartial('application.views.transaction._table', array('transactions' => $transactions, 'account' => null, 'pager' => $pager, 'balance' => 0, 'showBalance' => false)); ?>
