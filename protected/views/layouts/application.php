<?php $this->beginContent('//layouts/main'); ?>



	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<?php echo CHtml::link('Learn to save up!', array('/application'), array('class' => 'brand')); ?>
				<div class="nav-collapse">
					<ul class="nav">
						<li<?php if ('home' === $this->selectedMenu) { echo ' class="active" ';} ?>><?php echo CHtml::link('<span class="icon-th-large icon-white"></span> Dashboard', array('/application')); ?></li>
						<li<?php if ('accounts' === $this->selectedMenu) { echo ' class="active" ';} ?>><?php echo CHtml::link('<span class="icon-file icon-white"></span> Accounts', array('/accounts')); ?></li>
						<li<?php if ('busgets' === $this->selectedMenu) { echo ' class="active" ';} ?>><?php echo CHtml::link('<span class="icon-exclamation-sign icon-white"></span> Budgets', array('/budgets')); ?></li>
						<li<?php if ('reminders' === $this->selectedMenu) { echo ' class="active" ';} ?>><?php echo CHtml::link('<span class="icon-time icon-white"></span> Reminders', array('/reminders')); ?></li>
						<li<?php if ('categories' === $this->selectedMenu) { echo ' class="active" ';} ?>><?php echo CHtml::link('<span class="icon-tags icon-white"></span> Categories', array('/categories')); ?></li>
						<li<?php if ('reports' === $this->selectedMenu) { echo ' class="active" ';} ?>><?php echo CHtml::link('<span class="icon-signal icon-white"></span> Reports', array('/reports')); ?></li>
					</ul>
					<ul class="nav pull-right">

						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								Logged in as <span style="color: #d9edf7; " ><?php echo Yii::app()->user->getName(); ?></span><b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<li><?php echo CHtml::link('<span class="icon-user" ></span> Account settings', array('account/settings')); ?></li>
								<li class="divider"></li>
								<li><?php echo CHtml::link('<span class="icon-off" ></span> Logout', array('site/logout')); ?></li>
							</ul>
						</li>

					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span3">
				<div class="well sidebar-nav total-balance" >
					<h3>Total balance: <em><span class="positive-balance"><?php $this->widget('HtmlMoneyValue', array('value' => $this->user->totalBalance)); ?></span></em></h3>

					<div class="btn-group" style="width: 170px; margin-left: auto; margin-right: auto; text-align: left; " >
						<?php echo CHtml::link('<strong><span class="icon-plus icon-white"></span> Add Transaction</strong>', array('transaction/create'), array('class' => 'btn btn-danger')); ?>
						<button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
						<ul class="dropdown-menu">
							<li><?php echo CHtml::link('Add transfer', array('transaction/create', 'transaction_type' => 'Transfer')); ?></li>
							<li><?php echo CHtml::link('Add multiple transactions', array('transaction/createMultiple')); ?></li>
							<li class="divider"></li>
							<li><?php echo CHtml::link('Import transactions', array('transaction/import')); ?></li>
						</ul>
					</div><!-- /btn-group -->
				</div>

				<div class="well sidebar-nav account-sidebar">
					<ul class="nav nav-list">
						<?php $accounts = $this->user->getAccountsByType(Account::TYPE_CASH); ?>
						<?php if (count($accounts) > 0): ?>
							<li class="nav-header"><span class="icon-picture"></span> Cash accounts</li>
							<?php foreach ($accounts as $account): ?>
								<li>
									<a href="<?php echo CHtml::normalizeUrl(array('accounts/view', 'id' => $account->id)); ?>">
										<?php echo $account->name; ?>
										<?php $this->widget('HtmlMoneyValue', array('value' => $account->actual_balance, 'account' => $account)); ?>
									</a>
								</li>
							<?php endforeach; ?>
						<?php endif; ?>


						<?php $accounts = $this->user->getAccountsByType(Account::TYPE_CHECKING); ?>
						<?php if (count($accounts) > 0): ?>
							<li class="nav-header"><span class="icon-check"></span> Checking accounts</li>
							<?php foreach ($accounts as $account): ?>
								<li>
									<a href="<?php echo CHtml::normalizeUrl(array('accounts/view', 'id' => $account->id)); ?>">
										<?php echo $account->name; ?>
										<?php $this->widget('HtmlMoneyValue', array('value' => $account->actual_balance, 'account' => $account)); ?>
									</a>
								</li>
							<?php endforeach; ?>
						<?php endif; ?>


						<?php $accounts = $this->user->getAccountsByType(Account::TYPE_CREDIT_CARD); ?>
						<?php if (count($accounts) > 0): ?>
							<li class="nav-header"><span class="icon-th-large"></span> Credit Cards</li>
							<?php foreach ($accounts as $account): ?>
								<li>
									<a href="<?php echo CHtml::normalizeUrl(array('accounts/view', 'id' => $account->id)); ?>">
										<?php echo $account->name; ?>
										<?php $this->widget('HtmlMoneyValue', array('value' => $account->actual_balance, 'account' => $account)); ?>
									</a>
								</li>
							<?php endforeach; ?>
						<?php endif; ?>


						<?php $accounts = $this->user->getAccountsByType(Account::TYPE_SAVINGS); ?>
						<?php if (count($accounts) > 0): ?>
							<li class="nav-header"><span class="icon-signal"></span> Savings</li>
							<?php foreach ($accounts as $account): ?>
								<li>
									<a href="<?php echo CHtml::normalizeUrl(array('accounts/view', 'id' => $account->id)); ?>">
										<?php echo $account->name; ?>
										<?php $this->widget('HtmlMoneyValue', array('value' => $account->actual_balance, 'account' => $account)); ?>
									</a>
								</li>
							<?php endforeach; ?>
						<?php endif; ?>

						<li class="divider"></li>
					</ul>

					<?php echo CHtml::link('<span class="icon-plus"></span> Add account', array('/accounts/create'), array('class' => 'btn btn-small', 'style' => 'margin-left: 15px; ')); ?>
					<?php echo CHtml::link('<span class="icon-pencil"></span> Edit accounts', array('/accounts'), array('class' => 'btn btn-small', 'style' => 'margin-right: 15px; float: right; ')); ?>
				</div><!--/.well -->
			</div><!--/span-->
			<div class="span9">
				<?php echo $content; ?>
			</div><!--/span-->
		</div><!--/row-->
		<hr />

		<footer>
			<?php /*p>&copy; Company 2012</p */ ?>
		</footer>

	</div><!--/.fluid-container-->

	<script type="text/javascript">

		$( ".datepicker" ).datepicker({
			'dateFormat': 'yy-mm-dd'
		});

	</script>

<?php $this->endContent(); ?>