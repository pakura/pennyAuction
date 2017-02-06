<div class="profile_container">
    <div id="Profile_info" class="profile_WP profile_sec" >

        <img src="/assets/avatars/<?= $userdata->avatar_id ?>.png" width="64px" style="float: left; margin-top: 10px; margin-right: 20px; margin-left: 15px" />
        <div style="float:left;width: 50%; line-height: 20px;">
                <?= $this->lang->line('profile_username') ?><span><?= $userdata->username ?></span>
                <p><?= $this->lang->line('profile_name') ?> <span><?= $userdata->firstname ?></span></p>
                <p><?= $this->lang->line('profile_firstname') ?> <span><?= $userdata->lastname ?></span></p>
                <p><?= $this->lang->line('profile_birthday') ?> <span><?= $userdata->date_of_birth ?></span></p>
                <p><?= $this->lang->line('profile_personalID') ?> <span><?= $userdata->id_number ?></span></p>
                <p><?= $this->lang->line('profile_sex') ?> <span><?php if ($userdata->gender == 0){ echo $this->lang->line('profile_male'); } else { echo $this->lang->line('profile_female'); } ?></span></p>
                <p><?= $this->lang->line('profile_email') ?> <span><?= $userdata->email ?></span></p>
                <p><?= $this->lang->line('profile_phone') ?> <span><?= $userdata->phone ?></span></p>
                <p><?= $this->lang->line('profile_address') ?> <span><?= $userdata->address ?></span></p>
        </div>
        <div style="float: right; margin-right: 20px; margin-top: 10px">
            <a href="/profile/update"><button style="background-color: #5e5f61" ><?= $this->lang->line('profile_change') ?></button></a>
        </div>
    </div>
</div>