<?php
include $_SERVER['DOCUMENT_ROOT'] . "/ialertu/config/db.php";

class Accidentreport extends BaseController
{
    public function emergencyreport($fdata)
    {
        $conn = $this->_connection();
        $jsonData = $fdata;
        $data = json_decode($jsonData, true);
        // $data = [
        //     ["off" => 1],
        //     ["data" => [
        //         "lat" => 13.224275,
        //         "lon" => 120.592684,
        //         "type" => "Vehicular accident",
        //         "num" => 0,
        //         "picture" => 120.5973911,
        //         "uID" => 98
        //     ]]
        // ];
        $office = $data[0]['off'];
        $lat = $data[1]['data']['lat'];
        $lng = $data[1]['data']['lon'];

        $uID = $data[1]['data']['uID'];
        $currentDateTime = new DateTime();
        $url = "https://nominatim.openstreetmap.org/reverse?lat=$lat&lon=$lng&format=json";
        $context = stream_context_create([
            'http' => [
                'user_agent' => 'YourAppName/1.0'
            ]
        ]);
        $response = file_get_contents($url, false, $context);
        $location = "";
        if ($response === FALSE) {
            echo "Error fetching data";
        } else {
            $dataadd = json_decode($response, true);
            if ($dataadd === NULL) {
                echo "Error decoding JSON";
            } else {
                $a = "";
                if (isset($dataadd['address']['quarter'])) {
                    $a = " ".$dataadd['address']['quarter'] . ",";
                } else {
                    $a =  "";
                }
                $location = $this->rsc($dataadd['display_name']);
            }
        }
        $formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');
        if ($office == 0) {
            $accitype = $data[1]['data']['type'];
            $victims = $data[1]['data']['num'];
        } else if ($office == 1) {
            $accitype = $data[1]['data']['est'];
            $victims = $data[1]['data']['col'];
            $uniqueFilename = "";
        }
        $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . "/ialertu/uploads/";
        if (!empty($_FILES['picture']['name'])) {
            $originalFilename = $_FILES['picture']['name'];
            $uniqueIdentifier = md5(uniqid());
            $fileExtension = pathinfo($originalFilename, PATHINFO_EXTENSION);
            $uniqueFilename =  $uniqueIdentifier . '.' . $fileExtension;
            $destinationPath = $uploadDirectory . $uniqueFilename;
            move_uploaded_file($_FILES['picture']['tmp_name'], $destinationPath);
        } else {
            $uniqueFilename = "";
        }
        $sql = "INSERT INTO `tbl_emergency`(`latitude`, `longtitude`, `location`, `name_reporter`, `mobile_number`, `accident_type`, `num_victims`, `image`, `date`,`office`)
        VALUES ('$lat','$lng','$location','$uID','[value-7]','$accitype','$victims','$uniqueFilename','$formattedDateTime','$office')";
        $result = $conn->query($sql);
        if ($result) {
            $lastInsertedId = $conn->insert_id;
        } else {
            echo $conn->error;
        }
        $folderPath = $_SERVER['DOCUMENT_ROOT'] . '/ialertu/assets/files/';
        $fileName = $office . '_' . $lastInsertedId . '_' . md5(uniqid());
        $filePath = $folderPath . $fileName . '.text';

        while (file_exists($filePath)) {
            // If the file exists, generate a new filename
            $fileName = $office . '_' . $lastInsertedId . ' ' . md5(uniqid());
            $filePath = $folderPath . $fileName;
        }

        $this->generatefile($filePath, $fdata, $office);
    }

    public function generatefile($filePath, $fdata, $office)
    {

        $file = fopen($filePath, 'w');
        if ($file) {
            // Write content to the file
            $content = $fdata;
            fwrite($file, $content);
            fclose($file);
            if ($office == 0) {
                echo "Mdrrmo recieve your report!";
            } elseif ($office == 1) {
                echo "BFP recieve your report!";
            }
        } else {
            echo "Error creating the file.";
        }
    }
    public function getallemergencies()
    {
        $folderPath = $_SERVER['DOCUMENT_ROOT'] . '/ialertu/assets/files/';
        $conn = $this->_connection();
        $emergencies = array();
        $new = [];
        session_start();
        if (is_dir($folderPath)) {
            $files = scandir($folderPath);
            $files = array_diff($files, array('..', '.'));

            $index = 0; // Initialize an index counter
            foreach ($files as $file) {
                $filePath = $folderPath . '/' . $file;
                if (is_file($filePath)) {
                    $content = file_get_contents($filePath);
                    $emergencies[$index] = array(
                        'file_name' => $file,
                        'content' => $content
                    );
                    $index++;
                }
            }
            // print_r($emergencies);
            for ($i = 0; $i < count($emergencies); $i++) {
                $file_name = $emergencies[$i]['file_name'];
                $parts = explode("_", $file_name);
                $number = (float)$parts[1];
                $off = $parts[0];
                if ($_SESSION['office'] == $off) {
                    $jsonData = $emergencies[$i]['content'];
                    $decode = json_decode($jsonData, true);
                    if (isset($decode[1]['data'])) {

                        $user = $conn->query("SELECT `image` FROM `tbl_emergency` WHERE `id` = $number");
                        $img = $user->fetch_assoc();
                        $decode[1]['data']['picture'] = $img['image'];

                        $decode[1]['data']['id'] = $number;
                        $decode[1]['data']['o'] = (float)$off;
                        array_push($new, $decode[1]['data']);
                    }
                }
            }
            echo json_encode($new);
        } else {
            echo "The specified folder does not exist.";
        }
    }
    public function updtemerstat($id)
    {
        $conn = $this->_connection();
        $sql = "UPDATE `tbl_emergency` SET `status`= 1 WHERE `id` = $id";
        $result = $conn->query($sql);
        if ($result) {
            $folderPath = $_SERVER['DOCUMENT_ROOT'] . '/ialertu/assets/files/';
            $idToDelete = $id; // Change this to the desired ID

            // Get a list of files in the folder
            $files = scandir($folderPath);

            // Loop through the files and delete the one with the specified ID
            foreach ($files as $file) {
                // Check if the file contains the specified ID
                if (strpos($file, '_' . $idToDelete . '_') !== false) {
                    $filePath = $folderPath . '/' . $file;

                    // Use unlink to delete the file
                    if (unlink($filePath)) {
                        echo "responded";
                    } else {
                        echo "Error deleting file $file.";
                    }
                }
            }
        } else {
            echo "unknownreport";
        }
    }
}
if (isset($_GET['f'])) {
    $g = new Accidentreport();
    switch ($_GET['f']) {
        case 'er':
            $g->emergencyreport($_POST['data']);
            break;
        case 'ger':
            $g->getallemergencies();
            break;
        case 'ues':
            $g->updtemerstat($_POST['id']);
            break;
    }
}

//read file
// $folderPath = '/path/to/your/folder'; // Replace with the actual path to your folder

// // Check if the folder exists
// if (is_dir($folderPath)) {

//     $files = scandir($folderPath);

//     // Remove . and .. from the list of files
//     $files = array_diff($files, array('..', '.'));

//     // Initialize an array to store file contents
//     $fileContents = array();

//     // Loop through each file in the folder
//     foreach ($files as $file) {
//         $filePath = $folderPath . '/' . $file;

//         // Check if it's a file
//         if (is_file($filePath)) {

//             // Get the content of the file
//             $content = file_get_contents($filePath);

//             // Insert content into the array
//             $fileContents[$file] = $content;
//         }
//     }

//     // Now $fileContents contains an array where keys are file names and values are file contents
//     print_r($fileContents);

// } else {
//     echo "The specified folder does not exist.";
// }
