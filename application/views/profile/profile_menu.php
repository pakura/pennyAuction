<div class="profile_Menu">
    <a href="/profile/info" class="menu_item_link" > <div class="menu_item hvr-fade <?= $isActive['info'] ?>">
        <div class="icon">
            <img src="/assets/imgs/space.png" id="personalInfo" class="activeimg">
        </div><?= $this->lang->line('profile_personalDetail') ?>
    </div></a>
    <a href="/profile/buy" class="menu_item_link" > <div class="menu_item hvr-fade <?= $isActive['buy'] ?>">
            <div class="icon">
                <img src="/assets/imgs/space.png" id="buyBids">
            </div><?= $this->lang->line('profile_buyBids') ?>
    </div></a>
    <a href="/profile/ongoing" class="menu_item_link"><div class="menu_item hvr-fade <?= $isActive['ongoing'] ?>">
        <div class="icon">
            <img src="/assets/imgs/space.png" id="liveAuctions">
        </div><?= $this->lang->line('profile_liveauction') ?>
    </div></a>
    <a href="/profile/win" class="menu_item_link" ><div class="menu_item hvr-fade <?= $isActive['win'] ?>">
        <div class="icon">
            <img src="/assets/imgs/space.png" id="wonAuction">
        </div><?= $this->lang->line('profile_winauction') ?>
    </div></a>
    <a href="/profile/purchase" class="menu_item_link" ><div class="menu_item hvr-fade <?= $isActive['purchase'] ?>">
        <div class="icon">
            <img src="/assets/imgs/space.png" id="purchaseHistory">
        </div><?= $this->lang->line('profile_purchaseHistory') ?>
    </div></a>
    <a href="/profile/history" class="menu_item_link"><div class="menu_item hvr-fade <?= $isActive['history'] ?>">
            <div class="icon">
                <img src="/assets/imgs/space.png" id="historyAuctions">
            </div><?= $this->lang->line('profile_history') ?>
    </div></a>


    <a href="/profile/help" class="menu_item_link"><div style="display: none" class="menu_item hvr-fade <?= $isActive['help'] ?>">
            <div class="icon">
                <img src="/assets/imgs/space.png" id="help">
            </div><?= $this->lang->line('profile_help') ?>
    </div></a>
</div>


