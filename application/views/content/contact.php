
<div class="staticContainer">
    <div class="headSlide">
        <div class="faqicon">
            <img src="/assets/imgs/contacticon.png">
        </div>
    </div>
    <div class="lSide">
        <div class="contactinfo">
            <h1><?= $this->lang->line('reg_contactInfo') ?></h1>
            <span>Rustaveli AVENUE #1<br>+995 555 207<br>+995 322 445566</span>
        </div>
        <div class="map" id="map"></div>
    </div>
    <div class="rSide">
        <?php
            if( !isset($userdata) ) {
                $userdata = new stdClass();
                $userdata->username = '';
                $userdata->email = '';
            }
            $errClass = [
                'name'=>'',
                'email'=>'',
                'subject'=>'',
                'message'=>''
            ];
            $errormsg = '';

            if (form_error('name') != '') {
                $errClass['name'] = 'errorInput';
                $errormsg = form_error('name');
            }
            elseif (form_error('email') != '') {
                $errClass['email'] = 'errorInput';
                $errormsg = form_error('email');
            }
            elseif (form_error('subject') != '') {
                $errClass['subject'] = 'errorInput';
                $errormsg = form_error('subject');
            } elseif (form_error('message') != ''){
                $errClass['message'] = 'message';
                $errormsg = form_error('message');
            }else if (isset($captcha)){
                if( !$captcha ){
                    $errormsg = $this->lang->line('reg_dupcaptcha');
                }
            } else {
                $errormsg = validation_errors();
            }
            ?>
        <?php echo form_open('/main/contact') ?>
        <input type="text" class="<?= $errClass['name'] ?>" name="name" placeholder="<?= $this->lang->line('reg_firstname') ?>" id="name" value="<?= set_value('name') | $userdata->username ?>"  />
        <div class="mobileshow tabletshow"><br></div>
        <input type="email" class="<?= $errClass['email'] ?>"  name="email" placeholder="e-mail" id="email" value="<?= set_value('email') | $userdata->email ?>" /><br>
        <br>
        <input type="text" class="<?= $errClass['subject'] ?>"  placeholder="<?= $this->lang->line('reg_topic') ?>" name="subject" style="width: 95%" value="<?= set_value('subject') ?>" id="title"/>
        <br><br>
        <textarea name="message" class="<?= $errClass['message'] ?>" ><?= set_value('message') ?></textarea>
        <br><br>
        <div class="errorMess">
            <?php
                if ($sent){
                    echo "<span style='color: #0F9E5E'>".$this->lang->line('reg_sent')."</span>";
                }
                echo $errormsg;
            ?>
        </div>

        <input type="submit" value="<?= $this->lang->line('reg_send') ?>" >
        <div style="float: right; margin-right: 2px"><div class="g-recaptcha" data-sitekey="6Ldu3w0TAAAAAARK8zEGaQAc2K2Lp5WC5lboD-8m"></div></div>
        </form>
    </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCLPcMii1KokyoKUBPzm9yTG9oyO4iIe4s" type="text/javascript"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script>

    var labels = '';
    var labelIndex = 0;

    function initialize() {
        var bangalore = { lat: 41.701491, lng: 44.797176 };
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: bangalore
        });

        // This event listener calls addMarker() when the map is clicked.
        google.maps.event.addListener(map, 'click', function(event) {
            addMarker(event.latLng, map);
        });

        // Add a marker at the center of the map.
        addMarker(bangalore, map);
    }

    // Adds a marker to the map.
    function addMarker(location, map) {
        // Add the marker at the clicked location, and add the next-available label
        // from the array of alphabetical characters.
        var marker = new google.maps.Marker({
            position: location,
            label: labels[labelIndex++ % labels.length],
            map: map,
            icon: '/assets/imgs/marker.png'
        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);

</script>