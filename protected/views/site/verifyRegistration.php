<?php if ($success): ?>

	<div class="alert alert-success alert-block" >
		<h4 class="alert-header">Congratulation!</h4>
	</div>

	<p>
		You have successfully activated your registration. Now you may <?php echo CHtml::link('login', array('site/login')); ?>.
	</p>

<?php else: ?>

	<div class="alert alert-error alert-block" >
		<h4 class="alert-header">Wrong activation code!</h4>
	</div>

	<p>
		The activation code could not be found.
	</p>

<?php endif; ?>