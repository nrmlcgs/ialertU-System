<?php
include $_SERVER['DOCUMENT_ROOT'] . "/ialertu/config/db.php";

class Records extends BaseController
{
    public function tabledata()
    {
        session_start();
        $conn = $this->_connection();
        $o = $_SESSION['office'];
        $sql = "SELECT * FROM `tbl_emergency` WHERE `office` = $o";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $html = "";
            while ($row = $result->fetch_assoc()) {
                $jsondata = json_encode($row);
                $name = (float)$row['name_reporter'];
                $user = $conn->query("SELECT * FROM `account` WHERE `id` = $name");
                $username = $user->fetch_assoc();
                // print_r($username['fname'] );
                $usename = $username['fname'] . " " . $username['mname'] . " " . $username['lname'];
                $escapedJsonData = htmlentities($jsondata, ENT_QUOTES);
                $html .= "
                <tr>
                <td> {$row['id']} </td>
                <td> {$row['location']} </td>
                <td> {$row['accident_type']} </td>
                <td> {$row['num_victims']} </td>
                <td> {$row['date']} </td>               
                <td> <i class=\"c-pointer fs-5 text-primary fa-solid fa-file-export\" onclick=\"viewreport('$escapedJsonData','$usename')\"></i> </td>
                </tr>
                
                ";
            }
            echo $html;
        }
    }
}
if (isset($_GET['f'])) {
    $g = new Records();
    switch ($_GET['f']) {
        case 'gtd':
            $g->tabledata();
            break;
    }
}
