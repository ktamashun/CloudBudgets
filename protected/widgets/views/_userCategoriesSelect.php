<?php $value = null === $this->model->id ? '' : $this->model->id; ?>

<select id="<?php echo $this->model_name . '_' . $this->attribute; ?>" class="input-xlarge" name="<?php echo $this->model_name . '[' . $this->attribute . ']'; ?>" >
    <option value="<?php echo $this->user->getRootCategory()->id; ?>" >None</option>
	<?php foreach ($this->user->categories as $category): ?>
		<option value="<?php echo $category->id; ?>" style="padding-left: <?php echo (($category->level - 2) * 20) ?>px; " <?php echo ($this->model->id == $category->id ? 'selected = "selected" ' : ''); ?>><?php echo $category->name; ?></option>
	<?php endforeach; ?>
</select>
