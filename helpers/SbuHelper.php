<?php

namespace app\helpers;

use app\models\MasterSbuHead;

Class SbuHelper
{
    public static function getSbuHeadDetails($subHeadId)
    {
        return MasterSbuHead::find()->where(['id' => $subHeadId])->one();
    }
}