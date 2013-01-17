<?php

Yii::import('system.gii.generators.crud.CrudCode');

class UsoftCrudCode extends CrudCode
{

	public function generateActiveLabel($modelClass,$column)
	{
		return "\$form->labelEx(\$model,'{$column->name}', array('class' => 'control-label'))";
	}

	public function generateActiveField($modelClass,$column)
	{
		if($column->type === 'boolean') {
			return "\$form->checkBox(\$model, '{$column->name}')";
		} else if(stripos($column->dbType, 'text') !== false) {
			return "\$form->textArea(\$model, '{$column->name}', array('rows'=>6, 'cols'=>50))";
		} else {
			if(preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)) {
				$inputField = 'passwordField';
			} else {
				$inputField = 'textField';
            }

			if($column->type !== 'string' || $column->size === null) {
				return "\$form->{$inputField}(\$model, '{$column->name}', array('class' => 'input-xlarge'))";
			} else {
				if(($size = $maxLength = $column->size) > 60) {
					$size=60;
                }

				return "\$form->{$inputField}(\$model, '{$column->name}', array('size' => $size, 'maxlength' => $maxLength, 'class' => 'input-xlarge'))";
			}
		}
	}
}
