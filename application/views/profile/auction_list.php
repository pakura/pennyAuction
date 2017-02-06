<?php
//echo json_encode($auctions);
date_default_timezone_set("Asia/Tbilisi");
$currentTime = strtotime('now');

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
<div class="profile_container">
    <div class="profile_sec" id="win_WP" >
        <?php if (sizeof($auctions)>0) { ?>
            <?php foreach ($auctions as $auc): ?>
                <div class="winItem">
                    <a href="/auctions/<?php echo $auc->url_title ?>">
                        <?php
                        if ($auc->payed == 1){
                            echo '<div class="bought"><img src="/assets/imgs/space.png" id="bought"/> </div>';
                        }
                        ?>
                        <div class="poster">
                            <img src="/assets/uploads/<?= $auc->thumbnail ?>"/>
                        </div>
                        <div class="title"><?= $auc->product_name ?></div>
                    </a>

                    <div style="clear: both"></div>
                    <div style="width: 100px; height: 1px; background-color: #e5e5e5; margin-left: auto; margin-right: auto; margin-bottom: 6px"></div>
                    <?php if ($auc->finished == 1) {?>
                    <div class="biders">
                        დასრულდა:
                        <span><?= $auc->end_time ?></span>
                        <br>გადახდის ვადა:
                        <span>
                        <?php
                        if ($auc->payed != 1) {
                            if (strtotime($auc->end_time . ' +48 hours') - $currentTime > 0) {
                                echo secTomyTime('H', (strtotime($auc->end_time.' +48 hours') - $currentTime)) . ':' .
                                    secTomyTime('M', (strtotime($auc->end_time . ' +48 hours') - $currentTime));
                            } else {
                                echo 'ამოიწურა';
                            }
                        } else {
                            echo 'გადახდილია';
                        }
                        ?>
                        </span>
                        <br>სულ ბიდი:
                        <span><?= $auc->total_bids ?></span>
                        <br>სულ მოთამაშე:
                        <span><?= $auc->unique_bids ?></span>
                    </div>
                    <?php } else { ?>
                        <div class="countdown_wp" style="height: 95px">
                            <div class="blocks">17</div>
                            <div class="block_space">:</div>
                            <div class="blocks">59</div>
                            <div class="block_space">:</div>
                            <div class="blocks">51</div>
                        </div>
                    <?php } ?>
                    <?php if ($auc->finished == 1 && $auc->payed == 0 &&
                        $auc->last_bidder_id == $this->session->userdata['userId'] &&
                        strtotime($auc->end_time . ' +48 hours') - $currentTime > 0) {?>
                    <a href="#">
                        <div class="price unpayed">
                            გადაიხადე <?= number_format($auc->price, 2, '.', ',') ?><lari>l</lari>
                        </div>
                    </a>
                    <?php } else { ?>
                    <div class="price">
                        <?= number_format($auc->price, 2, '.', ',') ?><lari>l</lari>
                    </div>
                    <?php } ?>
                </div>
            <?php endforeach;
        } else {
            echo 'სია ცარიელია';
        }?>
    </div>
</div>