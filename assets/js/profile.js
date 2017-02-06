/**
 * Created by Pakura on 15.10.2015.
 */
var profile;
function getUser(id){
    id = parseInt(id);
    if (id < 0){
        return;
    }
    profile = id;
    $.ajax({
        type: "POST",
        url: "/admin/Auctionadmin/getProfile",
        data: { sec: 'info', userid: id }
    })
        .done(function( msg ) {
            writeProfileInfo(JSON.parse(msg));
        })
        .fail(function() {
            console.log('error');
        })
}

function writeProfileInfo(data){
    data = data[0];
    $('#Username').html(data.username);
    $('#prouserId').html('#'+data.id);
    $('#proname').html(data.firstname +' '+data.lastname);
    $('#proaddress').html(data.city +' '+data.address);
    $('#prophone').html(data.phone);
    $('#proemail').html(data.email);
    $('#propid').html(data.id_number);
    $('#probids').html(data.bids);
    $('#avatar').css({'background-image': 'url("/assets/avatars/'+data.avatar_id+'.png")'});
    $('#Sname').val(data.lastname);
    $('#name').val(data.firstname);
    $('#address').val(data.address);
    $('#phone').val(data.phone);
    $('#email').val(data.email);
    $('#birth').val(data.date_of_birth);
    $('#pid').val(data.id_number);
    if (data.verified == '1'){
        document.getElementById('verified').checked = true;
    } else {
        document.getElementById('verified').checked = false;
    }
    $('#bids').val(data.bids);
    $('#profile_WP').fadeIn();
    $('#city option').each(function(){
        if (data.city == $(this).text()){
            $(this).attr('selected','selected');
        }
    });
    clearSections();
    document.getElementsByClassName('contentItemPro')[0].style.display = 'block';
}


function changeSection(section){
    clearSections();
    switch (section){
        case 0:
            getUser(profile);
            break;
        case 1:
            getTransaction();
            break;
        default:
            return
    }
}

function clearSections(){
    document.getElementsByClassName('contentItemPro')[0].style.display = 'none';
    document.getElementsByClassName('contentItemPro')[1].style.display = 'none';
    document.getElementsByClassName('contentItemPro')[2].style.display = 'none';
    document.getElementsByClassName('contentItemPro')[3].style.display = 'none';
    document.getElementsByClassName('contentItemPro')[4].style.display = 'none';
}


function sendupdateInfo(){
    var r = confirm("Do you really want to update following data?");
    if (r == true) {
        var name = $('#name').val();
        var sname = $('#Sname').val();
        var address = $('#address').val();
        var city = $('#city').val();
        var phone = $('#phone').val();
        var email = $('#email').val();
        var dateofbirth = $('#birth').val();
        var personalid = $('#pid').val();
        var verified = 0;
        if($('#verified').is(':checked')){
            verified = 1;
        }
        $.ajax({
            type: "POST",
            url: "/admin/Auctionadmin/updateInfo",
            data: { sec: 'update', userid: profile, name: name, sname: sname, address: address, city: city, phone: phone, email: email, dateofbirth: dateofbirth, personalid: personalid, verified: verified}
        })
        .done(function( msg ) {
            alert(msg);
        })
    }
}

function sendupdateBids(){
    var r = confirm("Do you really want to update bids amount?");
    if (r == true) {
        var bids = $('#bids').val();
        $.ajax({
            type: "POST",
            url: "/admin/Auctionadmin/updatebids",
            data: { sec: 'updatebids', userid: profile, bids: bids}
        })
            .done(function( msg ) {
                alert(msg);
            })
    }
}


function getTransaction(){
    $.ajax({
        type: "POST",
        url: "/admin/Auctionadmin/getProTransaction",
        data: { sec: 'profiletransaction', userid: profile}
    })
        .done(function( msg ) {
            writeProfileTransaction(JSON.parse(msg));
        })
}

function writeProfileTransaction(trns){
    $('#transSection').html('');
    for (var ii in trns){
        var html = '<div class="transProItem">';
            if (trns[ii].package_id == '0'){
                html += '<div class="package" title="'+trns[ii].url_title+'">'+trns[ii].auction_id+'</div>';
            } else {
                html += '<div class="package">Bids package '+trns[ii].package_id+'</div>';
            }

            html += '<div class="amount">'+parseFloat(trns[ii].amount).toFixed(2)+'<lari>l</lari></div>';
            html += '<div class="autodate">'+trns[ii].payment_date+'</div>';
            if (trns[ii].confirmed == 1){
                html += '<div class="confirmed">YES</div>';
            } else {
                html += '<div class="confirmed">NO</div>';
            }

            html += '</div>';
        $('#transSection').append(html);
    }
    document.getElementsByClassName('contentItemPro')[1].style.display = 'block';
}