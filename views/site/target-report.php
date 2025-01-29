<?php

/* @var $this yii\web\View */

use yii\helpers\Html;


$role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0];

?>

<div class="grid-col-2">
    <a class="aging-btn sec-1" href="javascript:;" id="loadcompletedtable"> Completed Cases</a>
    <a class="aging-btn sec-2" href="javascript:;" id="loadcancelledtable">Cancelled Cases </a>
</div>

<div id="loaddiv" class="site-about">
    <div class="center-div">
        <div class="loader-container">
            <span class="loader"></span>
        </div>
        <span class="loading">Loading</span>
    </div>
</div>

<style>
    .grid-col-2{
        display:grid;
        grid-template-columns:repeat(2,1fr);
        gap:25px;
    }
    .grid-col-3{
        display:grid;
        grid-template-columns:repeat(3,1fr);
        gap:25px;
    }
    .grid-col-4{
        display:grid;
        grid-template-columns:repeat(4,1fr);
        gap:25px;
    }
    .aging-btn{
        color:#5e5e5e!important;
        text-decoration:none!important;
        border: 1px solid #ccc;
        border-radius: 10px;
        min-height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: 700;
        box-shadow: 0px 0px 5px #0000002e;
    }
    .center-div {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    margin: auto;
    width: 100%;
    height: fit-content;
    }
    .loader-container{
    width:80px;
    height:4px;
    margin:0 auto;
    background-color:#aaa;
    border-radius:20px;
    overflow:hidden;
    }
    .loader{
    width:60%;
    height:100%;
    background-color:#de4b4b;
    display:block;
    animation: animate  ease-out 1s infinite;
    }
    .loading{
    margin:8px auto;
    width:80px;
    text-align:center;
    font-size:16px;
    font-weight:700;
    color:#aaa;
    display:block;
    }
    @keyframes animate{
        0%{
            transform: translatex(-50%);
        }
        50%{
            transform: translatex(100%);
        }
        100%{
            transform:translatex(-50%)
        }

    }
    .sec-0{
        background: rgb(217,217,217);
    }
    .sec-1{
        background: rgb(221,235,247);
        color: #26539b !important;
    }
    .sec-1.active{
        border-color:#26539b !important;
    }
    .sec-2{
        background: rgb(252,228,214);
        color: rgb(121, 58, 21) !important;
    }
    .sec-2.active{
        border-color:rgb(121, 58, 21) !important;
    }
    .sec-3{
        background: rgb(237,237,237);
    }
    .sec-4{
        background: rgb(255,255,255);
    }
    .sec-5{
        background: rgb(255,242,204);
        color: rgb(113, 96, 49) !important;
    }
    .sec-5.active{
        border-color:rgb(113, 96, 49) !important;
    }
    .sec-6{
        background: rgb(226,239,218);
        color: rgb(77, 108, 57) !important;
    }
    .sec-6.active{
        border-color:rgb(77, 108, 57) !important;
    }
</style>

<?php

$url = YII::$app->request->baseUrl . '/site/load-aging';
$loadcompletedtable = YII::$app->request->baseUrl . '/site/load-completed-table';
$loadcancelledtable = YII::$app->request->baseUrl . '/site/load-cancelled-table';
date_default_timezone_set('Asia/Kolkata');
$curDate = date('Y-m-d H:i:s',strtotime('-48 hours'));
$diffDate = date('Y-m-d H:i:s',strtotime('-72 hours'));

$script = <<< JS

// window.addEventListener('DOMContentLoaded', (event) => {

    $(document).ready(function(){
        completedtableajax();
    });

    let loader = '';
    loader +='<div class="center-div">';
    loader +='<div class="loader-container">';
    loader +='<span class="loader"></span>';
    loader +='</div>';
    loader +='<span class="loading">Loading</span>';
    loader +='</div>';

    function columnclickable(){
        $('.custom-table-body div').click(function(){
            let id = $(this).attr('data-id');
            let day = $(this).attr('data-day');
            let status = $(this).attr('data-type');
            let tablename = localStorage.getItem('tablename');
            $.ajax({
                url: '$url',
                type: 'POST',
                data: {
                    id,
                    day,
                    status,
                    tablename
                },
                success: function (response){
                    // alert(JSON.stringify(response));  
                    $('#loaddiv').html(''); 
                    $('#loaddiv').html(response);   
                }
            });
        }); 
    }
    function completedtableajax(){
        if(localStorage.getItem('tablename')){
            localStorage.removeItem('tablename');
            localStorage.setItem('tablename', 'completed');
        }else{
            localStorage.setItem('tablename', 'completed');
        }
        $('.aging-btn').removeClass('active');
        $('#loadcompletedtable').addClass('active');
        $.ajax({
            url: '$loadcompletedtable',
            type: 'get',
            success: function (response){
                $('#loaddiv').html('');
                $('#loaddiv').html(response);
                columnclickable();    
            }
        });
    }
    function cancelledtableajax(){
        if(localStorage.getItem('tablename')){
            localStorage.removeItem('tablename');
            localStorage.setItem('tablename', 'cancelled');
        }else{
            localStorage.setItem('tablename', 'cancelled');
        }
        $('.aging-btn').removeClass('active');
        $('#loadcancelledtable').addClass('active');
        $.ajax({
            url: '$loadcancelledtable',
            type: 'get',
            success: function (response){
                $('#loaddiv').html('');
                $('#loaddiv').html(response);
                columnclickable();    
            }
        });
    }
    $('#loadcompletedtable').click(function(){
        $('#loaddiv').html(''); 
        $('#loaddiv').html(loader); 
        completedtableajax();
    });
    $('#loadcancelledtable').click(function(){
        $('#loaddiv').html(''); 
        $('#loaddiv').html(loader); 
        cancelledtableajax();
    });
// });

JS;
$this->registerJS($script);

?>
    