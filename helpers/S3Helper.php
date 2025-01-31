<?php

namespace app\helpers;

use Yii;

Class S3Helper
{
    public static function fileExists($file)
    {
        $s3 = Yii::$app->get('s3');        
        $fileExist = $s3->commands()->exist(\Yii::$app->params['qcLoc'] . basename($file))->execute();

        $fileUrl = $s3->commands()->getUrl(\Yii::$app->params['qcLoc'] . basename($file))->execute();

        if ($fileExist)
        {
            return ['status' => true, 'code' => 200, 'message' => 'Data Exists.', 'data' => ['url' => $fileUrl]];
        }
        else
        {
            return ['status' => false, 'code' => 404, 'message' => 'Data Not Found.', 'data' => ''];
        }
        
    }

    public static function upload($file, $uploadPath)
    {
        $s3 = Yii::$app->get('s3');        
        $s3Upload = $s3->commands()->upload($uploadPath, $file)->execute();

        $result = [ 
            'url' => @$s3Upload['ObjectURL'],
        ];

        if (@$s3Upload['@metadata']['statusCode'] == 200)
        {
            return ['status' => true, 'code' => $s3Upload['@metadata']['statusCode'], 'message' => 'File uploaded successfully.', 'data' => $result];
        }
        else
        {
            return ['status' => false, 'code' => $s3Upload['@metadata']['statusCode'], 'message' => 'File upload failed.', 'data' => $result];
        }
    }

    public static function delete($file)
    {
        $s3 = Yii::$app->get('s3');        
        $s3Delete = $s3->commands()->delete($file)->execute();

        $result = [ 
            'deleted_file' => @$s3Delete['@metadata']['effectiveUri'],
        ];

        if (@$s3Delete['@metadata']['statusCode'] >= 200 && @$s3Delete['@metadata']['statusCode'] <= 300)
        {
            return ['status' => true, 'code' => $s3Delete['@metadata']['statusCode'], 'message' => 'File deleted successfully.', 'data' => $result];
        }
        else
        {
            return ['status' => false, 'code' => $s3Delete['@metadata']['statusCode'], 'message' => 'File delete failed.', 'data' => $result];
        }
    }
}