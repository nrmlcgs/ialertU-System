<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/ialertu/view/header.php");
?>

<div class="">
  <button type="button">click me</button>
</div>

<script>
  // function
  let a = {
    data: [{
      "off": 0
    }, {
      "data": {
        "lat": 13.2265,
        "lon": 120.5947,
        "type": "accType",
        "num": " &numnum&",
        "picture": "",
        "uID": ""
      }
    }]
  };
  $.ajax({
    url: `https://mamburao.org/ialertu/Controllers/Accident.php?f=ger`,
    data: a,
    // dataType: 'JSON',
    success: function(response) {
      console.log(response)
    },
    error: function(xhr, status, error) {}
  });
</script>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/ialertu/view/footer.php");
?>

<?php
include $_SERVER['DOCUMENT_ROOT'] . "/ialertu/config/db.php";

class Account extends BaseController
{
    public function lgn($u, $p)
    {
        session_start();
        $conn = $this->_connection();
        $sql = "SELECT * FROM `account` WHERE `username` = '$u' AND `password` = '$p' AND `status` = 0";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['id'] = $row['id'];
            $_SESSION['office'] = $row['office'];
            $resp['stat'] = 'accfound';
            $resp['off'] = $row['office'];
            $resp['u'] = "/ialertu/view/pages/";
            echo json_encode($resp);
        } else {
            $resp['stat'] = 'accnotfound';
            echo json_encode($resp);
        }
        // $this->sendemail();
    }
    public function lgo()
    {
        session_start();
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
        echo "logoutuser";
    }
    public function sendemail()
    {

        $to = "bryyamashita871@gmail.com";
        $subject = "Test email";
        $message = "This is a test email message.";

        $headers = "From: your_email@example.com\r\n";
        $headers .= "Reply-To: your_email@example.com\r\n";
        $headers .= "CC: cc@example.com\r\n";
        $headers .= "BCC: bcc@example.com\r\n";

        // Additional headers to set content type as HTML
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

        $mailSuccess = mail($to, $subject, $message, $headers);

        if ($mailSuccess) {
            echo "Email sent successfully.";
        } else {
            echo "Failed to send email.";
        }
    }
    public function userLogin()
    {
        $conn = $this->_connection();
        $username1 = $_POST['uname'];
        $password1 = $_POST['pass'];
        $resp['status'] = "";
        $resp['data'] = "";
        $sql = "SELECT * FROM account WHERE (`email`='$username1' or `username`='$username1') AND `password`='$password1'";
        $result = $conn->query($sql);
        if ($result) {
            if ($result->num_rows > 0) {
                $data = $result->fetch_assoc();
                $resp['status'] = 'success';
                $resp['data'] = $data;
            } else {
                $resp['status'] = 'failed';
            }
        } else {
            $resp['status'] = 'failed';
        }
        echo json_encode($resp);
    }
    public function getData()
    {

        $conn = $this->_connection();
        $uid = $_POST['uid'];
        $resp['status'] = "";
        $resp['data'] = "";
        $sql = "SELECT * FROM account WHERE  `id`='$uid'";
        $result = $conn->query($sql);
        if ($result) {
            if ($result->num_rows > 0) {
                $data = $result->fetch_assoc();
                $resp['status'] = 'success';
                $resp['data'] = $data;
            } else {
                $resp['status'] = 'failed';
            }
        } else {
            $resp['status'] = 'failed';
        }
        echo json_encode($resp);
    }
    public function checkEmail()
    {
        $conn = $this->_connection();
        $resp['status'] = "";
        $resp['data'] = "";
        try {
            $username1 = $_POST['email'];

            $sql = "SELECT email FROM account WHERE `email`='$username1'";
            $result = $conn->query($sql);
            if ($result) {
                if ($result->num_rows > 0) {
                    $data = $result->fetch_assoc();
                    $resp['status'] = 'exists';
                    $resp['data'] = $data;
                } else {
                    $resp['status'] = 'none';
                }
            } else {
                $resp['status'] = 'error';
            }
            echo json_encode($resp);
        } catch (Exception $e) {
            // Handle database connection or query errors here
            $resp['status'] = "Error: " . $e->getMessage();
            echo json_encode($resp);
        }
    }
    public function createacc()
    {

        $conn = $this->_connection();
        $email = $_POST['email'];
        $username = $_POST['username1'];;
        $password = $_POST['password'];
        $img = $_POST['img'];
        $office = 1;
        $status = 2;
        $lname = $_POST['lname'];
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $suffix = $_POST['suffix'];
        $sex = "1"; //$_POST['sex'];
        $birthday = $_POST['birthday'];
        $mobile_num = $_POST['mobile_num'];
        $province = $_POST['province'];
        $city = $_POST['city'];
        $barangay = $_POST['barangay'];
        $zip_code = $_POST['zip_code'];

        $sqlC = "SELECT email FROM account WHERE `email`='$email'";
        $result = $conn->query($sqlC);
        if ($result) {
            if ($result->num_rows > 0) {
                echo "Exists";
            } else {
                $sql = "INSERT INTO `account` (
                    `username`, 
                    `password`, 
                    `img`, 
                    `office`, 
                    `status`, 
                    `lname`, 
                    `fname`, 
                    `mname`, 
                    `suffix`, 
                    `sex`, 
                    `birthday`,
                    `mobile_num`,
                    `province`, 
                    `city`, 
                    `barangay`, 
                    `zip_code`,
                    `email`) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                // Prepare the statement
                $stmt = $conn->prepare($sql);

                // Bind parameters
                $stmt->bind_param(
                    "sssiissssssssssis",
                    $username,
                    $password,
                    $img,
                    $office,
                    $status,
                    $lname,
                    $fname,
                    $mname,
                    $suffix,
                    $sex,
                    $birthday,
                    $mobile_num,
                    $province,
                    $city,
                    $barangay,
                    $zip_code,
                    $email
                );

                // Execute the statement
                if ($stmt->execute()) {
                    echo $stmt->insert_id;
                } else {
                    echo "Error: " . $sql . "<br>" . $stmt->error;
                }

                // Close the statement and connection
                $stmt->close();
                $conn->close();
            }
        } else {
            echo "Internal Server error2!";
        }
    }
    public function gettorevacc()
    {
        $conn = $this->_connection();
        $sql = "SELECT * FROM `account` WHERE `status` = 2";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $html = "";
            while ($row = $result->fetch_assoc()) {
                $jsondata = json_encode($row);
                $escapedJsonData = htmlentities($jsondata, ENT_QUOTES);
                $html .= "
                <tr>
                <td> {$row['id']} </td>
                <td> {$row['fname']} {$row['mname']} {$row['lname']}</td>
                <td> {$row['Barangay']} </td>
                <td> {$row['province']} </td>
                <td> {$row['City']} </td>
                <td> <i class=\"c-pointer fs-5 text-primary fa-solid fa-file-export\" onclick=\"acctoreview('$escapedJsonData')\"></i> </td>
                </tr>
                
                ";
            }
            return $html;
        }
    }
    public function reviewacc()
    {
        echo $this->gettorevacc();
    }
    public function reviewaccstatus($id, $s)
    {
        $conn = $this->_connection();
        $stat = 2;
        $response = "";
        if ($s == "r") {
            $stat = 3;
            $response = "rejected";
        } else if ($s == "a") {
            $stat = 1;
            $response = "approved";
        }
        $sql = "UPDATE `account` SET `status`= $stat WHERE `id` = $id ";
        $result = $conn->query($sql);
        if ($result) {
            $user = $conn->query("SELECT * FROM `account` WHERE `id` = $id");
            $user = $user->fetch_assoc();
            $fullname = $user['fname'] . " " . $user['mname'] . " " . $user['lname'];
            $resp['stat'] =  $response;
            $resp['data'] = $fullname;
            $resp['html'] = $this->gettorevacc();
        } else {
            $resp['stat'] =  "error";
        }
        echo json_encode($resp);
    }
}
if (isset($_GET['f'])) {
    $g = new Account();
    switch ($_GET['f']) {
        case 'lgn':
            $g->lgn($_POST['user'], $_POST['pass']);
            break;
        case 'lgo':
            $g->lgo();
            break;
        case 'ulgn':
            $g->userLogin();
            break;
        case 'gdt':
            $g->getData();
            break;
        case 'cEm':
            $g->checkEmail();
            break;
        case 'ur':
            $g->reviewacc();
            break;
        case 'ca':
            $g->createacc();
            break;
        case 'rus':
            $g->reviewaccstatus($_POST['id'], $_POST['s']);
            break;
    }
}
