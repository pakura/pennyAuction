<?php


echo $slide;
echo $contentfilter;
echo $items;
?>


<div class="contentFilter_WP mobilehide" style="margin-top: 40px;height: 42px;">
    <div class="liveAuction mobilehide" style="font-size: 12px; border-radius: 6px; background-color: #969696; border: none"><img src="/assets/imgs/space.png" id="liveAuction">  &nbsp;<?= $this->lang->line('cont_endAuctionlist') ?></div>
</div>
<div class="mobilehide endAuction">
<?php
echo $soldItems;
?>
</div>
