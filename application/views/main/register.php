<div class="page_content" style="padding-top: 20px">

    <div class="login_WP_page">
        <h3><?= $this->lang->line('reg_singin') ?></h3>
        <?= $this->lang->line('reg_singin') ?>
        <?php echo form_open('main/login') ?>
            <?php
                if( isset($_POST['submit_login']) )
                    echo validation_errors();
            ?>
            <br>
            <input type="text" class="loginput" placeholder="<?= $this->lang->line('reg_username') ?>" name="username" required/><br><br>
            <input type="password" class="loginput" placeholder="<?= $this->lang->line('reg_password') ?>" name="password" required/><br><br>
            <input type="checkbox" checked name="remember"/> <label for="remember"> <?= $this->lang->line('reg_login') ?></label>
            <input type="submit" class="logsubmit" value="შესვლა" name="submit_login"/>
        </form>
        <a href="/facebook/login"> <img src="/assets/imgs/login_fb.png" style="width: 135px; margin-top: 27px;"></a>
    </div>

    <div class="register_WP_page">
        <h3><?= $this->lang->line('reg_register') ?></h3>
        <?= $this->lang->line('reg_regtext') ?>
        <br><span style="color: #E77885">
            <?php
            $errClass = [
                'username'=>'',
                'password'=>'',
                'password2'=>'',
                'firstname'=>'',
                'lastname'=>'',
                'email'=>'',
                'date_of_birth'=>'',
                'id_number'=>'',
                'phone'=>'',
                'city'=>'',
                'address'=>''
            ];
            if( isset($_POST['submit_register']) ) {
                $onceError = 0;
                if (form_error('username') != '') {
                    $errClass['username'] = 'errorInput';
                    echo form_error('username');
                } elseif (form_error('password') != '') {
                    $errClass['password'] = 'errorInput';
                    $errClass['password2'] = 'errorInput';
                    echo form_error('password');
                }
                elseif (form_error('password2') != '') {
                    $errClass['password2'] = 'errorInput';
                    $errClass['password'] = 'errorInput';
                    echo form_error('password2');
                }
                elseif (form_error('firstname') != '') {
                    $errClass['firstname'] = 'errorInput';
                    echo form_error('firstname');
                }
                elseif (form_error('lastname') != '') {
                    $errClass['lastname'] = 'errorInput';
                    echo form_error('lastname');
                }
                elseif (form_error('email') != '') {
                    $errClass['email'] = 'errorInput';
                    echo form_error('email');
                }
                elseif (form_error('date_of_birth') != '') {
                    $errClass['date_of_birth'] = 'errorInput';
                    echo form_error('date_of_birth');
                }
                elseif (form_error('id_number') != '') {
                    $errClass['id_number'] = 'errorInput';
                    echo form_error('id_number');
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
            }

            function getDefault($defaults,$field){
                if( isset($defaults[$field]) ){
                    return $defaults[$field];
                }else{
                    return '';
                }
            };

            ?>
            </span>

        <?php echo form_open('register') ?>
<br>
            <div class="lsection">
                <div class="singleItem">
                    <input type="text" class="loginput <?= $errClass['username'] ?>" name="username" value="<?= set_value('username') ?>"
                           placeholder="<?= $this->lang->line('reg_username') ?>" tabindex="1" />
                </div>
                <div class="singleItem">
                    <input type="password" class="loginput <?= $errClass['password'] ?>" name="password"
                           placeholder="<?= $this->lang->line('reg_password') ?>" required tabindex="2"/>
                </div>
                <div class="singleItem">
                    <input type="password" class="loginput <?= $errClass['password2'] ?>" name="password2"
                           placeholder="<?= $this->lang->line('reg_rpt_password') ?>" tabindex="3" />
                </div>
                <div class="singleItem">
                    <input type="text" class="loginput <?= $errClass['firstname'] ?>" name="firstname" value="<?= set_value('firstname') | getDefault($defaults,'first_name')  ?>"
                           placeholder="<?= $this->lang->line('reg_firstname') ?>" tabindex="4" />
                </div>
                <div class="singleItem">
                    <input type="text" class="loginput <?= $errClass['lastname'] ?>" name="lastname" value="<?= getDefault($defaults,'last_name') | set_value('lastname')  ?>"
                           placeholder="<?= $this->lang->line('reg_lastname') ?>" tabindex="5" />
                </div>
                <div class="singleItem">
                    <input type="text" class="loginput <?= $errClass['email'] ?>" name="email" value="<?= getDefault($defaults,'email') | set_value('email')  ?>"
                           placeholder="<?= $this->lang->line('reg_email') ?>" tabindex="6"/>
                </div>
                <div class="singleItem" style="height: 50px">
                    <div class="radiotext mobilehide "> <?= $this->lang->line('reg_gender') ?>:</div>
                    <div class="radio noselect" onclick="changeGender()">
                        <div class="radioSelector"></div>
                        <div class="radio1"><?= $this->lang->line('reg_gender_male') ?></div>
                        <div class="radio2"><?= $this->lang->line('reg_gender_female') ?></div>
                    </div>

                    <input type="radio" class="radioinput" name="gender" value="0" <?= set_radio('gender', '0', TRUE) ?> style="display: none"/>
                    <input type="radio" class="radioinput" name="gender" value="1" <?= set_radio('gender', '1') ?> style="display: none" />
                </div>
            </div>
            <div class="rsection">
                <div class="singleItem">
                    <input type="date" class="loginput <?= $errClass['date_of_birth'] ?>" name="date_of_birth" value="<?= set_value('date_of_birth') ?>"
                           placeholder="<?= $this->lang->line('reg_date_of_birth') ?>"  tabindex="7" />
                </div>
                <div class="singleItem">
                    <input type="number" class="loginput <?= $errClass['id_number'] ?>" name="id_number" value="<?= set_value('id_number') ?>"
                           placeholder="<?= $this->lang->line('reg_id_number') ?>"  tabindex="8"/>
                </div>
                <div class="singleItem">
                    <input type="number" class="loginput <?= $errClass['phone'] ?>" name="phone" value="<?= set_value('phone') | getDefault($defaults,'phone')  ?>"
                           placeholder="<?= $this->lang->line('reg_phone') ?>"  tabindex="9"/>
                </div>
                <div class="singleItem">
                    <select class="loginput <?= $errClass['city'] ?>" name="city" style="width: 93%"  tabindex="10">
                        <?php
                        for ($i=0; $i<sizeof($cities); $i++){
                            if ($i == 0){
                                echo '<option value="'.$cities[$i].'"'.set_select('city', $cities[$i], TRUE).'>'.$cities[$i].'</option>';
                            } else {
                                echo '<option value="'.$cities[$i].'"'.set_select('city', $cities[$i]).'>'.$cities[$i].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="singleItem">
                    <input type="text" class="loginput <?= $errClass['address'] ?>" name="address" value="<?= set_value('address') ?>"
                           placeholder="<?= $this->lang->line('reg_address') ?>" tabindex="11"/>
                </div>
                <div class="singleItem" style="height: 100px">
                    <div class="g-recaptcha" data-sitekey="6Ldu3w0TAAAAAARK8zEGaQAc2K2Lp5WC5lboD-8m"></div>
                </div>
                <div class="singleItem" style="height: 100px">
                    <input type="checkbox" id="termsNcondition" required> <label style="font-size: 12px" for="termsNcondition"
                                         class="tersagree"><?= $this->lang->line('reg_agree') ?></label>
                </div>
                <div class="singleItem">
                    <input type="submit" class="logsubmit" name="submit_register" value="<?= $this->lang->line('reg_register') ?>" />
                </div>

            </div>
    </form>

    </div>
</div>
<script src='https://www.google.com/recaptcha/api.js'></script>