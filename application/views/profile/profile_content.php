
<div class="profile_wrapper">
<?php
if (isset($regSuccess)) {
    if ($regSuccess != '') {
        echo $regSuccess;
    }
}
?>
<?= $content ?>

<?= $menu ?>
</div>
