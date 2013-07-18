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
				<?php 
				if ($this->authentication->is_signed_in()) : 
				    echo anchor('projects', 'My projects');
				else :
				    echo anchor('account/sign_in', lang('website_sign_in')); 
				endif;
				?>
			</div>
        </div>
    </div>
    <!-- /end row -->
</div>

<?php echo $this->load->view('footer'); ?>

</body>
</html>