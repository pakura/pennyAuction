<div class="profile_container">
    <div class="profile_sec" id="help_WP" >
        <select id="helptype">
            <option value="0">შესყიდვებთან დაკავშირებული პრობლემები</option>
            <option value="1">ტექნიკური დახმარება</option>
            <option value="2">ადმინისტრაცია</option>
        </select>
        <br><br>
        <textarea id="message"></textarea>
        <br><br>
        <button><?= $this->lang->line('profile_send') ?></button>
    </div>

    <div class="help_faq">
        <div class="item_faq" onclick="showFullFaq(this)">
            <span><?= $this->lang->line('cont_whatisBids') ?></span>
            <div class="fullThisFaq"><?= $this->lang->line('cont_whatisBidsans') ?></div>
        </div>
        <div class="item_faq" onclick="showFullFaq(this)">
            <span><?= $this->lang->line('cont_howitwork') ?></span>
            <div class="fullThisFaq"><?= $this->lang->line('cont_howitworkans') ?></div>
        </div>
        <div class="item_faq" onclick="showFullFaq(this)">
            <span><?= $this->lang->line('cont_whatfunction') ?></span>
            <div class="fullThisFaq"><?= $this->lang->line('cont_whatfunctionans') ?></div>
        </div>
        <div class="item_faq" onclick="showFullFaq(this)">
            <span><?= $this->lang->line('cont_howto') ?></span>
            <div class="fullThisFaq"><?= $this->lang->line('cont_howtoans') ?></div>
        </div>
        <div class="item_faq" onclick="showFullFaq(this)">
            <span><?= $this->lang->line('cont_ifloos') ?></span>
            <div class="fullThisFaq"><?= $this->lang->line('cont_ifloosans') ?></div>
        </div>
        <div class="item_faq" onclick="showFullFaq(this)">
            <span><?= $this->lang->line('cont_notbuyitnow') ?></span>
            <div class="fullThisFaq"><?= $this->lang->line('cont_notbuyitnowans') ?></div>
        </div>
        <div class="item_faq" onclick="showFullFaq(this)">
            <span><?= $this->lang->line('cont_auctiontime') ?></span>
            <div class="fullThisFaq"><?= $this->lang->line('cont_auctiontimeans') ?></div>
        </div>
        <div class="item_faq" onclick="showFullFaq(this)">
            <span><?= $this->lang->line('cont_isitnew') ?></span>
            <div class="fullThisFaq"><?= $this->lang->line('cont_isitnewans') ?></div>
        </div>


    </div>
</div>