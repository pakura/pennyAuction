<?php
//print_r($userdata)
    //$sec = isset($_GET['sec'])?$_GET['sec']:'info';
?>
<div class="profile_container">
    <div id="Profile_info" class="profile_WP profile_sec <?= $subPages['info'] ?>" >

        <img src="http://icons.iconarchive.com/icons/artua/ukrainian-motifs/512/Male-User-icon.png" width="64px" style="float: left; margin-top: 10px; margin-right: 20px; margin-left: 15px" />
        <div style="float:left;width: 50%">
            <table>
                <tr>
                    <td>
                        <?= $this->lang->line('profile_username') ?>
                    </td>
                    <td>
                        <span><?= $userdata->username ?></span>
                    </td>
                </tr>
                <p><?= $this->lang->line('profile_name') ?> <span><?= $userdata->firstname ?></span></p><br><br>
                <p><?= $this->lang->line('profile_firstname') ?> <span><?= $userdata->lastname ?></span></p>
                <p><?= $this->lang->line('profile_birthday') ?> <span><?= $userdata->date_of_birth ?></span></p>
                <p><?= $this->lang->line('profile_sex') ?> <span><?php if ($userdata->gender == 0){ echo $this->lang->line('profile_male'); } else { echo $this->lang->line('profile_female'); } ?></span></p>
                <p><?= $this->lang->line('profile_email') ?> <span><?= $userdata->email ?></span></p>
                <p><?= $this->lang->line('profile_phone') ?> <span><?= $userdata->phone ?></span></p>
                <p><?= $this->lang->line('profile_address') ?> <span><?= $userdata->address ?></span></p>
            </table>
        </div>
        <div style="float: right; margin-right: 20px; margin-top: 10px">
            <a href="#"><button style="background-color: #5e5f61" onclick="changeProfileMenu('Profile_info_update', this)"><?= $this->lang->line('profile_change') ?></button></a>
        </div>
    </div>


    <div id="Profile_info_update" class="profile_WP profile_sec <?= $subPages['update'] ?>" >
        <h2><?= $this->lang->line('profile_edit') ?></h2>
        <?php echo validation_errors(); ?>
        <br>
        <?php echo form_open('/profile/info') ?>
        <label for="username" style="line-height: 30px;"><?= $this->lang->line('profile_edit') ?>: </label>
        <input type="password" name="oldpassword" placeholder="Current password" class="loginput" /><br><br>
        <label for="username" style="line-height: 30px;"><?= $this->lang->line('profile_edit') ?> </label>
        <input type="password" name="password" placeholder="New password" class="loginput" /><br><br>
        <label for="username" style="line-height: 30px;"><?= $this->lang->line('profile_edit') ?>: </label>
        <input type="password" name="password2" placeholder="New password" class="loginput" /><br><br>

        <hr><br>

        <label for="username" style="line-height: 30px;">ელ-ფოსტა: </label>
        <input type="text" name="email" value="<?= $userdata->email ?>" class="loginput" /><br><br>
        <label for="username" style="line-height: 30px;">ტელეფონის ნომერი: </label>
        <input type="number" name="phone" value="<?= $userdata->phone ?>" class="loginput" /><br><br>
        <label for="username" style="line-height: 30px;">მისამართი: </label>
        <input type="text" name="address" value="<?= $userdata->address ?>" class="loginput" /><br><br>
        <label for="username" style="line-height: 30px;">ქალაქი: </label>
        <select name="city" class="loginput" style="    width: 58.4%; height: 36px;">
            <option value="თბილისი">თბილისი</option>
            <option value="ქუთაისი">ქუთაისი</option>
            <option value="ბათუმი">ბათუმი</option>
            <option value="რუსთავი">რუსთავი</option>
            <option value="გორი">გორი</option>
        </select>
        <br><br><br><br>
        <input type="submit" value="შენახვა" class="logsubmit" />
        </form>
        <a href="/profile/info"><button>გაუქმება</button></a>
    </div>


    <div id="buyBidsWP" class="profile_sec <?= $subPages['buy'] ?>" >
        <div class="bidsItem">
            <div class="packeticon">
                <div class="buyBidsCNT">50<br>BIDS</div>
                <img src="/assets/imgs/bidsnum1.png"/>
            </div>
            <div class="buyBTN">
                <div class="buyprice">10<lari>l</lari></div>
                <div class="buyicon">ყიდვა</div>
            </div>
        </div>
        <div class="bidsItem">
            <div class="packeticon">
                <div class="buyBidsCNT">100<br>BIDS</div>
                <img src="/assets/imgs/bidsnum2.png"/>
            </div>
            <div class="buyBTN">
                <div class="buyprice">18<lari>l</lari></div>
                <div class="buyicon">ყიდვა</div>
            </div>
        </div>
        <div class="bidsItem">
            <div class="packeticon">
                <div class="buyBidsCNT">300<br>BIDS</div>
                <img src="/assets/imgs/bidsnum3.png"/>
            </div>
            <div class="buyBTN">
                <div class="buyprice">48<lari>l</lari></div>
                <div class="buyicon">ყიდვა</div>
            </div>
        </div>
        <div class="bidsItem">
            <div class="packeticon">
                <div class="buyBidsCNT">500<br>BIDS</div>
                <img src="/assets/imgs/bidsnum4.png"/>
            </div>
            <div class="buyBTN">
                <div class="buyprice">80<lari>l</lari></div>
                <div class="buyicon">ყიდვა</div>
            </div>
        </div>
        <div class="bidsItem">
            <div class="packeticon">
                <div class="buyBidsCNT">1000<br>BIDS</div>
                <img src="/assets/imgs/bidsnum5.png"/>
            </div>
            <div class="buyBTN">
                <div class="buyprice">145<lari>l</lari></div>
                <div class="buyicon">ყიდვა</div>
            </div>
        </div>

    </div>
    <div class="profile_sec <?= $subPages['purchase'] ?>" id="purchaseHistory_WP">
        <div class="purchaseItem">
            <div class="bought">
                <img src="/assets/imgs/space.png" id="bought">
            </div>
            <div class="poster">
                <img src="http://bids.ge/assets/uploads/87f4be3d14b18be529eabd01d8b92c80.jpg"/>
            </div>
            <div class="title">Kindle, 6" Glare-Free Touchscreen Display</div>
            <div style="clear: both"></div>
            <div style="width: 100px; height: 1px; background-color: #e5e5e5; margin-left: auto; margin-right: auto"></div>
            <div class="biders">
                სულ ბიდები: <span>21003</span><br>სულ ბიდერები: <span>127</span>
            </div>
            <div class="price">12.5<lari>l</lari></div>
        </div>
        <div class="purchaseItem">
            <div class="bought">
                <img src="/assets/imgs/space.png" id="bought">
            </div>
            <div class="poster">
                <img src="http://bids.ge/assets/uploads/87f4be3d14b18be529eabd01d8b92c80.jpg"/>
            </div>
            <div class="title">Kindle, 6" Glare-Free Touchscreen Display</div>
            <div style="clear: both"></div>
            <div style="width: 100px; height: 1px; background-color: #e5e5e5; margin-left: auto; margin-right: auto"></div>
            <div class="biders">
                სულ ბიდები: <span>21003</span><br>სულ ბიდერები: <span>127</span>
            </div>
            <div class="price">12.5<lari>l</lari></div>
        </div>
        <div class="purchaseItem">
            <div class="bought">
                <img src="/assets/imgs/space.png" id="bought">
            </div>
            <div class="poster">
                <img src="http://bids.ge/assets/uploads/87f4be3d14b18be529eabd01d8b92c80.jpg"/>
            </div>
            <div class="title">Kindle, 6" Glare-Free Touchscreen Display</div>
            <div style="clear: both"></div>
            <div style="width: 100px; height: 1px; background-color: #e5e5e5; margin-left: auto; margin-right: auto"></div>
            <div class="biders">
                სულ ბიდები: <span>21003</span><br>სულ ბიდერები: <span>127</span>
            </div>
            <div class="price">12.5<lari>l</lari></div>
        </div>
        <div class="purchaseItem">
            <div class="poster">
                <img src="http://bids.ge/assets/uploads/87f4be3d14b18be529eabd01d8b92c80.jpg"/>
            </div>
            <div class="title">Kindle, 6" Glare-Free Touchscreen Display</div>
            <div style="clear: both"></div>
            <div style="width: 100px; height: 1px; background-color: #e5e5e5; margin-left: auto; margin-right: auto"></div>
            <div class="biders">
                სულ ბიდები: <span>21003</span><br>სულ ბიდერები: <span>127</span>
            </div>
            <div class="price">12.5<lari>l</lari></div>
        </div>
    </div>


    <div class="profile_sec <?= $subPages['win'] ?>" id="win_WP" >
        <div class="winItem">
            <div class="poster">
                <img src="http://bids.ge/assets/uploads/87f4be3d14b18be529eabd01d8b92c80.jpg"/>
            </div>
            <div class="title">Kindle, 6" Glare-Free Touchscreen Display</div>
            <div style="clear: both"></div>
            <div style="width: 100px; height: 1px; background-color: #e5e5e5; margin-left: auto; margin-right: auto"></div>
            <div class="biders">
                სულ ბიდები: <span>21003</span><br>სულ ბიდერები: <span>127</span>
            </div>
            <div class="price">12.5<lari>l</lari></div>
        </div>
        <div class="winItem">
            <div class="poster">
                <img src="http://bids.ge/assets/uploads/87f4be3d14b18be529eabd01d8b92c80.jpg"/>
            </div>
            <div class="title">Kindle, 6" Glare-Free Touchscreen Display</div>
            <div style="clear: both"></div>
            <div style="width: 100px; height: 1px; background-color: #e5e5e5; margin-left: auto; margin-right: auto"></div>
            <div class="biders">
                სულ ბიდები: <span>21003</span><br>სულ ბიდერები: <span>127</span>
            </div>
            <div class="price">12.5<lari>l</lari></div>
        </div>
        <div class="winItem">
            <div class="poster">
                <img src="http://bids.ge/assets/uploads/87f4be3d14b18be529eabd01d8b92c80.jpg"/>
            </div>
            <div class="title">Kindle, 6" Glare-Free Touchscreen Display</div>
            <div style="clear: both"></div>
            <div style="width: 100px; height: 1px; background-color: #e5e5e5; margin-left: auto; margin-right: auto"></div>
            <div class="biders">
                სულ ბიდები: <span>21003</span><br>სულ ბიდერები: <span>127</span>
            </div>
            <div class="price">12.5<lari>l</lari></div>
        </div>
        <div class="winItem">
            <div class="poster">
                <img src="http://bids.ge/assets/uploads/87f4be3d14b18be529eabd01d8b92c80.jpg"/>
            </div>
            <div class="title">Kindle, 6" Glare-Free Touchscreen Display</div>
            <div style="clear: both"></div>
            <div style="width: 100px; height: 1px; background-color: #e5e5e5; margin-left: auto; margin-right: auto"></div>
            <div class="biders">
                სულ ბიდები: <span>21003</span><br>სულ ბიდერები: <span>127</span>
            </div>
            <div class="price">12.5<lari>l</lari></div>
        </div>

    </div>


    <div class="profile_sec <?= $subPages['help'] ?>" id="help_WP" >
        <select id="helptype">
            <option value="0">შესყიდვებთან დაკავშირებული პრობლემა</option>
            <option value="0">ტექნიკური დახმარება</option>
            <option value="0">ადმინისტრაცია</option>
        </select>
        <br><br>
        <textarea id="message"></textarea>
        <br><br>
        <button>გაგზავნა</button>
    </div>


</div>
