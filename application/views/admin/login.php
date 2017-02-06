<?php $error = validation_errors();
    if ($wrong != ''){
        $error = $wrong;
    }
?>


<!DOCTYPE html>
<html>
<head>
    <title>BIDS.GE ADMIN Panel - login</title>
    <link href="/assets/css/admin.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/css/hover.css" rel="stylesheet" type="text/css" />
</head>
<body style="background-color: #2c3e50">
    <div class="icon"></div>
    <div class="login_WP">
        <div class="login_header">
            Bids.GE  - ADMIN Panel
        </div>
        <div class="cont">
            <p>Please login to access all our fleatures.</p>
            <?php echo form_open('/admin/admin') ?>
                <input type="text" class="loginInput" name="username" value="<?= set_value('username') ?>" placeholder="Username" style="background-image: url('/assets/imgs/loginicon.png')"/>
                <br />

                <input type="password" class="loginInput" name="password" placeholder="Password" style="background-image: url('/assets/imgs/passicon.png')" />
                <br />
                <input type="submit" name="submit" value="login" class="submitLogin" />
            </form>
        </div>
    </div>
    <div class="error_WP" style="display: <?php if ($error != ''){ echo 'block'; } else { echo 'none'; } ?>">
        <div class="topArrow"></div>
        <div class="error_cont">
            <?= $error ?>
        </div>
    </div>
</body>
</html>