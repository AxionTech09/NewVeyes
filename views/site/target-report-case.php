<?php

/* @var $this yii\web\View */

use yii\helpers\Html;



$this->title = 'Target Report '.$title.' Cases';

?>
<h1 class="title"><?= Html::encode($this->title) ?></h1>
<?php // print_r($data); die;?>
<?php if(count($data) > 0){ ?>
<div class="fixed-table-grid">
    <div class="fixed-left">
        <?php
            echo '<div class="sec-0 heading border-right">&nbsp;</div>';
            foreach($data as $val){ 
                $name = $val[0]['name'] ? $val[0]['name'] : '-';
                echo '<div class="sec-0 border-top border-right">'.$name.'</div>';
            }
            echo '<div class="sec-0 border-top border-right">Total</div>';
        ?>
    </div>
    <?php
    $heding4 = $title == 'Completed' ? '% Completed' : '% Cancelled';
    $heding5 = $title == 'Completed' ? '% to be completed' : '% Cancelled on <br> Total Received Cases';
    ?>
    <div class="custom-table">
        <div class="custom-table-heading main-heading">
            <div class="heading border-right sec-1">Last Month</div>
            <div class="heading border-right sec-2">Upto Date, <br> Last Month</div>
            <div class="heading border-right sec-3">Upto Date, <br> Current Month</div>
            <div class="heading border-right sec-4">Target for <br> Current Month</div>
            <div class="heading border-right sec-5"><?php echo $heding4 ?></div>
            <div class="heading border-right sec-6"><?php echo $heding5?></div>
            <!-- <div class="heading sec-6">More than 5 days</div> -->
        </div>
        <div class="custom-table-body">
            <?php
                foreach($data as $val){ 
                    // echo $val[0]['last_month'];
                    $lastMonth = intval($val[0]['last_month']);
                    $lastUptoLastMonth = intval($val[0]['upto_last_month']);
                    $uptoCurrentMonth = intval($val[0]['upto_current_month']);
                    $fontweight1 = $lastMonth > 0 ? "font-blod" : "";
                    $fontweight2 = $lastUptoLastMonth > 0 ? "font-blod" : "";
                    $fontweight3 = $uptoCurrentMonth > 0 ? "font-blod" : "";
                    $highestVal = $lastMonth > $uptoCurrentMonth ? $lastMonth : $uptoCurrentMonth;
                    if($highestVal != 0 && $title == 'Completed'){
                        $targetCurMonth = round(($highestVal * 10) / 100) +  $highestVal;
                    }elseif($highestVal != 0 && $title == 'Cancelled'){
                        $targetCurMonth =  $highestVal - round(($highestVal * 20) / 100);
                    }else{
                        $targetCurMonth = 0;
                    }
                    $targetCurMonth = $targetCurMonth == 0 ? $uptoCurrentMonth : $targetCurMonth;
                    $fontweight4 = $targetCurMonth > 0 ? "font-blod" : "";
                    if($targetCurMonth != 0 && $uptoCurrentMonth != 0){
                        $targetPer = $uptoCurrentMonth / $targetCurMonth * 100;
                    }else{
                        $targetPer = 0;
                    }
                    $fontweight5 = $targetPer > 0 ? "font-blod" : "";
                    $totargetPer = 100 - round($targetPer);
                    $fontweight6 = $totargetPer > 0 ? "font-blod" : "";

                    echo '<div class="sec-1 border-top border-right '.$fontweight1.'" data-id="'.$val[0]['id'].'" data-type="last-month" title="'.$val[0]['name'].' - Last Month">'.$lastMonth.'</div>';
                    echo '<div class="sec-2 border-top border-right '.$fontweight2.'" data-id="'.$val[0]['id'].'" data-type="upto-date-lastmonth" title="'.$val[0]['name'].' - Upto Date, Last Month">'.$lastUptoLastMonth.'</div>';
                    echo '<div class="sec-3 border-top border-right '.$fontweight3.'" data-id="'.$val[0]['id'].'" data-type="upto-date-curmonth" title="'.$val[0]['name'].' - Upto Date, Current Month">'.$uptoCurrentMonth.'</div>';    
                    echo '<div class="sec-4 border-top border-right '.$fontweight4.'" data-id="'.$val[0]['id'].'" data-type="target-curmonth" title="'.$val[0]['name'].' - Target for Current Month">'.$targetCurMonth.'</div>';    
                    echo '<div class="sec-5 border-top border-right '.$fontweight5.'" data-id="'.$val[0]['id'].'" data-type="completed" title="'.$val[0]['name'].' - '.$heding4.'">'.round($targetPer).'%</div>';
                    echo '<div class="sec-6 border-top '.$fontweight6.'" data-id="'.$val[0]['id'].'" data-type="tobe-complete" title="'.$val[0]['name'].' - '.$heding5.'">'.$totargetPer.'%</div>';
                }
                echo '<div class="sec-1 border-top border-right font-blod total" data-type="last-month" title="Total - Last Month">0</div>';
                echo '<div class="sec-2 border-top border-right font-blod total" data-type="upto-date-lastmonth" title="Total - Upto Date, Last Month">0</div>';
                echo '<div class="sec-3 border-top border-right font-blod total" data-type="upto-date-curmonth" title="Total - Upto Date, Current Month">0</div>';    
                echo '<div class="sec-4 border-top border-right font-blod total" data-type="target-curmonth" title="Total - Target for Current Month">0</div>';    
                echo '<div class="sec-5 border-top border-right font-blod total" data-type="completed" title="Total - '.$heding4.'">0%</div>';
                echo '<div class="sec-6 border-top font-blod total" data-type="tobe-complete" title="Total - '.$heding5.'">0%</div>';
            ?>
            
        </div>
    </div>
</div>
<?php  }else{ ?>
    <div class="heading">No Data Found...!</div>
<?php  } ?>
<style>
.font-blod{
    font-weight:900;
}
.fixed-table-grid {
    display: grid;
    grid-template-columns: auto auto;
    border-radius: 15px;
    overflow: auto;
    box-shadow: 0px 0px 5px #0000003b;
    max-height: calc(100vh - 30vh);
    /* border: 1px solid #939393; */
}
@media(max-width:560px){
    .fixed-left div {
        text-overflow: ellipsis;
        width: 165px;
        white-space: nowrap;
        overflow: hidden;
    }
}
.fixed-left div {
  font-size: 10px;
  font-weight: 600;
  padding: 0px 8px;
  text-transform:uppercase;
  /* border: 1px solid #939393; */
}
.custom-table{
    overflow-x: auto;
    max-width: 100%;
}
.custom-table-heading.main-heading, .custom-table-body{
    display: grid;
    /* grid-template-columns: repeat(6, minmax(135px, 1fr)); */
    grid-template-columns: repeat(6, minmax(135px, 1fr));
    text-align: center;
    white-space: nowrap;
    font-size:12px;
}
.custom-table-heading.main-heading .heading:last-child{
    border-right-style:hidden;
}
.custom-table-heading.main-heading .heading {
    display: flex;
    align-items: center;
    justify-content: center;
    line-height: 1.1em;
    padding: 3px;
}
.fixed-left .heading {
  padding: 3px;
}
.custom-table-body div{
    cursor:pointer;
}
.border-top{
    border-top:1px solid;
}
.border-top-bottom{
    border-top:1px solid;
    border-bottom:1px solid;
}
.border-right{
    border-right:1px solid;

}
.border-left{
    border-right:1px solid;

}
.border-left-none{
    border-left-style:hidden!important;
}
.border-right-none{
    border-right-style:hidden!important;
}
</style>
<script>
    var lastmonthSum = 0;
    $("div[data-type='last-month']").each(function() {
        var lastmonthtext = $(this).text();
        if (!isNaN(parseFloat(lastmonthtext))) {
            lastmonthSum += parseFloat(lastmonthtext);
        }
    });
    $("div.total[data-type='last-month']").text(lastmonthSum);

    var uptodatelastmonthSum = 0;
    $("div[data-type='upto-date-lastmonth']").each(function() {
        var uptodatelastmonthtext = $(this).text();
        if (!isNaN(parseFloat(uptodatelastmonthtext))) {
            uptodatelastmonthSum += parseFloat(uptodatelastmonthtext);
        }
    });
    $("div.total[data-type='upto-date-lastmonth']").text(uptodatelastmonthSum);

    var uptodatecurmonthSum = 0;
    $("div[data-type='upto-date-curmonth']").each(function() {
        var uptodatecurmonthtext = $(this).text();
        if (!isNaN(parseFloat(uptodatecurmonthtext))) {
            uptodatecurmonthSum += parseFloat(uptodatecurmonthtext);
        }
    });
    $("div.total[data-type='upto-date-curmonth']").text(uptodatecurmonthSum);

    var targercurmonthSum = 0;
    $("div[data-type='target-curmonth']").each(function() {
        var targercurmonthtext = $(this).text();
        if (!isNaN(parseFloat(targercurmonthtext))) {
            targercurmonthSum += parseFloat(targercurmonthtext);
        }
    });
    $("div.total[data-type='target-curmonth']").text(targercurmonthSum);

    var completedSum = 0;
    var totalCnt = 0;
    $("div[data-type='completed']").each(function() {
        totalCnt = $("div[data-type='completed']").length;
        var targercurmonthtext = $(this).text();
        targercurmonthtext = targercurmonthtext.replace("%", "");
        if (!isNaN(parseFloat(targercurmonthtext))) {
            completedSum += parseFloat(targercurmonthtext);
        }
    });
    $("div.total[data-type='completed']").text(Math.round(completedSum / totalCnt)+'%');

    var tobecompleteSum = 0;
    $("div[data-type='tobe-complete']").each(function() {
        totalCnt = $("div[data-type='tobe-complete']").length;
        var tobecompletetext = $(this).text();
        tobecompletetext = tobecompletetext.replace("%", "");
        if (!isNaN(parseFloat(tobecompletetext))) {
            tobecompleteSum += parseFloat(tobecompletetext);
        }
    });
    $("div.total[data-type='tobe-complete']").text(Math.round(tobecompleteSum / totalCnt)+'%');
    
</script>