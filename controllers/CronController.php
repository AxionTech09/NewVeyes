<?php

namespace app\controllers;

use yii\web\Controller;

class CronController extends Controller
{
    public function actionS3Migration($folder = '')
    {
        putenv('AWS_DEFAULT_REGION=ap-south-1');
        putenv('AWS_ACCESS_KEY_ID=AKIA6JKEX3CUTPKXZEGJ');
        putenv('AWS_SECRET_ACCESS_KEY=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');

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
            $localSource = '/var/www/pitest/' . $selectedFolder;
            $s3Destination = 's3://axion-preinspection/' . $selectedFolder;
            $regex = 's3:\/\/axion-preinspection\/' . $selectedFolder;
    
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
            // if (count($totalFiles) > 0)
            // {
            //     echo "Total files to upload: " . count($totalFiles) . "<br>";

            //     // Upload the files to S3.
            //     echo "Executing S3 upload command...<br>";
            //     $command = 'aws s3 cp ' . $localSource . ' ' . $s3Destination . ' --recursive 2>&1';
            //     echo "Command: " . $command . "<br>";
                
            //     $output = shell_exec($command);
                
            //     echo "S3 Command Output:<br><pre>$output</pre>";

            //     // Logging the output to a file
            //     $logFile = $selectedFolder . '_files.txt';
            //     echo "Logging output to: " . $logFile . "<br>";
                
            //     $fh = fopen($logFile, 'a');
            //     fwrite($fh, $output);
            //     fclose($fh);

            //     // Check the uploaded files count
            //     if (preg_match_all("/$regex/i", $output, $result))
            //     {
            //         echo "Total files uploaded to S3: " . count($result[0]) . "<br>";

            //         if (count($totalFiles) == count($result[0]))
            //         {
            //             echo "Upload count matches expected count. Proceeding with deletion...<br>";
                        
            //             // Debugging local file deletion
            //             echo "Checking local files before deletion...<br>";
            //             $localFiles = glob($localSource);
            //             echo "Files found for deletion: <pre>" . print_r($localFiles, true) . "</pre>";

            //             //$this->deleteFiles($localFiles); // Original commented-out line
            //             echo "Calling deleteFiles function with: $localSource <br>";
            //             $this->deleteFiles($localSource);
            //         }
            //         else
            //         {
            //             echo "Mismatch in uploaded files count. Skipping deletion.<br>";
            //         }
            //     }
            //     else
            //     {
            //         echo "No files matched the regex pattern. Check regex or upload status.<br>";
            //     }
            // }
            // else
            // {
            //     echo "No files to upload.<br>";
            // }
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
        if ($files == '/var/www/pitest/api-uploads')
            $duration = '0';
        else
            $duration = '2';
        
        // $output = shell_exec('find '. $files .' -type f -mtime +'. $duration .' -delete');
        // foreach($files as $file) { // iterate files
        //     if (is_dir($file))
        //     {
        //         $subFiles = glob($file.'/*');
        //         $this->deleteFiles($subFiles);
        //     }
        //     else {
        //         unlink($file); // delete file
        //     }
        // }
    }

    // private function deleteFiles($files) {    
    //     echo "Checking path: $files\n"; // Debugging statement
    
    //     if ($files == '/var/www/pitest/api-uploads') {
    //         $duration = '0';
    //     } else {
    //         $duration = '2';
    //     }
    
    //     echo "Retention duration: $duration days\n";
    
    //     // Execute shell command to delete files older than duration
    //     $command = 'find ' . $files . ' -type f -mtime +' . $duration . ' -delete';
    //     echo "Executing command: $command\n"; 
    //     $output = shell_exec($command);
    //     echo "Shell command output: $output\n";
    
    //     // Check if $files is an array or a string
    //     if (!is_array($files)) {
    //         echo "Converting string to array...\n";
    //         $files = glob($files . '/*'); // Convert to an array of file paths
    //     }
    
    //     foreach ($files as $file) { // Iterate files
    //         echo "Processing file/directory: $file\n";
            
    //         if (is_dir($file)) {
    //             echo "Entering directory: $file\n";
    //             $subFiles = glob($file . '/*');
    //             $this->deleteFiles($subFiles); // Recursive call
    //         } else {
    //             if (file_exists($file)) {
    //                 echo "Deleting file: $file\n";
    //                 unlink($file); // Delete file
    //             } else {
    //                 echo "File not found: $file\n";
    //             }
    //         }
    //     }
    //     echo "Deletion process completed.\n";
    // }
}
?>