 <h4 class="preinspection-box-title">Inspection Photos</h4>
    <div id="inspection_photos" class="preinspection-box" style="margin-bottom: 30px">

        <?php
        foreach($phmodel as $obj)
        {
            $imgUrl = Yii::$app->urlManager->createAbsoluteUrl($qcLoc.$obj->image);
           
            echo '<div class="form-prerow-image">';
           
           
            
            /*echo $form->field($obj, 'image['.$obj->type.']')->widget(FileInput::classname(), [
                            'options' => ['accept' => 'image/*;capture=camera'],
            ])->label($typeName[$obj->type]); */
            echo $form->field($obj, 'image['.$obj->type.']')->widget(FileInput::classname(), [
                'options' => [ 'multiple' => false, 'accept' => 'image/*'],
                'pluginOptions' => [
                        'uploadUrl' => Url::to(['/axion-preinspection/image-upload']),
                        'uploadExtraData' => [
                            'id' => $obj->preinspection_id,
                            'type'=> $obj->type,
                        ],
                       'initialPreview' => [
                            $obj->image ? $imgUrl : null, // checks the models to display the preview
                        ],
                        'allowedFileExtensions' => ["jpg", "jpeg"],
                        //'maxImageWidth' => 500,
                        //'maxImageHeight' => 500,
                        'resizePreference' => 'height',
                        'maxFileCount' => 1,
                        'resizeImage' => true,
                        'resizeIfSizeMoreThan' => 100,
                        'showRemove' => false,
                        'showUpload' => false,
                        'overwriteInitial'=>false,
                        'initialPreviewAsData'=>true,
                        'initialCaption'=>$obj->image ?$obj->type:'',
                        'initialPreviewConfig' => [
                            [
                                'caption' => $obj->locStatus ? $locStatus[$obj->locStatus]." <br>".$timeStatus[$obj->timeStatus]: '', 
                                'size' => '',
                                'url'=> Url::to(['/axion-preinspection/remove-photo']),
                                'key'=> $obj->id,
                            ],

                        ],         
                    ],
            ])->label($typeName[$obj->type]);
           
            
            echo '</div>';
            echo '<div class="clear"></div>';

        }
       
        ?>

     </div>
     
     
     
     
     
     
 Rear View Image
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
 Front Bumper
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
     Rear Bumper
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
 Front Left Corner 45 Degrees
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a></th>
    </table>
    Front Right Corner 45 Degrees
     <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a></th>
    </table>
    Left Side Full View
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
 Right Side Full View
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
     Left Qtr Panel
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
    
    
    Right Qtr Panel
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a></th>
    </table>
    Engine Photo
     <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a></th>
    </table>
    Chassis Plate
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
 Dicky Open Image
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
     Under Chassis
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
    
      Dash Board Photo
     <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a></th>
    </table>
    Odometer Reading
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
 CNG/LPG Kit
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
     RC Copy
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
     Previous Insurance Copy
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
     Dents/Scratch Image 1
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
    Dents/Scratch Image 2
     <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
     Dents/Scratch Image 3
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>     
     
     
     
     
     // fourwheeler  image view 
     
       <table class="table" border="2">
    <th>
    
        <h4 class="preinspection-box-title">Inspection Photos</h4>
    <div id="inspection_photos" class="preinspection-box" style="margin-bottom: 30px">

        <?php
        foreach($phmodel as $obj)
        {
            $imgUrl = Yii::$app->urlManager->createAbsoluteUrl($qcLoc.$obj->image);
            echo '<div class="form-prerow-image">';
            /*echo $form->field($obj, 'image['.$obj->type.']')->widget(::classname(), [
                            'options' => ['accept' => 'image/*;capture=camera'],
            ])->label($typeName[$obj->type]); */
          
            echo $form->field($obj, 'image['.$obj->type.']')->widget(FileInput::classname(), [
                 'disabled' => true,
                'options' => [ 'multiple' => false, 'accept' => 'image/*'],
                'pluginOptions' => [
                        'uploadUrl' => Url::to(['/axion-preinspection/image-upload']),
                        'uploadExtraData' => [
                            'id' => $obj->preinspection_id,
                            'type'=> $obj->type,
                        ],
                       'initialPreview' => [
                            $obj->image ? $imgUrl : null, // checks the models to display the preview
                        ],
                        'allowedFileExtensions' => ["jpg", "jpeg"],
                        //'maxImageWidth' => 500,
                        //'maxImageHeight' => 500,
                        'resizePreference' => 'height',
                        'maxFileCount' => 1,
                        'resizeImage' => true,
                        'resizeIfSizeMoreThan' => 100,
                        'showRemove' => false,
                        'showUpload' => false,
                        'overwriteInitial'=>false,
                        'initialPreviewAsData'=>true,
                        'initialCaption'=>$obj->image ?$obj->type:'',
                        'initialPreviewConfig' => [
                            [
                                'caption' => $obj->locStatus ? $locStatus[$obj->locStatus]." <br>".$timeStatus[$obj->timeStatus]: '', 
                                'size' => '',
                                'url'=> Url::to(['/axion-preinspection/remove-photo']),
                                'key'=> $obj->id,
                            ],

                        ],         
                    ],
            ])->label($typeName[$obj->type]);
           
            
            echo '</div>';
            echo '<div class="clear"></div>';

        }
       
        ?>

     </div>
     
       </th></table>
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     // commercial image view 
     
     
     <table class="table" border="2">
  <th>
    <h4 class="preinspection-box-title">Inspection Photos</h4>
    <div id="inspection_photos" class="preinspection-box" style="margin-bottom: 30px">
    <?php
        foreach($phmodel as $obj)
        {
            $imgUrl = Yii::$app->urlManager->createAbsoluteUrl($qcLoc.$obj->image);
            echo '<div class="form-prerow-image">';
            /*echo $form->field($obj, 'image['.$obj->type.']')->widget(FileInput::classname(), [
                            'options' => ['accept' => 'image/*;capture=camera'],
            ])->label($typeName[$obj->type]); */
            echo $form->field($obj, 'image['.$obj->type.']')->widget(FileInput::classname(), [
                 'disabled' => true,
                'options' => [ 'multiple' => false, 'accept' => 'image/*'],
                'pluginOptions' => [
                        'uploadUrl' => Url::to(['/axion-preinspection/image-upload']),
                        'uploadExtraData' => [
                            'id' => $obj->preinspection_id,
                            'type'=> $obj->type,
                        ],
                       'initialPreview' => [
                            $obj->image ? $imgUrl : null, // checks the models to display the preview
                        ],
                        'allowedFileExtensions' => ["jpg", "jpeg"],
                        //'maxImageWidth' => 500,
                        //'maxImageHeight' => 500,
                        'resizePreference' => 'height',
                        'maxFileCount' => 1,
                        'resizeImage' => true,
                        'resizeIfSizeMoreThan' => 100,
                        'showRemove' => false,
                        'showUpload' => false,
                        'overwriteInitial'=>false,
                        'initialPreviewAsData'=>true,
                        'initialCaption'=>$obj->image ?$obj->type:'',
                        'initialPreviewConfig' => [
                            [
                                'caption' => $obj->locStatus ? $locStatus[$obj->locStatus]." <br>".$timeStatus[$obj->timeStatus]: '', 
                                'size' => '',
                                'url'=> Url::to(['/axion-preinspection/remove-photo']),
                                'key'=> $obj->id,
                            ],

                        ],         
                    ],
            ])->label($typeName[$obj->type]);
           
            
            echo '</div>';
            echo '<div class="clear"></div>';

        }
       
        ?>
     </div>
     </th></table>
     </th></table>
    <div class="clear"></div>
     
     
     
     // commercial plain js camera function 
     
                     Chassis Thumb
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final/index2.php?id='.$premodel->id.'-chassisThumb')?>">    
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
             Rear View Image
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final/index2.php?id='.$premodel->id. '-rearViewImage')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
 Front Bumper
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final/index2.php?id='.$premodel->id. '-frontBumper')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
     Rear Bumper
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final/index2.php?id='.$premodel->id. '-rearBumper')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
 Front Left Corner 45 Degrees
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final/index2.php?id='.$premodel->id. '-frontLeftCorner45')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a></th>
    </table>
    Front Right Corner 45 Degrees
     <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final/index2.php?id='.$premodel->id. '-frontRightCorner45')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a></th>
    </table>
    Left Side Full View
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final/index2.php?id='.$premodel->id. '-leftSideFullView')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
 Right Side Full View
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final/index2.php?id='.$premodel->id. '-rightSideFullView')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
     Left Qtr Panel
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final/index2.php?id='.$premodel->id. '-leftQtrPanel')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
    
    
    Right Qtr Panel
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final/index2.php?id='.$premodel->id. '-rightQtrPanel')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a></th>
    </table>
    Engine Photo
     <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final/index2.php?id='.$premodel->id. '-enginePhoto')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a></th>
    </table>
    Chassis Plate
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final/index2.php?id='.$premodel->id. '-chassisPlate')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
 Dicky Open Image
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final/index2.php?id='.$premodel->id. '-dickyOpenImage')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
     Under Chassis
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final/index2.php?id='.$premodel->id. '-underChassis')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
    
      Dash Board Photo
     <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final/index2.php?id='.$premodel->id. '-dashBoardPhoto')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a></th>
    </table>
    Odometer Reading
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final/index2.php?id='.$premodel->id. '-odometerReading')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
 CNG/LPG Kit
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final/index2.php?id='.$premodel->id. '-cngLpgKit')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
     RC Copy
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final/index2.php?id='.$premodel->id. '-rcCopy')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
     Previous Insurance Copy
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final/index2.php?id='.$premodel->id. '-preInsuranceCopy')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
     Dents/Scratch Image 1
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final/index2.php?id='.$premodel->id. '-dentsScratchImage1')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
    Dents/Scratch Image 2
     <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final/index2.php?id='.$premodel->id. '-dentsScratchImage2')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
     Dents/Scratch Image 3
    <table class="table" border="0">
      <th><a href="<?= Url::to('https://axionpcs.in/camera/final/index2.php?id='.$premodel->id. '-dentsScratchImage3')?>">
    <?= Html::button(Yii::t('app', 'Capture Image'), ['value' => Url::to(''),'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </a>
  </th>
    </table>
