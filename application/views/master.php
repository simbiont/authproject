<!DOCTYPE html>
<html>
<head>
    <?php echo $this->load->view('head'); ?>
</head>
<body>

    <header>
        <?php echo $this->load->view('header'); ?>
    </header>

    <div class="container">
        <?php echo $subview ?>
    </div>

    <footer>
        <?php echo $this->load->view('footer'); ?>
    </footer>

</body>
</html>