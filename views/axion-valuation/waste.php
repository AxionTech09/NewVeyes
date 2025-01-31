// if ($premodel->age >= "60") 
           // {
           //  $premodel->syd1to5 = "10";
           // }
           // else if($premodel->age >= "60")
           // {
           //  $premodel->syd6to8 = "5";
           // }
           // else
           // {
           //  // Pcs280117#
           // }
           // if ($premodel->age <= "60")
           // {
           //  $premodel->syd1to5 = "10";
           // }
           // else
           // {
           //  // $premodel->syd6to8 = NULL;
           // }


 //  ->sum('frontBumperBonnet'+'paintCondition'+'rhFenderDoors'+'lhFenderDoors'+'chassisCondition'+'rearBumperBonnet'+'transmissionCondition'+'airCondition'+'interierAccessories'+'chassisAndVehicleFrame'+'brakes+suspension'+'batteryCondition'+'tyreCondition'+'engineCondition'+'seatsCondition+vehicleCondition'+'headLampAndTailLamp') as 'finalRating') 
          //    ->where (['preinspection_id'=$id]);
       
->sum($fbb)+($pc)+$rfd+$lfd+$cc+$rbb+$trc+$ac+$ia+$cvf+$br+$sp+$bc+$tc+$eng+$sc+$vc+$hltl) as $fr) 
             ->where (['preinspection_id'=$id]);



  $weightage = $premodel->weightageValue;
//  if($role == 'Surveyor')
// {
//     $weightageList =[
//       ['id' => '0.25', 'name' => '-1'], //bad
//        ['id' => '1.5' , 'name' => '1'],  //average
//        ['id' => '0.15', 'name' => '2'],  //good
//        ['id' => '0.1', 'name' => '2'],   //good
//     ];
//     $weightageArray = ArrayHelper::map($weightageList = 'id', 'name');
//     return $weightageArray;
// }
//              $premodel->weightage =($weightageArray);



<!-- <div class="form-prerow-other">
        <?= $form->field($model, 'paint')->dropDownList($paintArray) ?>
         </div> -->
          <!-- <div class="form-prerow-other">
        <?= $form->field($model, 'starterMotor')->dropDownList($ltrearArray) ?>
         </div> 
         <div class="form-prerow-other">
        <?= $form->field($model, 'alternator')->dropDownList($ltrearArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'ignitionAndFuelSystem')->dropDownList($ltrearArray) ?>
         </div>-->
         <!-- <div class="form-prerow-other">
        <?= $form->field($model, 'esp')->dropDownList($bagsArray) ?>
         </div> -->
         <!-- <div class="form-prerow-other">
        <?= $form->field($model, 'centerLock')->dropDownList($centreLockArray) ?>
         </div> -->
         <!--<div class="form-prerow-other">
        <?= $form->field($model, 'indicatorLight')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'frontPanel')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'leftApron')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rightApron')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'dicky')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'ltFrontFender')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'ltFrontDoor')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'ltRearDoor')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'ltRunningBoard')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'transmission')->dropDownList($transmissionArray) ?>
         </div>
         
        
         <div class="form-prerow-other">
        <?= $form->field($model, 'ltRear')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'ltQtrPanel')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rtQtrPanel')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rtRearDoor')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rtFrontDoor')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rtFrontPillar')->dropDownList($damageType1Array) ?>
         </div>
       
         <div class="form-prerow-other">
        <?= $form->field($model, 'rtRear')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rtRunningBoard')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rtFrontFender')->dropDownList($damageType1Array) ?>
         </div> -->
         <!-- <div class="form-prerow-other">
        <?= $form->field($model, 'ltRearTyre') ?>
         </div> 
         <div class="form-prerow-other">
        <?= $form->field($model, 'ltFrontTyre') ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rtRearTyre') ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rtFrontTyre') ?>
         </div>
         
         <div class="form-prerow-other">
        <?= $form->field($model, 'windshieldGlassCondition')->dropDownList($damageType3Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'underCarriage')->dropDownList($damageType4Array) ?>
         </div> -->
 <!-- <div class="form-prerow-other">
        <?= $form->field($model, 'rcStatus')->dropDownList($rcstatusArray) ?>
         </div> -->
         <!--  <div class="form-prerow-other">
        <?= $form->field($model, 'hpa')->textInput(['type' => 'number']); ?>
         </div> -->

<?=
if ($premodel->$fixedMarketValue <> $premodel->$systemGeneratedMarketValue) 
{
    echo "You have only change 5% limt";

} 
else 
{
    // echo "a is smaller than b";
}


return [
       [
          'nonmember_name', 
          'required', 
          'when' => function ($model) { 
              return $model->is_member == 2; 
          }, 
          'whenClient' => "function (attribute, value) { 
              return $('#id').val() == '2'; 
          }"
       ]
    ];
?>


         <tr>
        <td style="width:35%;<?php if($model->frontBumperBonnet != 'Safe') echo 'color:red'; ?>">FRONT BUMPER BONNET: <?= $model->frontBumperBonnet; ?></td>
        <td style="<?php if($model->rearBumperBonnet != 'Safe') echo 'color:red'; ?>">REAR BUMPER BONNET: <?= $model->rearBumperBonnet; ?></td>
        
        <td style="<?php if($model->rhFenderDoors != 'Safe') echo 'color:red'; ?>">RH-FENDER DOORS: <?= $model->rhFenderDoors; ?></td>
        <td style="<?php if($model->lhFenderDoors != 'Safe') echo 'color:red'; ?>">LH-FENDER DOORS: <?= $model->lhFenderDoors; ?></td>
    </tr>
    <tr>
        <td style="<?php if($model->engineCondition != 'Safe') echo 'color:red'; ?>">ENGINE CONDITION: <?= $model->engineCondition; ?></td>
        <td style="<?php if($model->chassisCondition != 'Safe') echo 'color:red'; ?>">CHASSIS CONDITION: <?= $model->chassisCondition; ?></td>
        <td style="<?php if($model->brakes != 'Safe') echo 'color:red'; ?>">BRAKES: <?= $model->brakes; ?></td>
        <td style="<?php if($model->suspension != 'Safe') echo 'color:red'; ?>">SUSPENSION: <?= $model->suspension; ?></td>
    </tr>
    <tr>
        <td style="<?php if($model->absDrop != 'Safe') echo 'color:red'; ?>">ABS: <?= $model->absDrop; ?></td>
        <td style="<?php if($model->transmissionCondition != 'Safe') echo 'color:red'; ?>">TRANSMISSION CONDITION: <?= $model->transmissionCondition; ?></td>
        <td style="<?php if($model->airBags != 'Safe') echo 'color:red'; ?>">AIR BAGS: <?= $model->airBags; ?></td>
        <td style="<?php if($model->chassisAndVehicleFrame != 'Safe') echo 'color:red'; ?>">CHASSIS / VEHICLE FRAME: <?= $model->chassisAndVehicleFrame; ?> </td>
         
    </tr>
    <tr>
        <td style="<?php if($model->windShield != 'Safe') echo 'color:red'; ?>">WINDSHIELD: <?= $model->windShield; ?></td>
        <td style="<?php if($model->interierAccessories != 'Safe') echo 'color:red'; ?>">INTERIER ACCESSORIES: <?= $model->interierAccessories; ?></td>
        
        <td style="<?php if($model->seatsCondition != 'Safe') echo 'color:red'; ?>">SEATS CONDITION: <?= $model->seatsCondition; ?></td>
        <td style="<?php if($model->vehicleCondition != 'Safe') echo 'color:red'; ?>">VEHICLE CONDITION: <?= $model->vehicleCondition; ?></td>

    </tr>
    <tr>
        <td style="<?php if($model->paintCondition != 'Safe') echo 'color:red'; ?>">PAINT CONDITION: <?= $model->paintCondition; ?></td>
        <td style="<?php if($model->colour != 'Safe') echo 'color:red'; ?>">COLOUR: <?= $model->colour; ?></td>
        <td style="<?php if($model->batteryCondition != 'Safe') echo 'color:red'; ?>">BATTERY CONDITION: <?= $model->batteryCondition; ?></td>
        <td style="<?php if($model->paint != 'Safe') echo 'color:red'; ?>">PAINT: <?= $model->paint; ?></td>
    </tr>
    <tr>
        <td style="<?php if($model->powerWindows != 'Safe') echo 'color:red'; ?>">POWER WINDOWS: <?= $model->powerWindows; ?></td>
        <td style="<?php if($model->noOfTyre != 'Safe') echo 'color:red'; ?>">NO OF TYRE: <?= $model->noOfTyre; ?></td>
        
        <td style="<?php if($model->hpaStatus != 'Safe') echo 'color:red'; ?>">HPA STATUS: <?= $model->hpaStatus; ?></td>
       
        <td style="<?php if($model->hpaBank != 'Safe') echo 'color:red'; ?>">HPA BANK: <?= $model->hpaBank; ?></td>
        
    </tr>

    <tr>
        <td style="<?php if($model->alloyWheels != 'Safe') echo 'color:red'; ?>">ALLOY WHEELS: <?= $model->alloyWheels; ?></td>
        <td style="<?php if($model->cruiseControl != 'Safe') echo 'color:red'; ?>">CRUISE CONTROL: <?= $model->cruiseControl; ?></td>
        <td style="<?php if($model->airCondition != 'Safe') echo 'color:red'; ?>">AIR CONDITION: <?= $model->airCondition; ?></td>
       
        <td style="<?php if($model->tyreCondition != 'Safe') echo 'color:red'; ?>">TYRE CONDITION: <?= $model->tyreCondition; ?></td>
        
    </tr>
    <tr>
        
       
        <td style="<?php if($model->rcOwnerName != 'Safe') echo 'color:red'; ?>">RC OWNER NAME: <?= $model->rcOwnerName; ?></td>
        <td style="<?php if($model->noOfOwners != 'Safe') echo 'color:red'; ?>">NO OF OWNERS: <?= $model->noOfOwners; ?></td>
        <td style="<?php if($model->insuranceType != 'Safe') echo 'color:red'; ?>">INSURANCE TYPE: <?= $model->insuranceType; ?></td>
       
        <td style="<?php if($model->valuationPrice != 'Safe') echo 'color:red'; ?>">VALUATION PRICE: <?= $model->valuationPrice; ?></td>
        
    </tr>
    <tr>
        <td style="<?php if($model->insuranceDate != 'Safe') echo 'color:red'; ?>">INSURANCE DATE: <?= $model->insuranceDate; ?></td>
        <td style="<?php if($model->vehicleParkingLocation != 'Safe') echo 'color:red'; ?>">VEHICLE PARKING LOCATION: <?= $model->vehicleParkingLocation; ?></td>
        <td style="<?php if($model->taxValidity != 'Safe') echo 'color:red'; ?>">TAX VALIDITY: <?= $model->taxValidity; ?></td>
        <td style="<?php if($model->fcValidity != 'Safe') echo 'color:red'; ?>">FC VALIDITY: <?= $model->fcValidity; ?></td>
        
    </tr>
    <tr>
        <td> <?php if($model->seats != 'Safe'); ?>NO OF SEATS: <?= $model->seats; ?></td>
        <td style="<?php if($model->vehicleType != 'Safe') echo 'color:red'; ?>">VEHICLE TYPE: <?= $model->vehicleType; ?></td>
    </tr>


<script>
    protected function updateFieldexecutivesTask($processModel,$updateType)
    {
        //inserting record
        if($updateType == 'insert')
        {
            $countPosts = FieldexecutivesTasks::find()
                    ->where(['processId' => $processModel->id])
                    ->count();
            
            if($countPosts > 0)
            {
                FieldexecutivesTasks::deleteAll(['processId' => $processModel->id]);
            }

            $model = new FieldexecutivesTasks();
            $model->processId = $processModel->id;
            $model->processNo = $processModel->referenceNo;
            $model->companyName = $processModel->clientName;
            $model->location = $processModel->vehicleLocation;
            $model->customerAppointmentDateTime = $processModel->customerAppointDateTime;
            $model->fieldexecutiveId = $processModel->valuatorName;
            $model->processType = 'PI';
            $model->requestDateTime = $processModel->requestDateTime;
            $model->vehicleNumber = $processModel->registrationNo;
            if($processModel->status == 12)
            {
                $status = 'SCHEDULE';
            }
            else if($processModel->status == 1)
            {
                $status = 'RE-SCHEDULE';
            }
            else if($processModel->status == 8)
            {
                $status = 'COMPLETED';
            }
            else if($processModel->status == 9)
            {
                $status = 'CANCELLED';
            }
            else { $status = '';}
            $model->status = $status;
            $model->save();
             
        }
        
        //deleting record
        if($updateType == 'delete')
        {
             FieldexecutivesTasks::deleteAll(['processId' => $processModel->id]);
        }
        
    }
    </script>
    // ->sum('frontBumperBonnet'+'paintCondition'+'rhFenderDoors'+'lhFenderDoors'+'chassisCondition'+'rearBumperBonnet'+'transmissionCondition'+'airCondition'+'interierAccessories'+'chassisAndVehicleFrame'+'brakes+suspension'+'batteryCondition'+'tyreCondition'+'engineCondition'+'seatsCondition+vehicleCondition'+'headLampAndTailLamp') as 'finalRating') 
             // ->where (['preinspection_id'=$id]);



        1.final rating set condition for +5 and -5
        2.master set no duplicate for make,model,variant,
        3.add fuel type in master
        4.add cubic capacity in master
        5.starting_variant month & year
        6.end variant month & year
        7.syd after 60 month set condition



         
<?php
$script = <<< JS
/*
var elem = document.getElementById("qc");
elem.onchange = function(){
    var hideDiv = document.getElementById("twowheel");
    hideDiv.style.display = (this.value == "2Wheeler") ? "none":"block";
};


var elem = document.getElementById("qc");
elem.onchange = function(){
    var hiddenDiv = document.getElementById("fourwheel");
    hiddenDiv.style.display = (this.value == "4Wheeler") ? "none":"block";
};
*/
JS;
$this->registerJS($script);
?>
     
    <h4 class="preinspection-box-title">Vehicle General Details</h4>
     <div id="inspection_details" class="preinspection-box">
        <div class="form-prerow-other">
                <?= $form->field($model, 'colour') ?>
        </div>
        
        <div class="form-prerow-other">
        <?= $form->field($model, 'odometerReading') ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($model, 'rcVerified')->dropDownList($rcArray) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($model, 'fuelType')->dropDownList($fuelTypeArray)  ?>
        </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'stereoMake')->textInput();?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'otherElectrical')->textInput();?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'fuelTank')->dropDownList($fuelTankArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'frontBumper')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'grill')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'headLights')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'indicatorLights')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'headLights')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'bonnet')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rearBumper')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'tailLamps')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rearViewMirrors')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'spareTyre')->dropDownList($spareTyreArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'tyres')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'dashBoard')->dropDownList($damageType1Array) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'seats')->dropDownList($spareTyreArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'rightWindowGlass')->dropDownList($glassTypeArray) ?>
         </div>
         <div class="form-prerow-other">
        <?= $form->field($model, 'leftWindowGlass')->dropDownList($glassTypeArray) ?>
         </div>
      
         <div class="form-prerow-other">
        <?= $form->field($model, 'frontwsGlassLaminated')->dropDownList($glassTypeArray) ?>
         </div>
         
         <div class="form-prerow-other">
             <?= $form->field($model, 'backGlass')->dropDownList($glassTypeArray) ?>
         </div>

         <div class="form-prerow-other">
             <?= $form->field($model, 'underCarriage')->dropDownList($glassTypeArray) ?>
         </div>

         <div class="form-prerow-other">
              <?= $form->field($model, 'vehicleType')->dropDownList(['prompt' => 'select','4-WHEELER' => '4-WHEELER','2-WHEELER' => '2-WHEELER','Commercial' => 'Commercial']) ?>
         </div>

         <div class="form-prerow-other">     
            <?= $form->field($premodel, 'remarks') ?>
         </div>

        <div class="form-prerow-other">  
             <?= $form->field($premodel, 'status')->dropDownList($statusArray) ?>  
         </div>    

          <?php if($role != 'Customer') { ?>
       
        <div class="form-prerow-other">
            <?= $form->field($premodel, 'surveyorName')->dropDownList($valuatorData);?>
        </div> 

        <?php } ?>
            
        <?php  echo Html::hiddenInput('preinspection_id', $premodel->id, ['id' => 'preinspection_id']); ?> 
      
        </th>  </table>
     </div>

 <table class="table" border="2">
    <th>
        
    <h4 class="preinspection-box-title">2-Wheeler</h4>
    
       <div id="inspection_details" class="preinspection-box">
      
        <div class="form-prerow-other">
        <?= $form->field($twowheelermodel, 'frontMudgaurd')->dropDownList($twowheelerArray) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($twowheelermodel, 'handleBar')->dropDownList($damageType1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($twowheelermodel, 'leverClutchHeadBreak')->dropDownList($damageType1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($twowheelermodel, 'forntHubDiselDrum')->dropDownList($damageType1Array) ?>
        </div>
        
        <div class="form-prerow-other">
        <?= $form->field($twowheelermodel, 'frontWheelRim')->dropDownList($damageType1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($twowheelermodel, 'frontShockAbsorber')->dropDownList($damageType1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($twowheelermodel, 'legGaurd')->dropDownList($damageType1Array) ?>
        </div>
        
        <div class="form-prerow-other">
        <?= $form->field($twowheelermodel, 'leftCoverShield')->dropDownList($damageType1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($twowheelermodel, 'rightCoverShield')->dropDownList($damageType1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($twowheelermodel, 'chassisFrame')->dropDownList($damageType1Array) ?>
        </div>
        
        <div class="form-prerow-other">
        <?= $form->field($twowheelermodel, 'crankCaseCylinder')->dropDownList($damageType1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($twowheelermodel, 'rearWheelRim')->dropDownList($damageType1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($twowheelermodel, 'rearShockAbsorber')->dropDownList($damageType1Array) ?>
        </div>
        
        <div class="form-prerow-other">
        <?= $form->field($twowheelermodel, 'rearDrumDisc')->dropDownList($damageType1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($twowheelermodel, 'chainCover')->dropDownList($damageType1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($twowheelermodel, 'fork')->dropDownList($damageType1Array) ?>
        </div>
        
        <div class="form-prerow-other">
        <?= $form->field($twowheelermodel, 'kickPedal')->dropDownList($damageType1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($twowheelermodel, 'rearcowlLeftCenterRight')->dropDownList($damageType1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($twowheelermodel, 'legshieldLeft')->dropDownList($damageType1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($twowheelermodel, 'legshieldRight')->dropDownList($damageType1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($twowheelermodel, 'fairing')->dropDownList($damageType1Array) ?>
        </div>
        
        <div class="form-prerow-other">
        <?= $form->field($twowheelermodel, 'silencer')->dropDownList($damageType1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($twowheelermodel, 'rearMudguard')->dropDownList($damageType1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($twowheelermodel, 'sareeGuard')->dropDownList($damageType1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($twowheelermodel, 'wisor')->dropDownList($damageType1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($twowheelermodel, 'helmetBox')->dropDownList($damageType1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($twowheelermodel, 'luggageCarrier')->dropDownList($damageType1Array) ?>
        </div>
        


     <?php  echo Html::hiddenInput('preinspection_id', $premodel->id, ['id' => 'preinspection_id']); ?>
        </div>
    </th></table>

<div class="clear"></div>
 


  <table class="table" border="2">
    <th>
    <h4 class="preinspection-box-title">Commercial</h4>
     <div class="preinspection-box">
        
       <div class="form-prerow-other">
        <?= $form->field($commercialwheelermodel, 'typeOfBody')->dropDownList($commercialwheelerArray) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($commercialwheelermodel, 'frontSideBody')->dropDownList($commercialwheeler1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($commercialwheelermodel, 'rightSideBody')->dropDownList($commercialwheeler1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($commercialwheelermodel, 'leftSideBody')->dropDownList($commercialwheeler1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($commercialwheelermodel, 'frontExcavator')->dropDownList($commercialwheeler1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($commercialwheelermodel, 'craneBucket')->dropDownList($commercialwheeler1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($commercialwheelermodel, 'craneHook')->dropDownList($commercialwheeler1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($commercialwheelermodel, 'ac')->dropDownList($commercialwheeler1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($commercialwheelermodel, 'boom')->dropDownList($commercialwheeler1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($commercialwheelermodel, 'fans')->dropDownList($commercialwheeler1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($commercialwheelermodel, 'hydrualicSystem')->dropDownList($commercialwheeler1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($commercialwheelermodel, 'chassisFrame')->dropDownList($commercialwheeler1Array) ?>
        </div>
          <div class="form-prerow-other">
        <?= $form->field($commercialwheelermodel, 'doors')->dropDownList($commercialwheeler1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($commercialwheelermodel, 'excavatorCabinGlass')->dropDownList($commercialwheeler1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($commercialwheelermodel, 'craneCabinGlass')->dropDownList($commercialwheeler1Array) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($commercialwheelermodel, 'extraFittings') ?>
        </div>

     </div>
    </th></table>


 <table class="table" border="2">
    <th>
    <h4 class="preinspection-box-title">4-Wheeler</h4>
     <div class="preinspection-box">
        
       <div class="form-prerow-other">
        <?= $form->field($fwheelermodel, 'ltFrontFender')->dropDownList($fwheelerArray) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($fwheelermodel, 'ltFrontDoor')->dropDownList($fwheelerArray) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($fwheelermodel, 'ltRearDoor')->dropDownList($fwheelerArray) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($fwheelermodel, 'ltRunningBoard')->dropDownList($fwheelerArray) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($fwheelermodel, 'ltPillarDoor')->dropDownList($fwheelerArray) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($fwheelermodel, 'ltPillarCenter')->dropDownList($fwheelerArray) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($fwheelermodel, 'ltPillarRear')->dropDownList($fwheelerArray) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($fwheelermodel, 'ltQtrPanel')->dropDownList($fwheelerArray) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($fwheelermodel, 'rtQtrPanel')->dropDownList($fwheelerArray) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($fwheelermodel, 'rtRearDoor')->dropDownList($fwheelerArray) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($fwheelermodel, 'rtFrontDoor')->dropDownList($fwheelerArray) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($fwheelermodel, 'rtFrontPillar')->dropDownList($fwheelerArray) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($fwheelermodel, 'rtCenterPillar')->dropDownList($fwheelerArray) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($fwheelermodel, 'rtRearPillar')->dropDownList($fwheelerArray) ?>
        </div>

        <div class="form-prerow-other">
        <?= $form->field($fwheelermodel, 'rtRunningBoard')->dropDownList($fwheelerArray) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($fwheelermodel, 'rtFrontFender')->dropDownList($fwheelerArray) ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($fwheelermodel, 'ltRearTyre') ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($fwheelermodel, 'ltFrontTyre') ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($fwheelermodel, 'rtRearTyre') ?>
        </div>
        <div class="form-prerow-other">
        <?= $form->field($fwheelermodel, 'rtFrontTyre') ?>
        </div>