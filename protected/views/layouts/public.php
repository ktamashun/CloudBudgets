<?php $this->beginContent('//layouts/main'); ?>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<?php echo CHtml::link('Learn to save up!', array('site/index'), array('class' => 'brand')); ?>
				<div class="nav-collapse">
					<ul class="nav">
						<li class="active" ><?php echo CHtml::link('Home', array('site/index')); ?></li>
						<li><?php echo CHtml::link('About', array('site/page', 'view' => 'about')); ?></li>
						<li><?php echo CHtml::link('Learn more', array('site/learnMore')); ?></li>
						<li><?php echo CHtml::link('Sign in', array('site/login')); ?></li>
						<li><?php echo CHtml::link('Sign up', array('site/register')); ?></li>
						<li><?php echo CHtml::link('Contact', array('site/contact')); ?></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>

	<div class="container">

		<?php echo $content; ?>

		<hr />

		<footer>
		<p>&copy; Learntosaveup.com 2012</p>
		</footer>

	</div> <!-- /container -->

<?php $this->endContent(); ?>