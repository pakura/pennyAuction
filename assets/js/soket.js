/**
 * Created by Pakura on 11.09.2015.
 */
var countdown;
var connection =false;
var initautobid = false;
var firstUpdate = true;
var timeleft = {};
var oldtime = new Date().getTime();
var newtime;
$(function() {
    initCoutnDown();
    connect();
});
var websocket;
var curMsg = '';
function connect(){
    if (websocket){
        if (websocket.readyState == WebSocket.OPEN || websocket.readyState == WebSocket.CONNECTING){
            websocket.close();
        }
    }
    websocket = new WebSocket( window.config.wssUrl );
    websocket.onerror = onerror_g;
    websocket.onopen = onopen_g;
    websocket.onmessage = onmessage_g;
}


function onerror_g(evt){
    Conn = setTimeout(connect(), 2000);
    console.log("Connection error");
}
var t1 = new Date().getTime();
function onopen_g(evt){
    connection = true;
    if (loggedin == true){
        websocket.send('61,'+userID+',0,'+sesID+'\n');
        websocket.send('105,1\n');
    }
    if (typeof auctionID != 'undefined'){
        websocket.send('72,'+auctionID+',1\n');
    }
    subscribeAuction();
    subscribeMybidsleft();
    if (typeof auctionID != 'undefined') {
        websocket.send('103,' + auctionID + '\n');
    }
    window.setInterval(function(){
        websocket.send('2\n');
    },7000);
} //init first message

function onmessage_g(evt){
    curMsg += evt.data;
    if ( curMsg.indexOf('\r\n') === -1 ) return;
    var Data = curMsg.split('\r\n');
    curMsg = Data[ Data.length - 1 ];
    var msg = [];
    for (var i=0; i<Data.length-1; i++){
        msg = Data[i].split(',');
    }
    console.log(msg);
    initMessage(msg);

} //message event


function initMessage(arg){
    switch (arg[0]){
        case '98':
            newUpdate(arg);
            break;
        case '90':
            showError(arg);
            checkAutoBidAction();
            break;
        case '102':
            changeLeftBids(arg);
            break;
        case '104':
            showMyBidsCNT(arg);
            break;
    }
}


function bid(id){
    if (typeof userID == 'undefined'){
        $(document).scrollTop(0);
        openLoginWP();
    }else{
        websocket.send('99,'+id+'\n');
        if (parseInt($('#bids_cnt').html()) > 0) {
            //$('#bids_cnt').html(parseInt($('#bids_cnt').html()) - 1);
            getBuyItNewPrice();
        }
    }
}


function showMyBidsCNT(arg){
    $('#bids_cnt').html(arg[1]);
}

function initCoutnDown(){
    oldtime = new Date().getTime();
    countdown = window.setInterval(function () {
        countDown();
    },500)
}

function forceLogin(){

}

function setTime( auctionId, hourEl, minuteEl, secondEl ){
    var elap = new Date().getTime() - oldtime;
    timeleft[ auctionId ] -= elap;
    var t = (timeleft[auctionId] / 1000) | 0;
    var hour = ( t / 3600 ) | 0;
    var minute = ( t % 3600 / 60 ) | 0;
    var second = ( (t % 3600) % 60 ) | 0;
    hourEl.innerHTML =  correctTime( hour );
    minuteEl.innerHTML = correctTime( minute );
    secondEl.innerHTML = correctTime( second );
}

function countDown(){
    if( window.auctionID !== undefined ){
        var hour = document.getElementsByClassName('blocks')[0];
        var minute = document.getElementsByClassName('blocks')[1];
        var second = document.getElementsByClassName('blocks')[2];
        setTime( auctionID, hour, minute, second );
    }else{
        for (var ii = 0; ii<document.getElementsByClassName('countdown_wp').length; ii++) {
            var element = document.getElementsByClassName('countdown_wp')[ii].children;
            var hour = element[0];
            var minute = element[2];
            var second = element[4];
            var auctionId = document.getElementsByClassName('SingleItem_WP')[ii].id.split('_')[1];
            setTime( auctionId*1 , hour, minute, second );
        }
    }
    oldtime = new Date().getTime();
}


function correctTime(arg){
    if( arg < 0 ){
        arg = 0;
    }
    arg = arg+'';
    if (arg.length < 2){
        return '0'+arg;
    } else {
        return arg;
    }
}

function subscribeAuction(){
    for (var ii = 0; ii<document.getElementsByClassName('activeAuctionss').length; ii++){
        var auction_ID = document.getElementsByClassName('activeAuctionss')[ii].id.split('_')[1];
        websocket.send('72,'+auction_ID+',1\n');
        var element = document.getElementsByClassName('countdown_wp')[ii].children;
        var hour = element[0];
        var minute = element[2];
        var second = element[4];
        timeleft[ auction_ID ] = hour.innerHTML * 3600 + minute.innerHTML * 60 + second.innerHTML * 1;
        if( timeleft[ auction_ID ] < 350 ){
            websocket.send('103,' + auction_ID + '\n');
        }
        timeleft[ auction_ID ] *= 1000;

    }
}
function newUpdate(argumnt){
    var auctionId = argumnt[1];
    //var diff = new Date().getTime() - argumnt[6];
    //console.log(diff);
    timeleft[ auctionId ] = argumnt[4];
    if (document.getElementsByClassName('SingleItem_WP').length > 0){
        updateItemFromList(argumnt);
    } else {
        updateFullPageItem(argumnt);
        bidHistory(argumnt);
    }

    if( !firstUpdate ){

    }else{
        firstUpdate = false;
    }
    if (parseInt(argumnt[4]) == -1){
        endAuction(argumnt);
    }

}

function updateFullPageItem(argument){
    if (argument[3] == 'null'){
        return;
    }
    clearInterval(countdown);
    $('.cost:first').find('span').html(argument[2]+'<lari>l</lari>');
    $('#liveprice').html(parseFloat(argument[2]).toFixed(2)+'<lari>l</lari>');
    $('.lastBidder').find('span').html(argument[3]);
    $("#avatar").attr("src","/assets/avatars/"+argument[5]+".png");
    if (parseInt(argument[4]) != -1) {
        setTime(
            argument[1],
            document.getElementsByClassName('blocks')[0],
            document.getElementsByClassName('blocks')[1],
            document.getElementsByClassName('blocks')[2]
        );
        //document.getElementsByClassName('blocks')[0].innerHTML = secToMyTime('H', argument[4]);
        //document.getElementsByClassName('blocks')[1].innerHTML = secToMyTime('M', argument[4]);
        //document.getElementsByClassName('blocks')[2].innerHTML = secToMyTime('S', argument[4]);
        initCoutnDown();
    }
    if (parseInt(argument[4])<=reset_time) {
        $('.blocks').addClass('blink');
        $('.blocks').css({'border': '2px solid #108BBE'});
        setTimeout(function () {
            $('.blocks').removeClass('blink');
            $('.blocks').css({'border': '2px solid #E6E6E6'});
        }, 1000);
    }
}


function updateItemFromList(argument){
    $('#auctionID_'+argument[1]).find('.cost').find('span').html(argument[2]+'<lari>l</lari>');
    $('#auctionID_'+argument[1]).find('.lastBidder').html(argument[3]);
    var element = document.getElementById('auctionID_'+argument[1]);
    if (parseInt(argument[4]) != -1){
        setTime(
            argument[1],
            element.getElementsByClassName('blocks')[0],
            element.getElementsByClassName('blocks')[1],
            element.getElementsByClassName('blocks')[2]
        );
        //.innerHTML = secToMyTime('H', argument[4]);
        //.innerHTML = secToMyTime('M', argument[4]);
        //.innerHTML = secToMyTime('S', argument[4]);
    }
    if (parseInt(argument[4])<=15) {
        $('#auctionID_'+argument[1]).find('.blocks').addClass('blink');
        $('#auctionID_'+argument[1]).find('.blocks').css({'border': '2px solid #108BBE'});
        setTimeout(function () {
            $('#auctionID_'+argument[1]).find('.blocks').removeClass('blink');
            $('#auctionID_'+argument[1]).find('.blocks').css({'border': '2px solid #E6E6E6'});
        }, 1000);
    }
}
var buynowTime;

function sendAutoBidderOption(){
    if (autobid == true){
        stopAutoBid();
        return;
    }
    if (typeof userID == 'undefined'){
        $(document).scrollTop(0);
        openLoginWP();
        return;
    }
    var startat = parseInt($('#tillvalue').val());
    var stopvalue = parseFloat($('#stopvalue').val());
    var bidsvalue = parseInt($('#bidsvalue').val());
    if (startat == '' || isNaN(parseInt($('#tillvalue').val()))){
        startat = 0;
    }
    if (stopvalue == '' || isNaN(parseInt($('#stopvalue').val()))){
        stopvalue = 999999;
    }
    if (bidsvalue == '' || isNaN(parseInt($('#bidsvalue').val()))){
        document.getElementById('bidsvalue').style.border = '1px solid #E14F4F';
        return;
    }
    startAutoBid(startat, stopvalue, bidsvalue);
}

function secToMyTime(timeFormat, second){
    switch (timeFormat){
        case 'H':
            var hour = parseInt(second / 3600);
            if ((hour+'').length < 2){
                return '0'+hour;
            } else {
                return hour;
            }
            break;
        case 'M':
            var minute = parseInt(second % 3600 / 60);
            if ((parseInt(minute)+'').length < 2){
                return '0'+parseInt(minute);
            } else {
                return parseInt(minute);;
            }
            break;
        default:
            second = parseInt(second % 3600 % 60);
            if ((parseInt(second)+'').length < 2){
            return '0'+parseInt(second);
        } else {
            return parseInt(second);
        }
            break;
    }
}
function bidHistory(arg){
    if (parseFloat(arg[2]).toFixed(2) == lastPrice || parseFloat(arg[2])== 0){
        return
    }  else {
        lastPrice = parseFloat(arg[2]);
    }
    if (parseInt(arg[4])>0){
        var div = '<div class="item history_item">\
        <div class="block1">'+arg[3]+'</div>\
        <div class="block2">'+parseFloat(arg[2]).toFixed(2)+'</div>\
        </div>';
        $('#bidHistory').prepend(div);
        clearOldHistory();
    }
}


function clearOldHistory(){
    for (var ii = 19; ii<document.getElementsByClassName('history_item').length; ii++){
        document.getElementsByClassName('history_item')[ii].remove();
    }
}

function clearInitAutoBid(){
    setTimeout(function(){
        initautobid = false;
    },2000)
}

function checkAutoBidAction(){
    if (initautobid === true){
        stopAutoBid();
    }
}

function stopAutoBid(arg){
    autobid = false;
    initautobid = false;
    $('#autoBidBTN').removeClass('activeautoBid');
    $('#autoBidBTN').addClass('deactiveAutoBid');
    $('#autoBidBTN').html(startautobid);
    if (arg != 0){
        websocket.send('100,'+auctionID+',0,999999,0\n');
    }
    $('.leftBidsCNT').css({opacity: 0});
    clearInterval(buynowTime);
}

function startAutoBid(startat, stopvalue, bidsvalue){
    document.getElementById('bidsvalue').style.border = 'none';
    autobid = true;
    initautobid = true;
    $('#autoBidBTN').addClass('activeautoBid');
    $('#autoBidBTN').removeClass('deactiveAutoBid');
    $('#autoBidBTN').html(stopautobid);
    clearInitAutoBid();
    $('.leftBidsCNT').css({opacity: 1});
    $('#bidsCoutn').html(bidsvalue);
    websocket.send('100,'+auctionID+','+startat+','+stopvalue+','+bidsvalue+'\n');
    buynowTime = setInterval(function(){
        getBuyItNewPrice();
    },10000)
}

function subscribeMybidsleft(){
    if (typeof auctionID != 'undefined') {
        websocket.send('101,' + auctionID + ',1\n');
    }
}

function changeLeftBids(arg){
    if ($('#bidsCoutn').length > 0){
        if (auctionID == arg[1]){
            if (parseInt(arg[2]) > 0) {
                $('.leftBidsCNT').css({opacity: 1});
                $('#bidsCoutn').html(arg[2]);
            } else {
                stopAutoBid();
                $('.leftBidsCNT').css({opacity: 0});
            }
        }
    }
}

function endAuction(data){
    if (username == data[3]){
        var temp = [98, 12];
        showError(temp);
    }
    if (typeof auctionID != 'undefined'){
        $('.tilltext').html(endAuctionT);
        $('.tilltext').addClass('endclass');
        document.getElementsByClassName('countdown_wp')[0].style.display = 'none';
        $('.lastprice').fadeIn();
        $('.lastprice').find('span').html(data[2]);
        $('.winnerWP').fadeIn();
        $('.winnerWP').find('span').html(data[3]);
        $('.Cost_WP').css({'opacity':0.5});
        document.getElementsByClassName('lastBidder')[0].style.display = 'none';
        stopAutoBid(0);
        $('#autoBidBTN').addClass('finishedAutobidder');
    } else {
        $('#auctionID_'+data[1]).css({'box-shadow':'0 0 15px -1px #108BBE'});
        $('#auctionID_'+data[1]).find('.blocks').css({'border':'2px solid #108BBE'});
        setTimeout(function () {
            transferToBought(data[1]);
        },10000);
    }
}

function transferToBought(obj){
    $('#auctionID_'+obj).fadeOut('slow');
    $('.endAuction').find('.content').find('.SingleItem_WP').last().remove();
    $('.endAuction').find('.content').prepend($('#auctionID_'+obj).clone());
}

function showError(data){
    $('.errorBlock').slideDown();
    $('.errorBlock').html(errorarr[data[1]]);
    $(document).scrollTop(0);
    setTimeout(function () {
        $('.errorBlock').fadeOut();
    },5000)
}

function getBuyItNewPrice(){
    if (typeof auctionID != 'undefined') {
        $.ajax({
            type: "POST",
            url: "/auctions/buynowprice/"+auctionID+'/?update='+Math.random(),
            //data: {data: filter, section: 'deposit'}
        })
            .done(function (msg) {
                console.log(msg);
                $('#buyitnow').html(parseFloat(msg).toFixed(2)+'<lari>l</lari>');
            })
            .fail(function () {
                console.log('error');
            })
    }
}