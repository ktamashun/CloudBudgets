
<div class="row-fluid">
	<div class="span12">
		<?php $form = $this->beginWidget('CActiveForm', array(
			'htmlOptions' => array('class' => 'form-horizontal')
		)); ?>
			<fieldset>
				<legend><?php echo $legend; ?></legend>

				<?php if(Yii::app()->user->hasFlash('categories')): ?>
					<div class="row-fluid">
						<div class="span6">
							<div class="alert alert-success">
								<a class="close" data-dismiss="alert">&times;</a>
								<h4>Congratulation!</h4>
								<br />
								<?php echo Yii::app()->user->getFlash('categories'); ?>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<div class="row-fluid">
					<div class="span6">
						<div class="alert alert-info" >
							Fields with <span class="required">*</span> are required.
						</div>
					</div>
				</div>

				<div class="row-fluid">
					<div class="span6">
						<?php echo $form->errorSummary($model); ?>
					</div>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($model, 'name', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->textField($model, 'name', array('class' => 'input-xlarge')); ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="Category_parentCategory_id">Make subcategory of</label>
					<div class="controls">
						<?php

                        $parent = (null === $model->id ? $this->user->getRootCategory() : $model->ancestors(1)->find());

                        $this->widget('UserCategoriesSelect', array(
							'form' => $form,
							'user' => $this->user,
							'model' => $parent,
							'model_name' => 'ParentCategory',
							'attribute' => 'id',
                            'type' => 'select'
						));

                        ?>
					</div>
				</div>

				<div class="form-actions">
					<?php echo CHtml::submitButton($submitValue, array('class' => 'btn btn-primary')); ?>
					&nbsp;
					<?php echo CHtml::link('Cancel', array('/categories'), array('class' => 'btn')); ?>
				</div>
			</fieldset>
		<?php $this->endWidget(); ?>
	</div>
</div>
