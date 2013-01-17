<h2>Budgets</h2>

<?php if(Yii::app()->user->hasFlash('budgets')): ?>	<br />
	<div class="row-fluid">
		<div class="span12">
			<div class="alert alert-success">
				<h4>Congratulation!</h4>
				<br />
				<?php echo Yii::app()->user->getFlash('budgets'); ?>			</div>
		</div>
	</div>
<?php endif; ?>
<div class="row-fluid toolbar">
	<div class="span6" style="height: 18px; padding-top: 6px; " >
		&nbsp;
	</div>
	<div class="span6 button-container">
		<?php echo CHtml::link('<span class="icon-plus" ></span> Add Budget', array('/budgets/create'), array('class' => 'btn')); ?>		<?php echo CHtml::link('<span class="icon-th-large" ></span> Dashboard', array('/application/dashboard'), array('class' => 'btn')); ?>	</div>
</div>

<?php echo $this->renderPartial('application.views.budgets._table', array('budgets' => $budgets)); ?>