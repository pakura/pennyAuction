<?php
//print_r($auctions);

    $secTomyTime = function($timeFormat, $second){
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
<div class="content">
    <?php
        for ($ii=0; $ii<sizeof($auctions); $ii++){
            if ($auctions[$ii]->finished == 1){
                $endclass = 'inactive';
            } else {
                $endclass = 'activeAuctionss';
            }
            if ($ii < 15) {
                echo '<div class="SingleItem_WP '.$endclass.'" id="auctionID_' . $auctions[$ii]->id . '">';
                        if (intval($auctions[$ii]->bid_price)>1){
                            echo '<div class="bidsValue"  tooltip="დადებისას ჩამოგეჭრებათ '.$auctions[$ii]->bid_price.' ბიდი"><span class="x">x</span>'.$auctions[$ii]->bid_price.'</div>';
                        }
                      echo  '<div class="poster">
                            <a href="/auctions/' . $auctions[$ii]->url_title . '" title="' . $auctions[$ii]->product_name . '">
                                <img src="/assets/uploads/' . $auctions[$ii]->thumbnail . '" title="' . $auctions[$ii]->product_name . '" alt="' . $auctions[$ii]->product_name . '"/>
                            </a>
                        </div>
                        <div class="title_WP">' . $auctions[$ii]->product_name . '</div>
                        <div class="countdown_wp">
                            <div class="blocks">' . $secTomyTime('H', intval($auctions[$ii]->time_left / 1000)) . '</div>
                            <div class="block_space">:</div>
                            <div class="blocks">' . $secTomyTime('M', intval($auctions[$ii]->time_left / 1000)) . '</div>
                            <div class="block_space">:</div>
                            <div class="blocks">' . $secTomyTime('S', intval($auctions[$ii]->time_left / 1000)) . '</div>
                        </div>
                        <div class="Cost_WP">
                            <div class="cost">' . $this->lang->line('cont_auctionCost') . '<br><span>' . (number_format($auctions[$ii]->price, 2, '.', ',')) . '<lari>l</lari></span>
                            </div>
                            <div class="bid hvr-shutter-out-horizontal noselect" onclick="bid(' . $auctions[$ii]->id . ')">' . $this->lang->line('cont_bid') . '</div>
                            <a href="/auctions/' . $auctions[$ii]->url_title . '" title="' . $auctions[$ii]->product_name . '"> <div class="autoBid">
                                <img src="/assets/imgs/space.png" id="autoBid" class="hvr-pop" title="' . $this->lang->line('cont_autoBid') . '" />
                            </div></a>
                        </div>
                        <div class="lastBidder"><span class="lastwinnername">'.$this->lang->line('cont_winner').'</span> ' . $auctions[$ii]->last_bidder_username . '</div>
                    </div>';
            }
        }

    ?>

</div>
<div style="clear: both"></div>