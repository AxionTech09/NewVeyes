<?php

namespace app\controllers;

use yii\web\Controller;

class CronController extends Controller
{
    public function actionS3Migration($folder = '')
    {

        $selectedFolders = $totalFiles = [];
        switch ($folder)
        {
            case 'conveyance_images':
                $selectedFolders[] = 'conveyance_images';
                break;
            
            case 'qcphotos':
                $selectedFolders[] = 'qcphotos';
                break;

            case 'api-uploads':
                $selectedFolders[] = 'api-uploads';
                break;

            default:
                $selectedFolders = ['conveyance_images', 'qcphotos', 'api-uploads'];
        }
        foreach ($selectedFolders as $selectedFolder)
        {
            $localSource = '/var/www/sitara-pi/' . $selectedFolder;
            $s3Destination = 's3://sitara-preinspection/' . $selectedFolder;
            $regex = 's3:\/\/sitara-preinspection\/' . $selectedFolder;
    
            $files = glob($localSource.'/*');
            
            $totalFiles = $this->readFiles($files);
            echo "Total files in $localSource is: " .(count($totalFiles)) . '<br>';
            
            if (count($totalFiles) > 0)
            {
                // Upload the files to S3.
                $output = shell_exec('aws s3 cp ' . $localSource . ' ' . $s3Destination . ' --recursive 2>&1');
                $fh = fopen($selectedFolder.'_files.txt', 'a');
                fwrite($fh, $output);
                fclose($fh);
        
                if (preg_match_all("/$regex/i", $output, $result))
                {
                    echo 'Total files uploaded to S3 is : ' .(count($result[0])) . '<br>';
        
                    if (count($totalFiles) == count($result[0]))
                    {
                        $localFiles = glob($localSource); // get all file names
                        //$this->deleteFiles($localFiles);
                        $this->deleteFiles($localSource);
                    }
                }
            }
        }
    }

    private function readFiles($files) {
        static $totalFiles = [];

        foreach ($files as $file) {
            if ($file != '.' && $file != '..')
            {
                if (is_dir($file))
                {
                    $subFiles = glob($file.'/*');
                    $this->readFiles($subFiles);
                }
                else
                {
                    $i++;
                    $totalFiles[] = $file;
                }
            }
        }
        return @$totalFiles;
    }

    private function deleteFiles($files) {    
        if ($files == '/var/www/veyes/api-uploads')
            $duration = '0';
        else
            $duration = '2';
        
        $output = shell_exec('find '. $files .' -type f -mtime +'. $duration .' -delete');
        /* foreach($files as $file) { // iterate files
            if (is_dir($file))
            {
                $subFiles = glob($file.'/*');
                $this->deleteFiles($subFiles);
            }
            else {
                unlink($file); // delete file
            }
        } */
    }
}
?>