
<h2>Categories</h2>

<?php if(Yii::app()->user->hasFlash('categories')): ?>
	<br />
	<div class="row-fluid">
		<div class="span12">
			<div class="alert alert-success">
				<h4>Congratulation!</h4>
				<br />
				<?php echo Yii::app()->user->getFlash('categories'); ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<div class="row-fluid toolbar">
	<div class="span6" style="height: 18px; padding-top: 6px; " >
		&nbsp;
	</div>
	<div class="span6 button-container">
		<?php echo CHtml::link('<span class="icon-plus" ></span> Add Category', array('/categories/create'), array('class' => 'btn')); ?>
		<?php echo CHtml::link('<span class="icon-th-large" ></span> Dashboard', array('/application/dashboard'), array('class' => 'btn')); ?>
	</div>
</div>

<div class="row-fluid">
    <div class="well span6">
        <?php

        $level=0;

        foreach($categories as $n => $category) {
            if($category->level == $level) {
                echo CHtml::closeTag('li')."\n";
            } else if($category->level > $level) {
                echo CHtml::openTag('ul', array('class' => 'nav nav-list'))."\n";
            } else {
                echo CHtml::closeTag('li')."\n";

                for($i = $level - $category->level; $i; $i--) {
                    echo CHtml::closeTag('ul')."\n";
                    echo CHtml::closeTag('li')."\n";
                }
            }

            echo CHtml::openTag('li');
            echo CHtml::link(CHtml::encode($category->name), array('categories/view', 'id' => $category->id));
            $level = $category->level;
        }

        for($i = $level; $i; $i--) {
            echo CHtml::closeTag('li')."\n";
            echo CHtml::closeTag('ul')."\n";
        }
    ?>
    </div>
</div>
