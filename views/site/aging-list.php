<?php

/* @var $this yii\web\View */

use yii\helpers\Html;


$role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))[0];
if($role == 'Superadmin' || $role == 'Admin' || $role == 'BO User'){
    $girdcol = 3;
}else{
    $girdcol = 2;
}
?>

<div class="grid-col-<?php echo $girdcol; ?>">
    <a class="aging-btn sec-1" href="javascript:;" id="loadcompanytable">Company</a>
    <a class="aging-btn sec-2" href="javascript:;" id="loadstatustable">Status</a>
    <?php if($role == 'Superadmin' || $role == 'Admin'){ ?>
        <a class="aging-btn sec-5" href="javascript:;" id="loadrotable">RO</a>
    <?php } ?>
    <?php 
        if($role == 'BO User'){
            echo '<a class="aging-btn sec-6" href="javascript:;" id="loadfetable">Field Eexcutive</a>';
        }
    ?>
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
$autoloadcompanytable = YII::$app->request->baseUrl . '/site/auto-load-company-table';
$autoloadstatustable = YII::$app->request->baseUrl . '/site/auto-load-status-table';
$autoloadrotable = YII::$app->request->baseUrl . '/site/auto-load-ro-table';
$autoloadfetable = YII::$app->request->baseUrl . '/site/auto-load-fe-table';
date_default_timezone_set('Asia/Kolkata');
$curDate = date('Y-m-d H:i:s',strtotime('-48 hours'));
$diffDate = date('Y-m-d H:i:s',strtotime('-72 hours'));

$script = <<< JS

// window.addEventListener('DOMContentLoaded', (event) => {

    $(document).ready(function(){
        companytableajax();
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
                    window.open(response, '_blank');
                }
            });
        }); 
    }
    function autoloadCompanytable(){
        if($('.fixed-table-grid').length > 0){
            if(localStorage.getItem('tablename') == 'company'){
                companytableajax();
            }else if(localStorage.getItem('tablename') == 'status'){
                statustableajax();
            }else if(localStorage.getItem('tablename') == 'ro'){
                rotableajax();
            }else if(localStorage.getItem('tablename') == 'fe'){
                fetableajax();
            }
        }else{
            clearInterval(handle);
            handle = 0;
        }
    }
    function companytableajax(){
        if(localStorage.getItem('tablename')){
            localStorage.removeItem('tablename');
            localStorage.setItem('tablename', 'company');
        }else{
            localStorage.setItem('tablename', 'company');
        }
        $('.aging-btn').removeClass('active');
        $('#loadcompanytable').addClass('active');
        $.ajax({
            url: '$autoloadcompanytable',
            type: 'get',
            success: function (response){
                $('#loaddiv').html('');
                $('#loaddiv').html(response);
                columnclickable();    
            }
        });
    }
    function statustableajax(){
        if(localStorage.getItem('tablename')){
            localStorage.removeItem('tablename');
            localStorage.setItem('tablename', 'status');
        }else{
            localStorage.setItem('tablename', 'status');
        }
        $('.aging-btn').removeClass('active');
        $('#loadstatustable').addClass('active');
        $.ajax({
            url: '$autoloadstatustable',
            type: 'get',
            success: function (response){
                $('#loaddiv').html('');
                $('#loaddiv').html(response);
                columnclickable();    
            }
        });
    }
    function rotableajax(){
        if(localStorage.getItem('tablename')){
            localStorage.removeItem('tablename');
            localStorage.setItem('tablename', 'ro');
        }else{
            localStorage.setItem('tablename', 'ro');
        }
        $('.aging-btn').removeClass('active');
        $('#loadrotable').addClass('active');
        $.ajax({
            url: '$autoloadrotable',
            type: 'get',
            success: function (response){
                $('#loaddiv').html('');
                $('#loaddiv').html(response);
                columnclickable();    
            }
        });
    }
    function fetableajax(){
        if(localStorage.getItem('tablename')){
            localStorage.removeItem('tablename');
            localStorage.setItem('tablename', 'fe');
        }else{
            localStorage.setItem('tablename', 'fe');
        }
        $('.aging-btn').removeClass('active');
        $('#loadfetable').addClass('active');
        $.ajax({
            url: '$autoloadfetable',
            type: 'get',
            success: function (response){
                $('#loaddiv').html('');
                $('#loaddiv').html(response);
                columnclickable();    
            }
        });
    }
    $('#loadcompanytable').click(function(){
        $('#loaddiv').html(''); 
        $('#loaddiv').html(loader); 
        companytableajax();
    });
    $('#loadstatustable').click(function(){
        $('#loaddiv').html(''); 
        $('#loaddiv').html(loader); 
        if($('.fixed-table-grid').length > 0){
            statustableajax();
        }else{
            statustableajax();
            clearInterval(handle);
            handle = 0;
        }
    });
    $('#loadrotable').click(function(){
        $('#loaddiv').html(''); 
        $('#loaddiv').html(loader); 
        if($('.fixed-table-grid').length > 0){
            rotableajax();
        }else{
            rotableajax();
            clearInterval(handle);
            handle = 0;
        }
    });
    $('#loadfetable').click(function(){
        $('#loaddiv').html(''); 
        $('#loaddiv').html(loader); 
        if($('.fixed-table-grid').length > 0){
            fetableajax();
        }else{
            fetableajax();
            clearInterval(handle);
            handle = 0;
        }
    });
    var handle = setInterval(() => {
        autoloadCompanytable();
    }, 1000*60*5);
// });

JS;
$this->registerJS($script);

?>
    