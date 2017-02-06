<!DOCTYPE html>
<html>
    <head>
        <title>BIDS.GE ADMIN Panel - Home</title>
        <link href="/assets/css/admin.css" media="all" rel="stylesheet" type="text/css" />
        <link href="/assets/css/hover.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css" >
        <link rel="stylesheet" href="/assets/css/jquery.datetimepicker.css" >
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script src="//cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
        <script src="/assets/js/jquery.datetimepicker.js"></script>
        <script src="/assets/js/admin.js"></script>
        <script src="/assets/js/profile.js"></script>
    </head>
    <body onresize="resize()">
        <div class="menu_WP">
            <a href="/admin/admin"><div class="logo"></div></a>
                <?= $menu ?>
        </div>
        <div class="content">
            <div class="topMenu">

            </div>
            <div class="content_WP">
                <?= $content ?>
            </div>

        </div>
<script>
    $(function() {
        resize();
    });
    function resize(){
        var height = $( window ).height() - 70;
        $('.content_WP').css({
            'max-height': height
        })
    }
</script>
    </body>
</html>