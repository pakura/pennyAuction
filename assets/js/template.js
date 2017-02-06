/**
 * Created by Pakura on 02.09.2015.
 */

//@TODO use css 3

$(function() {
    //initMobileMenu();
    initCarusel();


    $('#searchInput').keypress(function (e) {
        var key = e.which;
        if(key == 13)  // the enter key code
        {
            location.href = "/main/search/"+$('#searchInput').val();
            return false;
        }
    });


});
var menuopen = false;
var catmenu = false;
var profileMenu = false;
function openMobileMenu(){
    if (menuopen == false) {
        menuopen = true;
        $('.popupBG').fadeToggle();
        $('.rMenu').fadeIn('1');
        $(".rMenu").animate({
            right: "0"
        }, 500);

    } else {
        menuopen = false;
        popupclose();
    }
}
function closeMobileMenu(){
    menuopen = false;

    $( ".rMenu" ).animate({
        right: "-230px"
    }, 500, function(){
        $('.rMenu').fadeOut();
    });
}

function popupclose(){
    closeMobileMenu();
    closeScreen();
    closeAvatar();
    $('.login_WP').fadeOut();
    $('.popupBG').fadeOut();
    $('.popuptraBG').fadeOut();
}

function showProfMenu(){
    $('.profie_dropDown').slideToggle('200');
    if (profileMenu == false){
        profileMenu = true;
        $( "#drowIcon" ).removeClass( "out" ).addClass( "over" );
    } else {
        profileMenu = false;
        $( "#drowIcon" ).removeClass( "over" ).addClass( "out" );
    }
}


function changeScreen(url, obj){
    $('#poster').fadeOut(function(){
        $("#poster").attr("src","/assets/uploads/"+url);

        $('.screen').css({'border': '1px solid #ebebeb'});
        obj.style.border = '1px solid #EE6700';
        $('#poster').fadeIn('slow');
    })
}

function initCarusel(){
    if (document.getElementsByClassName('screen').length < 5){
        $('.leftScreen').fadeOut();
        $('.rightScreen').fadeOut();
    }
}
var pos = 0;
function changeCarusel(dir){
    var maxpixel = ($('.screen').length - 3) * $('.screen').width() * -1;
    if (dir == 1){
        if (maxpixel > pos){
            return;
        }
        var param = '-=90';
        pos -= 90;
    } else {
        if (pos > -50){
            $('.screensItem').animate({
                left: 0
            },200);
            pos = 0;
            return;
        }
        var param = '+=90';
        pos +=90;
    }
    $('.screensItem').animate({
        left: param
    },200);
}
var tpos = 0;
function changeTopCarusel(dir){
    var maxpixel = ($('.screen').length - 4) * $('.screen').height() * -1;
    if (dir == 1){
        if (maxpixel > tpos){
            return;
        }
        tpos -= 85;
        var param = '-=85';
    } else {
        if (tpos > -50){
            $('.screensItem').animate({
                top: 0
            },200);
            tpos = 0;
            return;
        }
        var param = '+=85';
        tpos += 85;
    }
    $('.screensItem').animate({
        top: param
    },200);
}

function closeScreen(){
    $('.popupscreens').fadeOut();
}
function showScreen(src, bool){
    $( ".dragimg" ).draggable({ })
    if ($(document).width() < 1024 || bool == true){
        $('.popupBG').fadeIn();
        $("#thisScreen").attr("src", src);
        $('.popupscreens').fadeIn();
    }
}

function changeDesc(arg){
    if (arg == 1){
        $('#descriptionBTN').addClass('active');
        $('#specificationBTN').removeClass('active');
        document.getElementsByClassName('spec_cont')[0].style.display = 'none';
        document.getElementsByClassName('description_cont')[0].style.display = 'block';
    } else {
        $('#descriptionBTN').removeClass('active');
        $('#specificationBTN').addClass('active');
        document.getElementsByClassName('spec_cont')[0].style.display = 'block';
        document.getElementsByClassName('description_cont')[0].style.display = 'none';
    }
}

function selectAutobid(){
    $('.autoBidGear').addClass('border-anime');
    setTimeout(function () {
        $('.autoBidGear').removeClass('border-anime');
    },5000)
    $('html,body').animate({
        scrollTop: $(".autoBidGear").offset().top
    });
}


function openLoginWP(){
    $('.popuptraBG').fadeIn();
    $('.login_WP').slideDown();
}


function changeGender(){
    if (document.getElementsByClassName('radioinput')[0].checked){
        $('.radioSelector').animate({
            'margin-left': '116'
        },300);
        document.getElementsByClassName('radioinput')[1].checked = true;
        document.getElementsByClassName('radioinput')[0].checked = false;
    } else {
        $('.radioSelector').animate({
            'margin-left': '3'
        },300);
        document.getElementsByClassName('radioinput')[0].checked = true;
        document.getElementsByClassName('radioinput')[1].checked = false;
    }
    console.log(document.getElementsByClassName('radioinput')[1].checked);
}


function changeProfileMenu(obj, menu){
    $('.profile_sec').css({'display': 'none'});
    $('#'+obj).css({'display': 'block'});
    $('.menu_item').removeClass('active');
    $(menu).addClass('active');
    $('.activeicon').addClass('icon');
    $('.activeicon').removeClass('activeicon');
    menu.getElementsByClassName('icon')[0].className = 'activeicon';
}

function openAvatarChooser(){
    $('.popupBG').fadeIn();
    $('#avatarChooseWP').fadeIn();
}

function closeAvatar(){
    $('#avatarChooseWP').fadeOut();
}

function chooseAvatar(id){
    $('.chooseavatarthumb').css({ "background-image": "url(/assets/avatars/"+id+".png)"});
    $('#avatar').val(id);
    popupclose();
}

function changeFaq(sec, btn){
    $('.blockitem').removeClass('activeblockitem');
    $(btn).addClass('activeblockitem');
    for (var i=0; i<document.getElementsByClassName('cont').length; i++){
        document.getElementsByClassName('cont')[i].style.display = 'none';
    }
    document.getElementById(sec).style.display = 'block';
    $('html,body').animate({
        scrollTop: $(".faqContent").offset().top
    });
}

function showFullFaq(obj){
    $(obj).find('.fullThisFaq').slideToggle('slow');
}


function showInfo(id, obj){
    $('.button').removeClass('active');
    $(obj).addClass('active');
    for (var ii = 0; ii<3; ii++){
        document.getElementsByClassName('contents')[ii].style.display = 'none';
    }
    document.getElementsByClassName('contents')[id].style.display = 'block';
}