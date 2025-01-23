<?php
use yii\helpers\Html;
use rmrevin\yii\fontawesome\FA;
use rmrevin\yii\fontawesome\FAS;
use rmrevin\yii\fontawesome\FAR;
use app\helpers\S3Helper;

$typeName = $imageList[0]->typeName;
$qcLoc = \Yii::$app->params['qcLoc'];
$s3BaseUrl = \Yii::$app->params['s3Bucket'].'.s3.'.\Yii::$app->params['s3Region'].'.amazonaws.com/';
?>


<div class="uploaded-images">
  
    <div id="Image_list" class="panel panel-primary pb-15">
      <div class="panel-heading light-panel-heading pb-15 pt-15">
        <h4 class="panel-title">Images</h4>
      </div>

      <div class="panel-body">
        <div class="text-center">
          <h4 class="text-primary mt-15 mb-15 border-bottom-gold d-inline-block">Registration No : <?= $premodel->registrationNo ?></h4>
        </div>
        <?php
          
          foreach ($imageList as $key => $images) { 
            $imgId = str_ireplace(['.png', '.jpg', '.jpeg'], ['', '', ''], $images->image);

            if ($images->image != '')
            {
                $imgUrl = $s3BaseUrl . $qcLoc . $images->image;
                $s3FileExists =  S3Helper::fileExists($imgUrl);

                if ($s3FileExists['status'])
                {
                  $imgUrl = $s3FileExists['data']['url'];
                }
                else
                {
                  $imgUrl = Yii::$app->urlManager->createAbsoluteUrl($qcLoc . $images->image);
                }
            }
            else {
                $imgUrl = '';
            }   ?> 
                <div class="col-md-3"> 
                    <div class="actual-image-label text-success mt-25"><?= $typeName[$images->type]; ?></div>
                    <div class="actual-image-frame mb-25"> 
                        <div class="ez-plus-zoom-container <?= ($imgUrl != '') ? 'actual-img lightboxed' : '' ?>">
                            <img src="<?=($imgUrl) ? $imgUrl : Yii::$app->urlManager->createAbsoluteUrl('images/No_Image.jpg');?>" id="ez-plus-zoom-<?=$z?>" <?= ($imgUrl != '') ? 'alt="' . $obj->type . '"' : ''; ?> class="<?=($imgUrl) ? 'ez-plus-zoom' : ''?>" data-zoom-image="<?=($imgUrl) ? $imgUrl : Yii::$app->urlManager->createAbsoluteUrl('images/No_Image.jpg');?>" height="230" width="100%">
                        </div>
                    </div>
                </div>
            <?php 
          } ?>

      </div>
    </div>
  
</div>


<?php
$script = <<< JS

$(function() {

    let documentWidth = $(document).width();

    if (documentWidth > 767)
    {
        $('.ez-plus-zoom').ezPlus({
            scrollZoom: true,
            tint: true,
            tintColour: '#f7f7f7', tintOpacity: 0.5,
            zoomWindowPosition: 11,
            zoomWindowHeight: 250,
            zoomWindowWidth: 300,
            zIndex: 1001
        });
    }
    else
    {
        $('.ez-plus-zoom').ezPlus({
            zoomType: 'lens',
            lensShape: 'round',
            lensSize: 200,
            zoomWindowWidth: 100,
            zIndex: 1001
        });
    }

    $(document).on('change', 'input[type="checkbox"]', function() {
        
        if ($(this).is(':checked'))
        {
        $('button[type="submit"]').prop('disabled', false);
        }
        else
        {
        $('button[type="submit"]').prop('disabled', true);
        }
        
        if ($(this).attr('id') == 'select-all-online-ngi-pic')
        {
        if ($(this).is(':checked'))
        {
            $('.online-ngi-pic').prop('checked', true);
        }
        else 
        {
            $('.online-ngi-pic').prop('checked', false);
        }
        }

        else if ($(this).attr('id') == 'select-all-online-client-pic')
        {
        if ($(this).is(':checked'))
        {
            $('.online-client-pic').prop('checked', true);
        }
        else {
            $('.online-client-pic').prop('checked', false);
        }
        }
        
    });
});


JS;
$this->registerJS($script);