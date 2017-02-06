<a href="/admin/admin/listproducts" ><div style="background-image: url('/assets/imgs/product.png')" class="item hvr-underline-from-center">Products</div></a>
<a href="/admin/admin/listauctions" ><div style="background-image: url('/assets/imgs/auction.png')" class="item hvr-underline-from-center">Auctions</div></a>
<a href="/admin/admin/userslist" ><div style="background-image: url('/assets/imgs/users.png')" class="item hvr-underline-from-center">Users</div></a>



<div id="profile_WP">
    <div id="topProfile">
        <span id="Username">Pakura</span>
        <div class="close hvr-grow" onclick="$('#profile_WP').fadeOut()"></div>
    </div>
    <div id="infoWP">
        <div id="avatar"></div>
        <div id="detail">
            <div class="itempro">User ID: <span id="prouserId">#</span></div>
            <div class="itempro">Full name: <span id="proname"></span></div>
            <div class="itempro">Address: <span id="proaddress" style="font-size: 10px"></span></div>
            <div class="itempro">Phone: <span id="prophone"></span></div>
            <div class="itempro">Email: <span id="proemail"></span></div>
            <div class="itempro">Personal ID: <span id="propid"></span></div>
            <div class="itempro" style="border: none">Bids: <span id="probids"></span></div>
        </div>
    </div>
    <div id="switchBTN">
        <div class="sbtn" onclick="changeSection(0)">Info</div>
        <div class="sbtn" onclick="changeSection(1)">Trans</div>
        <div class="sbtn" onclick="changeSection(2)">history</div>
        <div class="sbtn" onclick="changeSection(3)">Setting</div>
        <div class="sbtn" style="margin:0px;" onclick="changeSection(4)">Contact</div>
    </div>
    <div class="contentPro">
        <div class="contentItemPro" id="infoSection">
            <label for="name">Full name:</label> <input type="text" id="Sname" placeholder="Surname"> <input type="text" id="name" style="margin-right: 6px" placeholder="Name">
            <br><br>
            <label for="address">Address:</label>
            <select id="city" style="width: 107px; height: 26px;">
                <?php
                for ($i=0; $i<sizeof($cities); $i++){
                    if ($i == 0){
                        echo '<option value="'.$cities[$i].'">'.$cities[$i].'</option>';
                    } else {
                        echo '<option value="'.$cities[$i].'">'.$cities[$i].'</option>';
                    }
                }
                ?>
            </select>
            <input type="text" id="address" placeholder="address" style="margin-right: 6px">
            <br><br>
            <label for="phone">Phone:</label>
            <input type="number" id="phone" placeholder="Phone" style="width: 213px">
            <br><br>
            <label for="email">Email:</label>
            <input type="email" id="email" placeholder="Email" style="width: 213px">
            <br><br>
            <label for="birth">Date of birth:</label>
            <input type="date" id="birth" style="width: 213px">
            <br><br>
            <label for="pid">Personal ID:</label>
            <input type="number" id="pid" style="width: 213px">
            <br><br>
            <label for="verified">Verfied:</label>
            <input type="checkbox" id="verified" style="width: 20px" value="1">
            <br><br>
            <button style="width: 100%; height: 32px;" onclick="sendupdateInfo()">Update</button>
            <hr>
            <label for="bids">Bids:</label>
            <input type="number" id="bids" style="width: 213px">
            <br><br>
            <button style="width: 100%; height: 32px;" onclick="sendupdateBids()">Update</button>
        </div>

        <div class="contentItemPro" id="transSection">

        </div>

        <div class="contentItemPro" id="historySection">

        </div>

        <div class="contentItemPro" id="settingSection">

        </div>

        <div class="contentItemPro" id="contactSection">

        </div>
    </div>
</div>