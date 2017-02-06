<div class="profile_container">
    <div id="Profile_info_update" class="profile_WP profile_sec" >
        <h2><?= $this->lang->line('profile_edit') ?></h2>
        <span style="color: #FF5656">
            <?php
            $errClass = [
                'password'=>'',
                'password2'=>'',
                'email'=>'',
                'phone'=>'',
                'city'=>'',
                'oldpassword'=>'',
                'address'=>''
            ];

            $onceError = 0;
            if (form_error('password') != '') {
                $errClass['password'] = 'errorInput';
                $errClass['password2'] = 'errorInput';
                echo form_error('password');
            }
            elseif (form_error('password2') != '') {
                $errClass['password2'] = 'errorInput';
                $errClass['password'] = 'errorInput';
                echo form_error('password2');
            }elseif (form_error('oldpassword') != '') {
                $errClass['oldpassword'] = 'errorInput';
                $errClass['oldpassword'] = 'errorInput';
                echo form_error('oldpassword');
            }
            elseif (form_error('email') != '') {
                $errClass['email'] = 'errorInput';
                echo form_error('email');
            }
            elseif (form_error('phone') != '') {
                $errClass['phone'] = 'errorInput';
                echo form_error('phone');
            }
            elseif (form_error('city') != '') {
                $errClass['city'] = 'errorInput';
                echo form_error('city');
            }
            elseif (form_error('address') != '') {
                $errClass['address'] = 'errorInput';
                echo form_error('address');
            } else {
                echo validation_errors();
            }

            if( isset($duplicate) && $duplicate != ''){
                echo $this->lang->line('reg_dup'.$duplicate) ;
                $errClass[$duplicate] = 'errorInput';
            }

            ?></span>
        <br>
        <?php echo form_open('/profile/update') ?>
        <label for="password" style="line-height: 30px;"><?= $this->lang->line('profile_newPass') ?>: </label>
        <input type="password" name="password" placeholder="New password" class="loginput <?= $errClass['password'] ?>" /><br><br>
        <label for="password2" style="line-height: 30px;"><?= $this->lang->line('profile_repass') ?> </label>
        <input type="password" name="password2" placeholder="New password" class="loginput <?= $errClass['password2'] ?>" /><br><br>
        <hr>
        <br>
        <label for="email" style="line-height: 30px;"><?= $this->lang->line('profile_email') ?>: </label>
        <input type="text" name="email" value="<?= $userdata->email ?>" class="loginput <?= $errClass['email'] ?>" /><br><br>
        <label for="phone" style="line-height: 30px;"><?= $this->lang->line('profile_phone') ?>: </label>
        <input type="number" name="phone" value="<?= $userdata->phone ?>" class="loginput <?= $errClass['phone'] ?>" /><br><br>
        <label for="address" style="line-height: 30px;"><?= $this->lang->line('profile_address') ?>: </label>
        <input type="text" name="address" value="<?= $userdata->address ?>" class="loginput <?= $errClass['address'] ?>" /><br><br>
        <input type="hidden" name="avatar" value="1" class="loginput"  id="avatar"/>
        <label for="city" style="line-height: 30px;"><?= $this->lang->line('profile_city') ?>: </label>
        <select name="city" class="loginput <?= $errClass['city'] ?>" style="    width: 58.4%; height: 36px;">
            <?php
                for ($i=0; $i<sizeof($cities); $i++){
                    if ($userdata->city == $cities[$i]){
                        echo '<option value="'.$cities[$i].'"'.set_select('city', $cities[$i], TRUE).'>'.$cities[$i].'</option>';
                    } else {
                        echo '<option value="'.$cities[$i].'"'.set_select('city', $cities[$i]).'>'.$cities[$i].'</option>';
                    }
                }
            ?>
        </select>
        <br><br>
        <label for="avatars" style="line-height: 65px;"><?= $this->lang->line('profile_avatar') ?>: </label>
        <div class="loginput avatarchoose" onclick="openAvatarChooser()">
            <?= $this->lang->line('profile_choose') ?>
        </div>
        <div class="chooseavatarthumb" style="background-image: url('/assets/avatars/<?= $userdata->avatar_id ?>.png')"></div>
        <br><br>
        <label for="oldpassword" style="line-height: 30px;"><?= $this->lang->line('profile_currentPass') ?>: </label>
        <input type="password" name="oldpassword" placeholder="Current password" class="loginput <?= $errClass['oldpassword'] ?>" /><br><br>
        <br>

        <br>
        <input type="submit" value="<?= $this->lang->line('profile_save') ?>" class="logsubmit" />
        </form>
        <a href="/profile/info"><button><?= $this->lang->line('profile_cancel') ?></button></a>
    </div>
</div>
<div id="avatarChooseWP">
    <?php
        for ($i = 1; $i<=$avatarCount; $i++){
            echo '<div class="avatarItem" style="background-image: url(\'/assets/avatars/'.$i.'.png\')" onclick="chooseAvatar('.$i.')"></div>';
        }
    ?>
</div>