<!DOCTYPE html>
<html>
<head>
    <?php echo $this->load->view('head', $this->data); ?>
</head>
<body>

    <header>
        <?php echo $this->load->view('header', $this->data); ?>
    </header>

    <div class="container">
        <?php echo $this->data['subview'] ?>
    </div>

    <footer>
        <?php echo $this->load->view('footer', $this->data); ?>
    </footer>

</body>
</html>