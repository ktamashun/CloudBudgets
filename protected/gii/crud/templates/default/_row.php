<?php

$pluralizedName = strtolower($this->pluralize($this->class2name($this->modelClass)));
$modelVar = strtolower($this->modelClass);

?>
			<tr>
            <?php foreach($this->tableSchema->columns as $column): ?>
            	<?php
                    if($column->autoIncrement) {
                        continue;
                    }
                    if (in_array($column->name, array('user_id'))) {
                        continue;
                    }

                    $columnName = $column->name;
                ?>

				<td><?php echo "<?php echo \$" . $modelVar . "->" . $columnName . "; ?>"; ?></td>
            <?php endforeach; ?>

				<td style="text-align: right; " >
					<?php echo "<?php echo CHtml::link('<span class=\"icon-folder-open\" ></span> Open', array('" . $pluralizedName . "/view', 'id' => \$" . $modelVar . "->id), array('class' => 'btn btn-action')); ?>\n"; ?>
					<?php echo "<?php echo CHtml::link('<span class=\"icon-pencil\" ></span> Edit', array('" . $pluralizedName . "/update', 'id' => \$" . $modelVar . "->id), array('class' => 'btn btn-action')); ?>\n"; ?>
					<?php echo "<?php echo CHtml::link('<span class=\"icon-trash icon-white\" ></span> Delete', array('" . $pluralizedName . "/delete', 'id' => \$" . $modelVar . "->id), array('class' => 'btn btn-action btn-danger')); ?>\n"; ?>
				</td>
			</tr>