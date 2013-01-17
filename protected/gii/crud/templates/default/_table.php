<?php
$pluralizedName = strtolower($this->pluralize($this->class2name($this->modelClass)));
$modelClass = $this->modelClass;
$model = $modelClass::model();
?>
<?php echo "<?php if (count(\$" . $pluralizedName . ") === 0): ?>\n"; ?>
	<div class="alert alert-warning" >
		<h4 class="alert-heading" >No <?php echo $pluralizedName; ?> to display.</h4>

		<br />
		You don't have any <?php echo $pluralizedName; ?> yet. Why not create one <?php echo "<?php echo CHtml::link('now', array('" . $pluralizedName . "/create')); ?>"; ?>?
	</div>
<?php echo "<?php else: ?>\n"; ?>
	<table class="table table-striped ">
		<thead>
			<tr>
            <?php foreach($this->tableSchema->columns as $column): ?>
            	<?php
                    if($column->autoIncrement) {
                        continue;
                    }
                    if (in_array($column->name, array('user_id'))) {
                        continue;
                    }
                ?>

                <th><?php echo $model->getAttributeLabel($column->name); ?></th>
            <?php endforeach; ?>

                <th style="width: 200px; " >&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<?php echo "<?php foreach (\$" . $pluralizedName . " as \$" . strtolower($this->modelClass) . "): ?>\n"; ?>
				<?php echo "<?php \$this->renderPartial('application.views." . $pluralizedName . "._row', array('" . strtolower($this->modelClass) . "' => \$" . strtolower($this->modelClass) . ")); ?>\n"; ?>
			<?php echo "<?php endforeach; ?>\n"; ?>
		</tbody>
	</table>
<?php echo "<?php endif; ?>\n"; ?>
