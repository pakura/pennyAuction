/**
 * Created by Pakura on 08.10.2015.
 */


$(function() {
    $( "#profile_WP" ).draggable({ handle: "#topProfile" });
});


function showPoster(obj, img){
    clearTimeout(poster);
    var top = parseInt($(obj).offset().top) - 110;
    var left = parseInt($(obj).offset().left + 10);
    $('#poster').css({
        'top': top+'px',
        'left': left+'px',
        'background-image': 'url("/assets/uploads/'+img+'")'
    });
    $('#poster').fadeIn();
}


function closePopup(){
    $('.popupBG').fadeOut();
    $('.popup').slideToggle();
}



var poster;
function hidePoster(){
    clearTimeout(poster);
    poster = setTimeout(function(){
        $('#poster').fadeOut();
    },1000)
}
var offset = 0;
function getAuctions(){
    if (document.getElementById('check1').checked == true){
        var finished = 1;
    } else {
        var finished = 0;
    }
    var fromdate = $('#from').val();
    var todate = $('#to').val();
    $.ajax({
        type: "POST",
        url: "/admin/Auctionadmin/getAuctions",
        data: { from: fromdate, to: todate, finished: finished, offset: offset}
    })
        .done(function( msg ) {
            writeAuction(JSON.parse(msg));
        })
        .fail(function() {
            console.log('error');
        })
}
function writeAuction(auctionData) {
    clearOldTable();
    for (var ii in auctionData){
        trhtml = '<tr style="text-align: center">';
        trhtml += '<td>'+auctionData[ii].id+'</td>';
        trhtml += '<td>'+auctionData[ii].product_name+'</td>';
        trhtml += '<td>'+auctionData[ii].start_time+'</td>';
        trhtml += '<td>'+dateissnan(auctionData[ii].end_time)+'</td>';
        trhtml += '<td>'+auctionData[ii].bid_price+'</td>';
        trhtml += '<td>'+yesno(auctionData[ii].buy_now)+'</td>';
        trhtml += '<td>'+ifissnan(auctionData[ii].last_bidder_username)+'</td>';
        trhtml += '<td>'+parseFloat(auctionData[ii].price).toFixed(2)+'</td>';
        trhtml += '<td>'+yesno(auctionData[ii].payed)+'</td>';
        trhtml += '<td style="background-color: #03a87b; cursor: pointer; color: #FFF;" onclick="showMembers('+auctionData[ii].id+')">View</td>';
        trhtml += '</tr>';
        $('#table_content').append(trhtml);
    }
    $('#dataTable_'+tablecnt).DataTable({
        'iDisplayLength': 30,
        "order": [[ 0, "desc" ]]
    });
}

function showMembers(id){
    $.ajax({
        type: "POST",
        url: "/admin/Auctionadmin/getAuctionsMembers",
        data: { auctionid: id }
    })
        .done(function( msg ) {
            msg = msg.split('&');
            writeAuctionMembers(JSON.parse(msg[0]), JSON.parse(msg[1]));
            console.log(JSON.parse(msg[1]));
        })
        .fail(function() {
            console.log('error');
        })
}


function writeAuctionMembers(users, info){
    $('#membersLIST').html('');
    tablecntM++;
    tablehtmlM = tablehtmlM.replace("dataTablem_"+(tablecntM-1), "dataTablem_"+tablecntM);
    $('#membersLIST').html(tablehtmlM);
    for (var ii in users){
        trhtml = '<tr style="text-align: center">';
        trhtml += '<td onclick="getUser('+users[ii].user_id+')">'+users[ii].username+'</td>';
        trhtml += '<td>'+users[ii].bids+'</td>';
        trhtml += '<td>'+isautobidder(users[ii].limit_bids)+'</td>';
        trhtml += '<td>'+users[ii].limit_bids+'</td>';
        trhtml += '<td>'+users[ii].bids_left+'</td>';
        trhtml += '<td>'+users[ii].from_price+'</td>';
        trhtml += '<td>'+users[ii].to_price+'</td>';
        trhtml += '</tr>';
        $('#table_contentm').append(trhtml);
    }
    $('#dataTablem_'+tablecntM).DataTable({
        'iDisplayLength': 10,
        "order": [[ 1, "desc" ]]
    });
    $('.popupFooter').html('Total bids: '+info[0].total_bids+ ' | Bids: '+info[0].bids +' | Members: '+info[0].uniq+' |  Average: '+(parseInt(info[0].total_bids)*0.16).toFixed(2)+'GEL');
    $('.popupBG').fadeIn();
    $('.popup').slideDown();
}

function clearOldTable(){
    $('#auctionLIST').html('');
    tablecnt++;
    tablehtml = tablehtml.replace("dataTable_"+(tablecnt-1), "dataTable_"+tablecnt);
    $('#auctionLIST').html(tablehtml);
}


function getUsers(){
    $.ajax({
        type: "POST",
        url: "/admin/Auctionadmin/getUsers",
        data: {offset: offset}
    })
        .done(function( msg ) {
            writeUsers(JSON.parse(msg));
        })
        .fail(function() {
            console.log('error');
        })
}

function writeUsers(users){
    clearOldTable();
    for (var ii in users){
        trhtml = '<tr style="text-align: center">';
        trhtml += '<td>'+users[ii].id+'</td>';
        trhtml += '<td>'+users[ii].username+'</td>';
        trhtml += '<td>'+users[ii].firstname+' '+users[ii].lastname+'</td>';
        trhtml += '<td>'+getGender(users[ii].gender)+'</td>';
        trhtml += '<td>'+users[ii].date_of_birth+'</td>';
        trhtml += '<td>'+users[ii].id_number+'</td>';
        trhtml += '<td>'+users[ii].phone+'</td>';
        trhtml += '<td>'+users[ii].email+'</td>';
        trhtml += '<td>'+users[ii].address+'</td>';
        trhtml += '<td>'+users[ii].city+'</td>';
        trhtml += '<td>'+getverified(users[ii].verified)+'</td>';
        trhtml += '<td style="background-color: #03a87b; cursor: pointer; color: #FFF;" onclick="getUser('+users[ii].id+')">View Profile</td>';
        trhtml += '</tr>';
        $('#table_content').append(trhtml);
    }
    $('#dataTable_'+tablecnt).DataTable({
        'iDisplayLength': 30,
        "order": [[ 0, "desc" ]]
    });
}




function yesno(arg){
    if (arg == 1){
        return 'YES';
    } else {
        return 'NO';
    }
}
function ifissnan(arg){
    if (arg == null){
        return '<span style="color:indianred;">-</span>'
    } else {
        return arg;
    }
}

function dateissnan(arg){
    if (arg == null){
        return '<span style="color:seagreen;">running</span>'
    } else {
        return arg;
    }
}

function getGender(arg){
    if (arg == 0){
        return 'Male';
    } else {
        return 'Female';
    }
}

function getverified(arg){
    if (arg == 1){
        return '<span style="color: #03a87b">YES</span>';
    } else {
        return '<span style="color:orangered;">NO</span>';
    }
}

function isautobidder(arg){
    if (arg == null){
        return '<span style="">No</span>'
    } else {
        return '<span style="color: mediumseagreen;">YES</span>'
    }
}