<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head'); ?>

</head>
<body>

<?php echo $this->load->view('header'); ?>

<div class="container">
    <div class="row">
        <div class="span12">
			<div class="hero-unit" style="position: relative;">
				<ul>
				<?php 
				if ($this->authentication->is_signed_in()) : ?>
					<li><?= anchor('projects', 'Projects'); ?></li>
					<?php if( $account->is_super ) : ?>
					<li><?= anchor('users', 'Users');?></li>
					<?php endif;
				else :
				    echo anchor('account/sign_in', lang('website_sign_in')); 
				endif;
				?>
				</ul>
			</div>
        </div>
    </div>
    <!-- /end row -->
</div>

<?php echo $this->load->view('footer'); ?>

</body>
</html>