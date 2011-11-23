<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-script-Type" content="text/html/javascript; charset=utf-8" />
    </head>
    <body>
        <?php echo $text['title']; ?>
        <br />
        <?php echo $text['message']; ?>
        <br />
        <?php
        $session = Session::instance()->as_array();
        $lastController = isset($session['last_controller']) ? $session['last_controller'] : 'Controller_Welcome';
        $arr = explode('_', $lastController);
        $adr = mb_strtolower($arr[count($arr)-1]);
        ?>
        <?php echo $text['celar'][0]; ?> <a href="/"><?php echo $text['celar'][1]; ?></a> <?php echo $text['celar'][2]; ?>
    </body>
</html>
