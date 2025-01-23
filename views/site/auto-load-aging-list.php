<?php

/* @var $this yii\web\View */

use yii\helpers\Html;



$this->title = $title.' Age Wise List';

?>
<h1 class="title"><?= Html::encode($this->title) ?></h1>
<?php if(count($data) > 0){ ?>
<div class="fixed-table-grid">
    <div class="fixed-left">
        <?php
            echo '<div class="sec-0 border-right">&nbsp;</div>';
            echo '<div class="sec-0 border-top border-right">&nbsp;</div>';
            foreach($data as $val){ 
                $name = $val['name'] ?? $val['id'];
                echo '<div data-compid="'.$val['id'].'" class="sec-0 border-top border-right company-name">'.$name.'</div>';
            }
            echo '<div class="sec-0 border-top border-right">Total</div>';
        ?>
    </div>
    <div class="custom-table">
        <div class="custom-table-heading main-heading">
            <div class="heading border-right sec-1">Upto 1 Day</div>
            <div class="heading border-right sec-2">1 to 2 Days</div>
            <div class="heading border-right sec-3">2 to 3 Days</div>
            <div class="heading border-right sec-4">3 to 4 Days</div>
            <div class="heading border-right sec-5">4 to 5 Days</div>
            <div class="heading border-right sec-6">More than 5 days</div>
            <div class="heading sec-0">Total</div>
        </div>
        <div class="custom-table-heading sub-heading">
            <div class="heading border-top border-right sec-1 border-left-none" title="Fresh">Fresh</div>
            <div class="heading border-top border-right sec-1" title="Schedule">Schedule</div>
            <div class="heading border-top border-right sec-1 border-left-none" title="Survey Done">Survey <br> Done</div>
            <div class="heading border-top border-right sec-2" title="Fresh">Fresh</div>
            <div class="heading border-top border-right sec-2" title="Schedule">Schedule</div>
            <div class="heading border-top border-right sec-2" title="Survey Done">Survey <br> Done</div>
            <div class="heading border-top border-right sec-3" title="Fresh">Fresh</div>
            <div class="heading border-top border-right sec-3" title="Schedule">Schedule</div>
            <div class="heading border-top border-right sec-3" title="Survey Done">Survey <br> Done</div>
            <div class="heading border-top border-right sec-4" title="Fresh">Fresh</div>
            <div class="heading border-top border-right sec-4" title="Schedule">Schedule</div>
            <div class="heading border-top border-right sec-4" title="Survey Done">Survey <br> Done</div>
            <div class="heading border-top border-right sec-5 " title="Fresh">Fresh</div>
            <div class="heading border-top border-right sec-5" title="Schedule">Schedule</div>
            <div class="heading border-top border-right sec-5" title="Survey Done">Survey <br> Done</div>
            <div class="heading border-top border-right sec-6" title="Fresh">Fresh</div>
            <div class="heading border-top border-right sec-6" title="Schedule">Schedule</div>
            <div class="heading border-top border-right sec-6" title="Survey Done">Survey <br> Done</div>            
            <div class="heading border-top sec-0"></div>
            <div class="heading border-top sec-0" style="position:relative;width:65px;left:-10px;">Case Count</div>
            <div class="heading border-top sec-0"></div>
        </div>

        <div class="custom-table-body">
            <?php
                foreach($data as $val){ 
                    // // print_r($val);
                    $fontweight1 = $val['dayone_status_Fresh'] > 0 ? "font-blod" : "";
                    $fontweight2 = $val['dayone_status_Schedule'] > 0 ? "font-blod" : "";
                    $fontweight3 = $val['dayone_status_Surveydone'] > 0 ? "font-blod" : "";
                    $fontweight4 = $val['daytwo_status_Fresh'] > 0 ? "font-blod" : "";
                    $fontweight5 = $val['daytwo_status_Schedule'] > 0 ? "font-blod" : "";
                    $fontweight6 = $val['daytwo_status_Surveydone'] > 0 ? "font-blod" : "";
                    $fontweight7 = $val['daythree_status_Fresh'] > 0 ? "font-blod" : ""; 
                    $fontweight8 = $val['daythree_status_Schedule'] > 0 ? "font-blod" : "";
                    $fontweight9 = $val['daythree_status_Surveydone'] > 0 ? "font-blod" : "";
                    $fontweight10 = $val['dayfour_status_Fresh'] > 0 ? "font-blod" : "";
                    $fontweight11 = $val['dayfour_status_Schedule'] > 0 ? "font-blod" : "";
                    $fontweight12 = $val['dayfour_status_Surveydone'] > 0 ? "font-blod" : "";
                    $fontweight13 = $val['dayfive_status_Fresh'] > 0 ? "font-blod" : "";
                    $fontweight14 = $val['dayfive_status_Schedule'] > 0 ? "font-blod" : "";
                    $fontweight15 = $val['dayfive_status_Surveydone'] > 0 ? "font-blod" : "";
                    $fontweight16 = $val['daysix_status_Schedule'] > 0 ? "font-blod" : "";
                    $fontweight17 = $val['daysix_status_Schedule'] > 0 ? "font-blod" : "";
                    $fontweight18 = $val['daysix_status_Surveydone'] > 0 ? "font-blod" : "";

                    echo '<div class="sec-1 border-top border-right '.$fontweight1.'" data-id="'.$val['id'].'" data-day="1" data-type="0" title="'.$val['name'].' - Fresh">'.$val['dayone_status_Fresh'].'</div>';
                    echo '<div class="sec-1 border-top border-right '.$fontweight2.'" data-id="'.$val['id'].'" data-day="1" data-type="12" title="'.$val['name'].' - Schedule">'.$val['dayone_status_Schedule'].'</div>';
                    echo '<div class="sec-1 border-top border-right '.$fontweight3.'" data-id="'.$val['id'].'" data-day="1" data-type="8" title="'.$val['name'].' - Survey Done">'.$val['dayone_status_Surveydone'].'</div>';    
                    echo '<div class="sec-2 border-top border-right '.$fontweight4.'" data-id="'.$val['id'].'" data-day="2" data-type="0" title="'.$val['name'].' - Fresh">'.$val['daytwo_status_Fresh'].'</div>';
                    echo '<div class="sec-2 border-top border-right '.$fontweight5.'" data-id="'.$val['id'].'" data-day="2" data-type="12" title="'.$val['name'].' - Schedule">'.$val['daytwo_status_Schedule'].'</div>';
                    echo '<div class="sec-2 border-top border-right '.$fontweight6.'" data-id="'.$val['id'].'" data-day="2" data-type="8" title="'.$val['name'].' - Survey Done">'.$val['daytwo_status_Surveydone'].'</div>';                        
                    echo '<div class="sec-3 border-top border-right '.$fontweight7.'" data-id="'.$val['id'].'" data-day="3" data-type="0" title="'.$val['name'].' - Fresh">'.$val['daythree_status_Fresh'].'</div>';
                    echo '<div class="sec-3 border-top border-right '.$fontweight8.'" data-id="'.$val['id'].'" data-day="3" data-type="12" title="'.$val['name'].' - Schedule">'.$val['daythree_status_Schedule'].'</div>';
                    echo '<div class="sec-3 border-top border-right '.$fontweight9.'" data-id="'.$val['id'].'" data-day="3" data-type="8" title="'.$val['name'].' - Survey Done">'.$val['daythree_status_Surveydone'].'</div>';    
                    echo '<div class="sec-4 border-top border-right '.$fontweight10.'" data-id="'.$val['id'].'" data-day="4" data-type="0" title="'.$val['name'].' - Fresh">'.$val['dayfour_status_Fresh'].'</div>';
                    echo '<div class="sec-4 border-top border-right '.$fontweight11.'" data-id="'.$val['id'].'" data-day="4" data-type="12" title="'.$val['name'].' - Schedule">'.$val['dayfour_status_Schedule'].'</div>';
                    echo '<div class="sec-4 border-top border-right '.$fontweight12.'" data-id="'.$val['id'].'" data-day="4" data-type="8" title="'.$val['name'].' - Survey Done">'.$val['dayfour_status_Surveydone'].'</div>';                        
                    echo '<div class="sec-5 border-top border-right '.$fontweight13.'" data-id="'.$val['id'].'" data-day="5" data-type="0" title="'.$val['name'].' - Fresh">'.$val['dayfive_status_Fresh'].'</div>';
                    echo '<div class="sec-5 border-top border-right '.$fontweight14.'" data-id="'.$val['id'].'" data-day="5" data-type="12" title="'.$val['name'].' - Schedule">'.$val['dayfive_status_Schedule'].'</div>';
                    echo '<div class="sec-5 border-top border-right '.$fontweight15.'" data-id="'.$val['id'].'" data-day="5" data-type="8" title="'.$val['name'].' - Survey Done">'.$val['dayfive_status_Surveydone'].'</div>';    
                    echo '<div class="sec-6 border-top border-right '.$fontweight16.'" data-id="'.$val['id'].'" data-day="6" data-type="0" title="'.$val['name'].' - Fresh">'.$val['daysix_status_Fresh'].'</div>';
                    echo '<div class="sec-6 border-top border-right '.$fontweight17.'" data-id="'.$val['id'].'" data-day="6" data-type="12" title="'.$val['name'].' - Schedule">'.$val['daysix_status_Schedule'].'</div>';
                    echo '<div class="sec-6 border-top border-right '.$fontweight18.'" data-id="'.$val['id'].'" data-day="6" data-type="8" title="'.$val['name'].' - Survey Done">'.$val['daysix_status_Surveydone'].'</div>';
                    echo '<div class="sec-0 border-top font-blod" data-id="'.$val['id'].'" data-type="casecnt"></div>';
                    echo '<div class="sec-0 border-top totalcasecnt font-blod" data-id="'.$val['id'].'" data-type="casecnt">0</div>';
                    echo '<div class="sec-0 border-top font-blod" data-id="'.$val['id'].'" data-type="casecnt"></div>';
                }
                echo '<div class="sec-1 border-top border-right total font-blod" data-day="1" data-type="0" title="Total - Fresh">0</div>';
                echo '<div class="sec-1 border-top border-right total font-blod" data-day="1" data-type="12" title="Total - Schedule">0</div>';
                echo '<div class="sec-1 border-top border-right total font-blod" data-day="1" data-type="8" title="Total - Survey Done">0</div>';    
                echo '<div class="sec-2 border-top border-right total font-blod" data-day="2" data-type="0" title="Total - Fresh">0</div>';
                echo '<div class="sec-2 border-top border-right total font-blod" data-day="2" data-type="12" title="Total - Schedule">0</div>';
                echo '<div class="sec-2 border-top border-right total font-blod" data-day="2" data-type="8" title="Total - Survey Done">0</div>';                        
                echo '<div class="sec-3 border-top border-right total font-blod" data-day="3" data-type="0" title="Total - Fresh">0</div>';
                echo '<div class="sec-3 border-top border-right total font-blod" data-day="3" data-type="12" title="Total - Schedule">0</div>';
                echo '<div class="sec-3 border-top border-right total font-blod" data-day="3" data-type="8" title="Total - Survey Done">0</div>';    
                echo '<div class="sec-4 border-top border-right total font-blod" data-day="4" data-type="0" title="Total - Fresh">0</div>';
                echo '<div class="sec-4 border-top border-right total font-blod" data-day="4" data-type="12" title="Total - Schedule">0</div>';
                echo '<div class="sec-4 border-top border-right total font-blod" data-day="4" data-type="8" title="Total - Survey Done">0</div>';                        
                echo '<div class="sec-5 border-top border-right total font-blod" data-day="5" data-type="0" title="Total - Fresh">0</div>';
                echo '<div class="sec-5 border-top border-right total font-blod" data-day="5" data-type="12" title="Total - Schedule">0</div>';
                echo '<div class="sec-5 border-top border-right total font-blod" data-day="5" data-type="8" title="Total - Survey Done">0</div>';    
                echo '<div class="sec-6 border-top border-right total font-blod" data-day="6" data-type="0" title="Total - Fresh">0</div>';
                echo '<div class="sec-6 border-top border-right total font-blod" data-day="6" data-type="12" title="Total - Schedule">0</div>';
                echo '<div class="sec-6 border-top border-right total font-blod" data-day="6" data-type="8" title="Total - Survey Done">0</div>';
                echo '<div class="sec-0 border-top font-blod" data-type="casecnt"></div>';
                echo '<div class="sec-0 border-top sumtotalcasecnt font-blod" data-type="casecnt">0</div>';
                echo '<div class="sec-0 border-top font-blod" data-type="casecnt"></div>';
            ?>
            
        </div>
    </div>
</div>
<?php }else{ ?>
    <div class="heading">No Data Found...!</div>
<?php } ?>
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
/* .fixed-left div:nth-child(2n), .fixed-left div:nth-child(2n+1),.custom-table-heading.main-heading .heading:nth-child(2n+1), .custom-table-heading.main-heading .heading:nth-child(2n) {
  border-top-style: hidden;
  border-left-style:hidden;
}
.custom-table-heading.sub-heading div:nth-child(2n+1), .custom-table-heading.sub-heading div:nth-child(2n), .custom-table-body div:nth-child(2n+1), .custom-table-body div:nth-child(2n){
    border-top-style: hidden;
}
.custom-table-heading.sub-heading div:nth-child(2n+1), .custom-table-body div:nth-child(2n+1){
    border-left-style:hidden;
    border-right-style:hidden;
}
.fixed-left div:last-child{
    border-bottom-style:hidden;
} */
.custom-table{
    overflow-x: auto;
    max-width: 100%;
}
.custom-table-heading.main-heading{
    display: grid;
    /* grid-template-columns: repeat(6, minmax(135px, 1fr)); */
    grid-template-columns: repeat(7, minmax(159px, 1fr));
    text-align: center;
    white-space: nowrap;
    font-size:12px;
}
.custom-table-heading.main-heading .heading{
    /* border: 1px solid #939393; */
    /* border-top-style: hidden; */
}
/* .custom-table-heading.main-heading .heading:nth-child(2n+1), .custom-table-heading.main-heading .heading:nth-child(2n) {
  border-left-style: hidden;
} */
.custom-table-heading.sub-heading .heading{
    line-height:1.2em;
    display: flex;
    align-items: center;
    justify-content: center;
}
.custom-table-heading.main-heading .heading:last-child{
    border-right-style:hidden;
}
.custom-table-heading.sub-heading, .custom-table-body{
  display: grid;
  /* grid-template-columns: repeat(18, minmax(45px, 1fr)); */
  grid-template-columns: repeat(21, minmax(53px, 1fr));
  /* text-align: center; */
  font-size: 11px;
  white-space: nowrap;
}
.custom-table-heading.sub-heading div, .custom-table-body div{
    padding: 0px 5px;
    text-align:center;
    text-overflow: ellipsis;
    /* width: 46px; */
    white-space: nowrap;
    overflow: hidden;
    /* border: 1px solid #939393; */
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
    var day1freshSum = 0;
    var day1schdSum = 0;
    var day1surydnSum = 0;
    $("div[data-day='1'][data-type='0']").each(function() {
        var day1freshtext = $(this).text();
        if (!isNaN(parseFloat(day1freshtext))) {
            day1freshSum += parseFloat(day1freshtext);
        }
    });
    $("div.total[data-day='1'][data-type='0']").text(day1freshSum);

    $("div[data-day='1'][data-type='12']").each(function() {
        var day1schdtext = $(this).text();
        if (!isNaN(parseFloat(day1schdtext))) {
            day1schdSum += parseFloat(day1schdtext);
        }
    });
    $("div.total[data-day='1'][data-type='12']").text(day1schdSum);

    $("div[data-day='1'][data-type='8']").each(function() {
        var day1surydntext = $(this).text();
        if (!isNaN(parseFloat(day1surydntext))) {
            day1surydnSum += parseFloat(day1surydntext);
        }
    });
    $("div.total[data-day='1'][data-type='8']").text(day1surydnSum);

    var day2freshSum = 0;
    var day2schdSum = 0;
    var day2surydnSum = 0;
    $("div[data-day='2'][data-type='0']").each(function() {
        var day2freshtext = $(this).text();
        if (!isNaN(parseFloat(day2freshtext))) {
            day2freshSum += parseFloat(day2freshtext);
        }
    });
    $("div.total[data-day='2'][data-type='0']").text(day2freshSum);

    $("div[data-day='2'][data-type='12']").each(function() {
        var day2schdtext = $(this).text();
        if (!isNaN(parseFloat(day2schdtext))) {
            day2schdSum += parseFloat(day2schdtext);
        }
    });
    $("div.total[data-day='2'][data-type='12']").text(day2schdSum);

    $("div[data-day='2'][data-type='8']").each(function() {
        var day2surydntext = $(this).text();
        if (!isNaN(parseFloat(day2surydntext))) {
            day2surydnSum += parseFloat(day2surydntext);
        }
    });
    $("div.total[data-day='2'][data-type='8']").text(day2surydnSum);
    
    var day3freshSum = 0;
    var day3schdSum = 0;
    var day3surydnSum = 0;
    $("div[data-day='3'][data-type='0']").each(function() {
        var day3freshtext = $(this).text();
        if (!isNaN(parseFloat(day3freshtext))) {
            day3freshSum += parseFloat(day3freshtext);
        }
    });
    $("div.total[data-day='3'][data-type='0']").text(day3freshSum);

    $("div[data-day='3'][data-type='12']").each(function() {
        var day3schdtext = $(this).text();
        if (!isNaN(parseFloat(day3schdtext))) {
            day3schdSum += parseFloat(day3schdtext);
        }
    });
    $("div.total[data-day='3'][data-type='12']").text(day3schdSum);

    $("div[data-day='3'][data-type='8']").each(function() {
        var day3surydntext = $(this).text();
        if (!isNaN(parseFloat(day3surydntext))) {
            day3surydnSum += parseFloat(day3surydntext);
        }
    });
    $("div.total[data-day='3'][data-type='8']").text(day3surydnSum);
    
    var day4freshSum = 0;
    var day4schdSum = 0;
    var day4surydnSum = 0;
    $("div[data-day='4'][data-type='0']").each(function() {
        var day4freshtext = $(this).text();
        if (!isNaN(parseFloat(day4freshtext))) {
            day4freshSum += parseFloat(day4freshtext);
        }
    });
    $("div.total[data-day='4'][data-type='0']").text(day4freshSum);

    $("div[data-day='4'][data-type='12']").each(function() {
        var day4schdtext = $(this).text();
        if (!isNaN(parseFloat(day4schdtext))) {
            day4schdSum += parseFloat(day4schdtext);
        }
    });
    $("div.total[data-day='4'][data-type='12']").text(day4schdSum);

    $("div[data-day='4'][data-type='8']").each(function() {
        var day4surydntext = $(this).text();
        if (!isNaN(parseFloat(day4surydntext))) {
            day4surydnSum += parseFloat(day4surydntext);
        }
    });
    $("div.total[data-day='4'][data-type='8']").text(day4surydnSum);
    
    var day5freshSum = 0;
    var day5schdSum = 0;
    var day5surydnSum = 0;
    $("div[data-day='5'][data-type='0']").each(function() {
        var day5freshtext = $(this).text();
        if (!isNaN(parseFloat(day5freshtext))) {
            day5freshSum += parseFloat(day5freshtext);
        }
    });
    $("div.total[data-day='5'][data-type='0']").text(day5freshSum);

    $("div[data-day='5'][data-type='12']").each(function() {
        var day5schdtext = $(this).text();
        if (!isNaN(parseFloat(day5schdtext))) {
            day5schdSum += parseFloat(day5schdtext);
        }
    });
    $("div.total[data-day='5'][data-type='12']").text(day5schdSum);

    $("div[data-day='5'][data-type='8']").each(function() {
        var day5surydntext = $(this).text();
        if (!isNaN(parseFloat(day5surydntext))) {
            day5surydnSum += parseFloat(day5surydntext);
        }
    });
    $("div.total[data-day='5'][data-type='8']").text(day5surydnSum);
    
    var day6freshSum = 0;
    var day6schdSum = 0;
    var day6surydnSum = 0;
    $("div[data-day='6'][data-type='0']").each(function() {
        var day6freshtext = $(this).text();
        if (!isNaN(parseFloat(day6freshtext))) {
            day6freshSum += parseFloat(day6freshtext);
        }
    });
    $("div.total[data-day='6'][data-type='0']").text(day6freshSum);

    $("div[data-day='6'][data-type='12']").each(function() {
        var day6schdtext = $(this).text();
        if (!isNaN(parseFloat(day6schdtext))) {
            day6schdSum += parseFloat(day6schdtext);
        }
    });
    $("div.total[data-day='6'][data-type='12']").text(day6schdSum);

    $("div[data-day='6'][data-type='8']").each(function() {
        var day6surydntext = $(this).text();
        if (!isNaN(parseFloat(day6surydntext))) {
            day6surydnSum += parseFloat(day6surydntext);
        }
    });
    $("div.total[data-day='6'][data-type='8']").text(day6surydnSum);

    // Column Count

    var compIdArray = [];

    $('.company-name').each(function(){
        var compid = $(this).attr('data-compid');
        compIdArray.push(compid);
    });
    console.log('compIdArray - '+compIdArray);
    
    var cellVal = 0;

    function setColumncnt() {
        if (compIdArray.length > 0) {
            for (var i = 0; i < compIdArray.length; i++) {
                console.log('Total ColCnt - ' + $("div[data-id='" + compIdArray[i] + "']").length);
                $("div[data-id='" + compIdArray[i] + "']").each(function() {
                    var text = $(this).text().trim(); // Get text and remove leading/trailing whitespace
                    if (text !== '') {
                        var value = parseInt(text);
                        if (!isNaN(value)) {
                            cellVal += value; // Add the parsed value to cellVal
                            console.log('CompId - ' + compIdArray[i] + ' Type - ' + $(this).attr('data-type') + ' ' + 'cellVal - ' + value);
                            console.log('cellVal - ' + cellVal);
                        }
                    }
                });
                console.log('Total ColCnt - ' + $("div[data-id='" + compIdArray[i] + "']").length + ' ' + 'Total Val - ' + cellVal);
                $("div.totalcasecnt[data-id='" + compIdArray[i] + "']").text(cellVal);
                cellVal = 0;
            }
        }
    }

    setColumncnt();

    var totalSum = 0;
    $("div.total").each(function() {
        var totalCnt = $(this).text().trim();
        if (!isNaN(parseInt(totalCnt))) {
            totalSum += parseInt(totalCnt);
        }
    });
    $("div.sumtotalcasecnt").text(totalSum);
</script>
    