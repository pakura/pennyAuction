<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Tbilisi");
?><!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <link rel="icon" href="/favicon.ico" type="image/x-icon" />
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <?php
    //  $this->minify->css( [ 'template.css', 'hover.css' ], 'main-head' );
    //echo $this->minify->deploy_css( ENVIRONMENT == 'development', null, 'main-head' );
    ?>

    <link href="/assets/css/template.css?v=1" rel="stylesheet" type="text/css" />
    <link href="/assets/css/hover.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/assets/css/tpl.css?v=2" type="text/css" media="screen and (min-width: 1025px)" />
    <link rel='stylesheet' href='/assets/css/tpl-medium.css?v=2' media='screen and (min-width: 639px) and (max-width: 1024px)' />
    <link rel='stylesheet' href='/assets/css/tpl-small.css?v=2' media='screen and (max-width: 638px)' />
</head>
<body>
<div class="popupBG" onclick="popupclose()"></div>
<div class="popuptraBG" onclick="popupclose()"></div>
<?php
echo $header;
echo $content;
echo $footer;
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!--link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css" -->
<!--script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script-->
<?php
$this->minify->js( ['template.js','soket.js'], 'main-js' );
//echo $this->minify->deploy_js( ENVIRONMENT == 'development', null, 'main-js' );
?>
<script>
    window.config = {
        wssUrl: '<?= $this->config->item('site')['wssUrl'] ?>'
    };
</script>
<script src="/assets/js/template.js?v=2"></script>
<script src="/assets/js/soket.js?v=8"></script>
<script>
    <?php
        if ($this->session->userdata('loggedIn')){
            echo 'var userID = '.$this->session->userdata('userId').';';
            echo 'var sesID = "'.$this->session->userdata('session_id').'";';
            echo 'var username= "'.$this->session->userdata('username').'";';
            echo 'var loggedin = true;';
        } else {
            echo 'var loggedin = false;';
        }

        echo 'var errorarr = ["",
            "'.$this->lang->line('error1').'",
            "'.$this->lang->line('error2').'",
            "'.$this->lang->line('error3').'",
            "'.$this->lang->line('error4').'",
            "'.$this->lang->line('error5').'",
            "'.$this->lang->line('error6').'",
            "'.$this->lang->line('error7').'",
            "'.$this->lang->line('error8').'",
            "'.$this->lang->line('error9').'",
            "'.$this->lang->line('error10').'",
            "'.$this->lang->line('error11').'",
            "'.$this->lang->line('error12').'"
        ];';

    ?>
</script>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-68634494-1', 'auto');
    ga('require', 'linkid');
    ga('send', 'pageview');

</script>
</body>
</html>