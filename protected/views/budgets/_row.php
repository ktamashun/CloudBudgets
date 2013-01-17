			<tr>
                        	            	
				<td><?php echo $budget->created_at; ?></td>
                        	            	
				<td><?php echo $budget->name; ?></td>
                        	
				<td><?php echo $budget->value; ?></td>
            
				<td style="text-align: right; " >
					<?php echo CHtml::link('<span class="icon-folder-open" ></span> Open', array('budgets/view', 'id' => $budget->id), array('class' => 'btn btn-action')); ?>
					<?php echo CHtml::link('<span class="icon-pencil" ></span> Edit', array('budgets/update', 'id' => $budget->id), array('class' => 'btn btn-action')); ?>
					<?php echo CHtml::link('<span class="icon-trash icon-white" ></span> Delete', array('budgets/delete', 'id' => $budget->id), array('class' => 'btn btn-action btn-danger')); ?>
				</td>
			</tr>