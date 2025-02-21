<?php
include $_SERVER['DOCUMENT_ROOT'] . "/ialertu/config/db.php";

class Settings extends BaseController
{
    public function getacc()
    {
        $conn = $this->_connection();
        session_start();
        $off = $_SESSION['office'];
        $sql = "SELECT * FROM `account` WHERE `office` = $off";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $html = "";
            while ($row = $result->fetch_assoc()) {
                $jsondata = json_encode($row);
                $escapedJsonData = htmlentities($jsondata, ENT_QUOTES);
                $html .= "
                <tr>
                <td> {$row['id']} </td>
                <td> {$row['username']} </td>
                <td> {$row['fname']} </td>
                <td> {$row['mname']} </td>
                <td> {$row['lname']} </td>               
                <td><i class=\"c-pointer me-2 fa-solid fa-pen-to-square\" onclick=\"editacc('$escapedJsonData')\"></i> <i class=\"c-pointer fa-solid fa-key\" style=\"color:#203864;\" onclick=\"updatepass({$row['id']})\"></i></td>
                </tr>
                ";
            }
            return $html;
        }
    }
    public function tabledata()
    {

        echo $this->getacc();
    }
    public function modifyacc($s)
    {


        $conn = $this->_connection();
        if ($s == 0) {
            $idno = $_POST['idno'];
            $uname = $_POST['uname'];
            $fname = $_POST['fname'];
            $mname = $_POST['mname'];
            $lname = $_POST['lname'];
            $sql = "UPDATE `account` SET `username`='$uname',`lname`='$lname',`fname`='$fname',`mname`='$mname' WHERE `id` = $idno";
            $result = $conn->query($sql);
            if ($result) {
                $resp['stat'] = "detupdated";
                $resp['data'] = $this->getacc();
                echo json_encode($resp);
            }
        } else {
            $idnopass = $_POST['idnopass'];
            $oldpass = $_POST['oldpass'];
            $newpass = $_POST['newpass'];
            $sql = "SELECT * FROM `account` WHERE `id` = $idnopass";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if ($oldpass == $row['password']) {
                    $sql = "UPDATE `account` SET `password`='$newpass' WHERE `id` = $idnopass";
                    $result = $conn->query($sql);
                    if ($result) {
                        $resp['stat'] = "passupdated";
                    }
                } else {
                    $resp['stat'] = "passnotupdated";
                }
                echo json_encode($resp);
            }
        }
    }
}
if (isset($_GET['f'])) {
    $g = new Settings();
    switch ($_GET['f']) {
        case 'gaa':
            $g->tabledata();
            break;
        case 'ma':
            $g->modifyacc($_POST['s']);
            break;
    }
}
