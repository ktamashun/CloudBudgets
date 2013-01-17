
<!-- Main hero unit for a primary marketing message or call to action -->
<div class="hero-unit">
	<h1>Save more money!</h1>
	<p>Save more money by organizing and keeping track of your expenses.</p>
	<p>
		<a class="btn btn-primary btn-large" href="<?php echo $this->createUrl('site/register'); ?>" >Sign up for free &raquo;</a>
		<a class="btn btn-action btn-large" href="<?php echo $this->createUrl('site/login'); ?>" >Sign in &raquo;</a>
	</p>
</div>

<div class="row">
	<div class="span12">
		<div id="myCarousel" class="carousel">
			<!-- Carousel items -->
			<div class="carousel-inner">
				<div class="active item">
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/screen1.png" style="width: 100%; height: 400px; " alt="Picture" />
					<div class="carousel-caption">
						<h4>Get detailed reports of your expenses</h4>
						<p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
					</div>
				</div>
				<div class="item">
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/screen2.png" style="width: 100%; height: 400px; " alt="Picture" />
					<div class="carousel-caption">
						<h4>Get detailed reports of your expenses</h4>
						<p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
					</div>
				</div>
			</div>
			<!-- Carousel nav -->
			<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
			<a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
		</div>
	</div>
</div>

<!-- Example row of columns -->
<div class="row">
	<div class="span4">
		<h2>Heading</h2>
		<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
		<p><a class="btn" href="#">View details &raquo;</a></p>
	</div>
	<div class="span4">
		<h2>Heading</h2>
		<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
		<p><a class="btn" href="#">View details &raquo;</a></p>
	</div>
	<div class="span4">
		<h2>Heading</h2>
		<p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
		<p><a class="btn" href="#">View details &raquo;</a></p>
	</div>
</div>
