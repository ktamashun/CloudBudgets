<?php

/**
 * @var Budget $budget
 * @var CController $this
 */

?>

			<tr>
				<td><?php echo $budget->name; ?></td>
				<td><?php $this->widget('HtmlMoneyValue', array('value' => $budget->limit, 'forcedBalanceClass' => 'zero-balance')); ?></td>
                <td><?php $this->widget('HtmlMoneyValue', array('value' => $budget->getTransactionSumForMonth(), 'forcedBalanceClass' => 'zero-balance')); ?></td>
                <td><?php $this->widget('HtmlMoneyValue', array('value' => ($budget->getBalanceForMonth()))); ?></td>
                <?php /* <td>
                    <div id="budgetLimit_<?php echo $budget->id; ?>" ></div>
                    <script type="text/javascript" >
                        $(function() {
                            $("#budgetLimit_<?php echo $budget->id; ?>").progressbar({
                                value: <?php echo $budget->getBalancePercentForMonth() ?>
                            });
                        });
                    </script>
                </td> */ ?>

				<td style="text-align: right; " >
					<?php echo CHtml::link('<span class="icon-folder-open" ></span> Open', array('budgets/view', 'id' => $budget->id), array('class' => 'btn btn-action')); ?>
					<?php echo CHtml::link('<span class="icon-pencil" ></span> Edit', array('budgets/update', 'id' => $budget->id), array('class' => 'btn btn-action')); ?>
					<?php echo CHtml::link('<span class="icon-trash icon-white" ></span> Delete', array('budgets/delete', 'id' => $budget->id), array('class' => 'btn btn-action btn-danger')); ?>
				</td>
			</tr>