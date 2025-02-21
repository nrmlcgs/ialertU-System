<?php
include $_SERVER['DOCUMENT_ROOT'] . "/ialertu/config/db.php";

class Reports extends BaseController
{
    public function chart1_0($year)
    {
        $conn = $this->_connection();
        $types = [
            "Patient Transport", "Floods", "Typhoons or hurricanes", "Landslides", "Vehicle accidents",
            "Building collapses", "Bridge failures", "Mass casualties",
            "Missing persons", "Hiking accidents",
            "Swiftwater rescues", "Boating accidents"
        ];
        $datarray = [];
        for ($i = 0; $i < count($types); $i++) {
            $sql = "SELECT COUNT(*) AS `$types[$i]` FROM `tbl_emergency` WHERE `accident_type` = '$types[$i]' AND YEAR(`date`) = $year ";
            $result = $conn->query($sql);
            if ($result) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $datarray[] = ['type' => $types[$i], 'count' => (float)$row[$types[$i]]];
                }
            } else {
                $datarray[] = ['type' => $types[$i], 'count' => 0];
            }
        }
        return $datarray;
    }
    public function chart2($year, $m)
    {
        $conn = $this->_connection();
      
        $off = $_SESSION['office'];
        $brgy = [
            "Barangay 1", "Barangay 2", "Barangay 3", "Barangay 4", "Barangay 5", "Barangay 6", "Barangay 7",
            "Barangay 8", "Payompon", "Balansay", "Fatima", "Talabaan", "Tangkalan", "San Luis", "Tayamaan",
        ];
        $brgydisplay = [
            "Pob 1", "Pob 2", "Pob 3", "Pob 4", "Pob 5", "Pob 6", "Pob 7", "Pob 8", "Payompon", "Balansay", "Fatima", "Talabaan", "Tangkalan", "San Luis", "Tayamaan",
        ];
        $datarray2 = [];
        foreach ($brgydisplay as $barangay) {
            $datarray2[] = ['barangay' => $barangay, 'count' => 0];
        }
        $sql = "SELECT `location`,`date` FROM `tbl_emergency` WHERE MONTH(`date`) = $m AND YEAR(`date`) = $year AND `office` = $off";
        $result = $conn->query($sql);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $location = $row['location'];
                foreach ($brgy as $index => $barangay) {
                    if (stripos($location, $barangay) !== false) {
                        $datarray2[$index]['count']++;
                    }
                }
            }
        }
        return $datarray2;
    }
    public function chart1_1($year)
    {
        $conn = $this->_connection();
        $types = [
            "House", "Market", "School", "Hospital", "Restaurant", "Retail Store", "Bank", "Coffee Shop", "Others"
        ];

        $datarray = [];
        for ($i = 0; $i < count($types); $i++) {
            $sql = "SELECT COUNT(*) AS `$types[$i]` FROM `tbl_emergency` WHERE `accident_type` = '$types[$i]' AND YEAR(`date`) = $year ";
            $result = $conn->query($sql);
            if ($result) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $datarray[] = ['type' => $types[$i], 'count' => (float)$row[$types[$i]]];
                }
            } else {
                $datarray[] = ['type' => $types[$i], 'count' => 0];
            }
        }
        return $datarray;
    }
    public function getcharts($year, $m, $t)
    {
        session_start();
        $off = $_SESSION['office'];
        if ($off == 1) {
            if ($t == "all") {
                $resp['type_acc'] = $this->chart1_1($year);
                $resp['brgy'] =  $this->chart2($year, $m);
            } elseif ($t == "first") {
                $resp['type_acc'] = $this->chart1_1($year);
            } elseif ($t == "second") {
                $resp['brgy'] =  $this->chart2($year, $m);
            }
        } else {
            if ($t == "all") {
                $resp['type_acc'] = $this->chart1_0($year);
                $resp['brgy'] =  $this->chart2($year, $m);
            } elseif ($t == "first") {
                $resp['type_acc'] = $this->chart1_0($year);
            } elseif ($t == "second") {
                $resp['brgy'] =  $this->chart2($year, $m);
            }
        }


        echo json_encode($resp);
    }
}
if (isset($_GET['f'])) {
    $g = new Reports();
    switch ($_GET['f']) {
        case 'gcd':
            $g->getcharts($_POST['y'], $_POST['m'], $_POST['t']);
            break;
    }
}
