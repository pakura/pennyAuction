<div class="allAuctions">

</div>
<?php
    echo $contentfilter;

    echo $items;

//   echo $offset;
?>
<div class="loadmore_WP">
    <?php
        if ($offset == 0){
            echo '<div class="loadprew inactive">წინა</div>';
        } else {
            echo '<a href="/main/allAuctions/'.($offset-15).'"><div class="loadprew">წინა</div></a>';
        }
        if (sizeof($auctions) < 15){
            echo '<div class="loadnext inactive">შემდეგ</div>';
        } else {
            echo '<a href="/main/allAuctions/'.($offset+15).'"><div class="loadnext">წინა</div></a>';
        }
    ?>
</div>
