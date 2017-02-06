
<?php
date_default_timezone_set("Asia/Tbilisi");
//print_r( $auctionData );
//print_r( $bidders );
//print_r($autoBidder);
$thisTimestamp = time();
$startTime = strtotime($auctionData->start_time);
$endTime = strtotime($auctionData->end_time);
?>

<script>
    var auctionID = <?php echo $auctionData->id ?>;
    var lastPrice = <?php echo isset($bidders[0]->price)?$bidders[0]->price:number_format($auctionData->price , 2, '.', ','); ?>;
    var autobid = <?php
if (gettype($autoBidder) == 'NULL'){
    echo 'false';
} else {
    echo 'true';
}
?>;
</script>

<div class="content_product">
    <div class="product_top">
        <div class="mainBlock">
            <div class="bidsValue" tooltip="დადებისას ჩამოგეჭრებათ <?= $auctionData->bid_price; ?> ბიდი"><span class="x">x</span><?= $auctionData->bid_price; ?></div>
            <div class="toparrow" onclick="changeTopCarusel(0)"></div>
            <div class="title"><span><?php echo $auctionData->product_name; ?> </span> <span style="float: right; color: #8a8a8a">ID: <?php echo $auctionData->id; ?></span></div>
            <div class="mainPposter">
                <img id="poster" onclick="showScreen(this.src, true)" class="hvr-grow" src="/assets/uploads/<?php echo $auctionData->images[0]->filename ?>" title="<?php echo $auctionData->product_name ?>" alt="<?php echo $auctionData->product_name ?>"/>
            </div>
            <div class="MSlide" >
                <div class="leftScreen" onclick="changeCarusel(0)"></div>
            </div>
            <div class="screens">
                <div class="screensItem" style="position: relative; left: 0px;">
                    <?php
                    for ($ii = 0; $ii<sizeof($auctionData->images); $ii++){

                        if ($ii == 0){
                            echo '<img class="screen" style="border: 1px solid #EE6700;" src="/assets/uploads/'.$auctionData->images[$ii]->thumbnail.'" title="'.$auctionData->product_name .'" alt="'.$auctionData->product_name .'" onclick="changeScreen(\''.$auctionData->images[$ii]->filename.'\', this); showScreen(\'/assets/uploads/'.$auctionData->images[$ii]->filename.'\', false)" / >';
                        } else {
                            echo '<img class="screen" src="/assets/uploads/'.$auctionData->images[$ii]->thumbnail.'" title="'.$auctionData->product_name .'" alt="'.$auctionData->product_name .'" onclick="changeScreen(\''.$auctionData->images[$ii]->filename.'\', this); showScreen(\'/assets/uploads/'.$auctionData->images[$ii]->filename.'\', false)" / >';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="MSlide" >
                <div class="rightScreen" onclick="changeCarusel(1)"></div>
            </div>
            <div class="downarrow" onclick="changeTopCarusel(1)"></div>
        </div>
        <div class="modBlock">
            <div class="tilltext <?php if ($auctionData->finished == 1){ echo 'endclass'; }?>"><?php if ($auctionData->finished != 1){ echo $this->lang->line('cont_tillEnd'); } else { echo $this->lang->line('cont_endAuction'); } ?> </div>

            <div class="lastprice" <?php if ($auctionData->finished != 1){ echo 'style="display: none"'; }?>>
                <?= $this->lang->line('cont_cost') ?>: <span><?= number_format($auctionData->price , 2, '.', ',')?></span><lari>l</lari>
            </div>
            <div class="winnerWP" <?php if ($auctionData->finished != 1){ echo 'style="display: none"'; }?> >
                <?= $this->lang->line('cont_endwinner') ?>:
                <div><img src="/assets/avatars/<?php echo $auctionData->last_bidder_avatar; ?>.png" width="26px" style="float: left; margin-top: 9px; margin-right: 5px;"><span><?= substr($auctionData->last_bidder_username, 0, 10) ?></span></div>
            </div>
            <div class="countdown_wp"  <?php if ($auctionData->finished == 1){ echo 'style="display: none"'; }?>>
                <div class="blocks"><?php echo secTomyTime('H', intval($auctionData->time_left / 1000)) ?></div>
                <div class="block_space">:</div>
                <div class="blocks"><?php echo secTomyTime('M', intval($auctionData->time_left / 1000)) ?></div>
                <div class="block_space">:</div>
                <div class="blocks"><?php echo secTomyTime('S', intval($auctionData->time_left / 1000))?></div>
            </div>
            <div class="midline"></div>

            <div class="Cost_WP" <?php if ($auctionData->finished == 1){ echo 'style="opacity:0.5"'; }?>>
                <div class="cost"><?= $this->lang->line('cont_auctionCost') ?><br><span><?php echo number_format($auctionData->price, 2, '.', ',') ?><lari>l</lari></span>
                </div>
                <a href="#" title="<?php echo $auctionData->product_name; ?>"> <div class="bid hvr-shutter-out-horizontal" <?php if ($auctionData->finished != 1){ ?> onclick="bid(auctionID)"<?php } ?>> <?= $this->lang->line('cont_bid') ?> </div></a>
                <div class="autoBid">
                    <img src="/assets/imgs/space.png" id="FautoBid" onclick="selectAutobid()" class="hvr-pop" title="<?= $this->lang->line('cont_autoBid') ?>">
                </div>
            </div>

            <div class="Cost_WP <?php if ($auctionData->buy_now != 1){ echo 'inactivebuy'; }?>" >
                <div class="cost"><?= $this->lang->line('cont_buyPrice') ?><br><span id="buyitnow"><?= number_format($auctionData->buyItNowPrice, 2, '.', ',') ?><lari>l</lari></span></div>
                <div class="howto" tooltip="<?= $this->lang->line('cont_buyhelp') ?>">?</div>
                <?php if ($auctionData->buy_now == 1){ echo '<a href="#7" title="'.$auctionData->product_name.'">'; }?> <div class="buy hvr-shutter-out-horizontal"><?= $this->lang->line('cont_buyItNow') ?></div><?php if ($auctionData->buy_now == 1){ echo '</a>'; }?>
                <div class="addcart">
                    <img src="/assets/imgs/space.png" id="buy" class="hvr-pop" title="აუტო ბიდერი">
                </div>
            </div>
            <div style="clear: both"></div>
            <?php if ($auctionData->finished != 1){ echo '<div class="midline"></div>'; }?>

            <div style="clear: both"></div>
            <?php if ($auctionData->finished != 1){ ?>
            <div class="lastBidder">
                <?php
                echo $this->lang->line('cont_nowWin');
                if (sizeof($bidders) > 0):
                    ?>
                    <br>
                    <span><?= $auctionData->last_bidder_username ?></span>
                    <img src="/assets/avatars/<?= $auctionData->last_bidder_avatar ?>.png" width="32px" id="avatar"/>
                <?php else: ?>
                    <br>
                    <span></span>
                    <img src="/assets/imgs/space.png" width="32px" id="avatar"/>
                <?php endif;
                echo '</div>';
                }?>

            </div>
            <div class="modBlock rmodBlock">
                <div class="swicher">
                    <div class="button" onclick="showInfo(0, this)"><?= $this->lang->line('cont_info') ?></div>
                    <div class="button active" onclick="showInfo(1, this)"><?= $this->lang->line('cont_history') ?></div>
                    <div class="button" onclick="showInfo(2, this)"><?= $this->lang->line('cont_delivery') ?></div>
                </div>
                <div class="contents" id="auctionInfo">
                    <div class="item">
                        <?php if ($endTime != ''){ ?>
                        <div class="block1"><?= $this->lang->line('cont_auccontTimeed') ?>:</div>
                        <div class="block2"><?php echo secTomyTime('H', ($endTime - $startTime)).':'.secTomyTime('M', ($endTime-$startTime)); ?></div>
                        <?php } else { ?>
                        <div class="block1"><?= $this->lang->line('cont_auccontTime') ?>:</div>
                        <div class="block2"><?php echo secTomyTime('H', ($thisTimestamp - $startTime)).':'.secTomyTime('M', ($thisTimestamp-$startTime)); ?></div>
                        <?php } ?>
                    </div>
                    <div class="item">
                        <div class="block1"><?= $this->lang->line('cont_bidscntvalue') ?>:</div>
                        <div class="block2">x<?= $auctionData->bid_price ?></div>
                    </div>
                    <div class="item">
                        <div class="block1"><?= $this->lang->line('cont_livePrice') ?>:</div>
                        <div class="block2" id="liveprice"><?php echo number_format($auctionData->price, 2, '.', ',') ?><lari>l</lari></div>
                    </div>
                    <div class="item">
                        <div class="block1"><?= $this->lang->line('cont_deliveryServ') ?>:</div>
                        <div class="block2" >0.00<lari>l</lari></div>
                    </div>

                </div>
                <div class="contents" id="lastBidders">
                    <div class="tables">
                        <div class="item" style="color: #999; font-weight: bold; border-bottom: 1px solid #f2f2f2">
                            <div class="block1"><?= $this->lang->line('cont_biddername') ?></div>
                            <div class="block2"><?= $this->lang->line('cont_value') ?></div>
                        </div>
                    </div>
                    <div class="tables" id="bidHistory">

                        <?php
                        for ($ii = 0; $ii<sizeof($bidders); $ii++){
                            echo '<div class="item history_item">
                                <div class="block1">'.$bidders[$ii]->username.'</div>
                                <div class="block2">'.$bidders[$ii]->price.'</div>
                            </div>';
                        }
                        ?>

                    </div>
                </div>
                <div class="contents" id="delivery">
                    <div class="item">
                        <div class="block1"><?= $this->lang->line('cont_deliveryServ') ?>:</div>
                        <div class="block2" id="liveprice">0.00<lari>l</lari></div>
                    </div>
                    <div class="item">
                        <div class="block1" style="width: 52%"><?= $this->lang->line('cont_deliveryTime') ?>:</div>
                        <div class="block2" style="width: 42%"><?= $auctionData->delivery_time ?> <?= $this->lang->line('cont_workDay') ?></div>
                    </div>
                </div>
            </div>
            <div class="autoBidGear">
                <h2><?= $this->lang->line('cont_autoBid') ?></h2>
                <div class="autosec">
                    <label for="tillvalue"><?= $this->lang->line('cont_tillValue') ?></label>
                    <input type="text" id="tillvalue" placeholder="100" <?php if (gettype($autoBidder) != 'NULL'){ if ($autoBidder->from_price != 0.00000){ echo 'value="'.$autoBidder->from_price.'"'; }} ?>> <lari>l</lari>
                </div>
                <div class="autosec">
                    <label for="stopvalue" style="font-size: 11px"><?= $this->lang->line('cont_stopValue') ?></label>
                    <input type="text" id="stopvalue" placeholder="100"
                        <?= $autoBidder != null && $autoBidder->to_price != 99999.99999 ? 'value="'.$autoBidder->to_price.'"' : '' ?> >
                    <lari>l</lari>
                </div>
                <div class="autosec">
                    <label for="bidsvalue" style="font-size: 11px"><?= $this->lang->line('cont_bidNum') ?></label>
                    <input type="text" id="bidsvalue" placeholder="100" <?= $autoBidder != null ? 'value="'.$autoBidder->limit_bids.'"' : '' ?> >
                </div>
                <div class="autosec startBTN">
                    <div class="leftBidsCNT" style="opacity: <?= $autoBidder == null ? 0 : 1 ?>" >
                        <?= $this->lang->line('cont_leftBids') ?> <br>
                        <span id="bidsCoutn"><?= $autoBidder != null ? $autoBidder->bids_left: '' ?></span>
                    </div>

                    <button <?php if ($auctionData->finished != 1){?>onclick="sendAutoBidderOption()" <?php }else { ?> style="background-color: #969696" <?php }?>id="autoBidBTN" class="<?php
                    if (gettype($autoBidder) == 'NULL'){
                        echo 'deactiveAutoBid';
                    } else {
                        echo 'activeautoBid';
                    }
                    ?>"><?php if (gettype($autoBidder) == 'NULL'){
                            echo $this->lang->line('cont_turnOn');
                        } else {
                            echo $this->lang->line('cont_turnOff');
                        }  ?></button>

                </div>
            </div>
        </div>

        <div class="description">
            <div class="header">
                <div class="button active" id="descriptionBTN" onclick="changeDesc(1)"><?= $this->lang->line('cont_review') ?></div>
                <div class="button" id="specificationBTN" onclick="changeDesc(2)"><?= $this->lang->line('cont_specification') ?></div>
            </div>
            <div class="description_cont">
                <?php echo $auctionData->description ?>

            </div>
            <div class="spec_cont">
                <?php echo $auctionData->spec ?>
            </div>
        </div>

    </div>

    <div class="popupscreens" onclick="popupclose()">
        <img src="/assets/uploads/69f590cdff75296ca1068e4cdae51202.jpg" id="thisScreen" style="cursor: zoom-out" class="dragimg ui-widget-content">
    </div>

    <script>
        var startautobid = '<?= $this->lang->line('cont_turnOn') ?>';
        var stopautobid = '<?= $this->lang->line('cont_turnOff') ?>';
        var endAuctionT = '<?= $this->lang->line('cont_endAuction') ?>';
        var reset_time = <?php echo $auctionData->reset_time ?>;
    </script>

<?php
function secTomyTime($timeFormat, $second){
    if ($second < 0){
        $second = $second*-1;
    }
    switch ($timeFormat){
        case 'H':
            $hour = intval($second / 3600);
            if (strlen($hour)<2){
                return '0'.$hour;
            } else {
                return $hour;
            }
            break;
        case 'M':
            $minute = intval($second % 3600 / 60);
            if (strlen(intval($minute).'')<2){
                return '0'.intval($minute);
            } else {
                return intval($minute);;
            }
            break;
        default:
            $second = intval($second % 3600 % 60);
            if (strlen(intval($second).'')<2){
                return '0'.intval($second);
            } else {
                return intval($second);
            }
            break;
    }
}
?>