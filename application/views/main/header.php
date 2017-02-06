<div class="errorBlock">

</div>
<div class="top_header">
    <div class="header_wp">
        <div class="logo_wp">
            <a href="/"><div class="logo"></div></a>
        </div>
        <div class="menu_slide_btc" onclick="openMobileMenu()">
            <div class="menu_item"></div>
            <div class="menu_item"></div>
            <div class="menu_item"></div>
        </div>
        <div class="rMenu">
            <div class="menuBTN">
                <div class="rMenuCloser" onclick="openMobileMenu()" style="float: left;">
                    <div class="menu_item"></div>
                    <div class="menu_item"></div>
                    <div class="menu_item"></div>
                </div>Menu
            </div>
            <a href="/"><div class="menuItem"><i class="fa fa-home" style="font-size: 20px; color: #F79343;"></i> &nbsp; <?= $this->lang->line('header_home') ?></div></a>
            <a href="/main/allAuctions"><div class="menuItem"><i class="fa fa-get-pocket" style="font-size: 20px; color: #F79343;"></i> &nbsp; <?= $this->lang->line('header_auction') ?></div></a>
            <a href="/main/faq"><div class="menuItem"><i class="fa fa-question" style="font-size: 20px; color: #F79343;"></i> &nbsp; <?= $this->lang->line('header_help') ?></div></a>
            <a href="/main/contact"><div class="menuItem" style="border: none"><i class="fa fa-at" style="font-size: 20px; color: #F79343;"></i> &nbsp; <?= $this->lang->line('header_contact') ?></div></a>
            <div style="float: left; width: 100%; height: 2px; background-color: #CCC; margin-top: 10px; margin-bottom: 10px"></div>
            <?php  if ($this->session->userdata('loggedIn')){ ?>
            <a href="/profile/info"><div class="menuItem"> &nbsp; <?= $this->lang->line('header_myInfo') ?></div></a>
            <a href="/profile/win"><div class="menuItem"> &nbsp; <?= $this->lang->line('header_myPurch') ?></div></a>
            <a href="/profile/buy"><div class="menuItem"> &nbsp; <?= $this->lang->line('header_buyBids') ?></div></a>
            <a href="/main/logout"><div class="menuItem" style="float: right; width: auto; margin-right: 10px; color: #888; border: none">Log Out</div></a>
            <?php }else{ ?>
            <a href="/register"><div class="menuItem"> &nbsp; <?= $this->lang->line('header_singin') ?></div></a>
            <a href="/register"><div class="menuItem"> &nbsp; <?= $this->lang->line('header_singup') ?></div></a>
            <?php } ?>
        </div>
        <div class="menu_wp">
            <div class="profile_section">
                <?php
                    if ($this->session->userdata('loggedIn')) {
                        ?>
                        <div class="profile_btn">
                            <a href="/profile/info"><div class="icon"><img src="/assets/imgs/space.png" id="profile_icon"/></div></a>
                            <a href="/profile/info"><div class="profile_name"><span class="hideText"><?= $this->lang->line('header_hello') ?>:&nbsp; </span><?php echo  $this->session->userdata('username') ?></a>
                            </div>
                            <div class="dropIcon" onclick="showProfMenu()"><img src="/assets/imgs/space.png"
                                                                                id="drowIcon"/></div>
                        </div>
                        <div class="profie_dropDown">
                            <a href="/main/allAuctions"><div class="item"><?= $this->lang->line('header_liveAuction') ?></div></a>
                            <line></line>
                           <a href="/profile/win"><div class="item"><?= $this->lang->line('header_myPurch') ?></div></a>
                            <line></line>
                            <a href="/profile/buy"><div class="item"><?= $this->lang->line('header_buyBids') ?></div></a>
                            <line></line>
                            <a href="/profile/history"><div class="item"><?= $this->lang->line('header_history') ?></div></a>
                        </div>
                        <div class="bids_cnt"><?= $this->lang->line('header_bids') ?>: <bids id="bids_cnt"><?= $this->session->userdata('userBids') ?> </bids>
                            <a href="/profile/buy"> <span><?= $this->lang->line('header_buy') ?></span></a></div>
                        <div class="logOut"><a href="/main/logout"><img src="/assets/imgs/space.png" id="logOut_icon"><span class="hideText">&nbsp;<?= $this->lang->line('header_logout') ?></span></a>
                        </div>
                        <?php
                    } else {
                        ?>
                            <div class="register_WP" style="border-bottom-left-radius: 6px; background-color: #F18100">
                                <div class="item" onclick="openLoginWP()"><?= $this->lang->line('header_singin') ?></div>
                            </div>
                            <div class="register_WP" style="border-bottom-right-radius: 6px;">
                                <a href="/register"><div class="item" ><?= $this->lang->line('header_singup') ?></div></a>
                            </div>

                            <div class="login_WP">
                                <h3><?= $this->lang->line('header_authorisation') ?></h3>
                                <?= $this->lang->line('header_singinText') ?>
                                <?php echo form_open('main/login') ?>
                                    <br>
                                    <input type="text" class="loginput" placeholder="<?= $this->lang->line('header_name') ?>" name="username" required/><br><br>
                                    <input type="password" class="loginput" placeholder="<?= $this->lang->line('header_password') ?>" name="password" required/><br><br>
                                    <input type="checkbox" checked name="remember"/> <label for="remember"> <?= $this->lang->line('header_remember') ?></label>
                                    <input type="submit" class="logsubmit" value="<?= $this->lang->line('header_singin') ?>" name="submit"/>
                                </form>
                                <a href="/facebook/login"> <img src="/assets/imgs/login_fb.png" width="135" height="31"  style="width: 135px; margin-top: 27px;"></a>
                            </div>
                        <?php
                    }?>
            </div>
            <div class="menu">
                <a href="/"><div class="hvr-fade button"><?= $this->lang->line('header_home') ?></div></a>
                <a href="/main/allAuctions"><div class="hvr-fade button"><?= $this->lang->line('header_auction') ?></div></a>
                <a href="/main/faq"><div class="hvr-fade button"><?= $this->lang->line('header_help') ?></div></a>
                <a href="/main/contact"><div class="hvr-fade button"><?= $this->lang->line('header_contact') ?></div></a>
                <div class="phone_wp">
                    <img src="/assets/imgs/space.png" id="phone_icon"/><span>+(995) 555 55 55 55<br><span style="font-size: 16px">24/7</span></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="clear: both"></div>