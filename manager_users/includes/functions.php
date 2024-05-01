<?php
if (!defined('_CODE')) {
    die('Access denied.....');
}


//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function layouts($layoutName = 'header', $data = [])
{
    if (file_exists(_WEB_PATH_TEMPLATES . "/layout/$layoutName.php")) {
        require_once(_WEB_PATH_TEMPLATES . "/layout/$layoutName.php");
    }
}

// Ham gui mail 
function sendMail($to, $subject, $content)
{


    //Load Composer's autoloader
    // require 'vendor/autoload.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'tranvanhai08032003@gmail.com';                     //SMTP username
        $mail->Password   = 'arlj stzi vrec dcoq';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('tranvanhai08032003@gmail.com', 'Tran Van Hai');
        $mail->addAddress($to);     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->CharSet = "UFT8";
        $mail->isHTML(true);                                  //Set email format to HTML

        $mail->Subject = $subject;
        $mail->Body    = $content;
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        // PHP mailer SSL certificate varify failed
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => false,
            )
        );

        $sendMail = $mail->send();
        return $sendMail;

        // echo 'Message has been sent !';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Kiem tra phuong thuc GET
function isGet()
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        return true;
    }
    return false;
}

// Kiem tra phuong thuc POST
function isPost()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        return true;
    }
    return false;
}

// Ham filter loc du lieu
function filter()
{
    $filterArr = [];
    if (isGet()) {
        // Xu ly du lieu truoc khi hien thi ra
        // return $_GET;
        if (!empty($_GET)) {
            foreach ($_GET as $key => $value) {
                $key = strip_tags($key);
                if (is_array($value)) {
                    $filterArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                } else {
                    $filterArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                }
            }
        }
    }

    if (isPost()) {
        if (!empty($_POST)) {
            foreach ($_POST as $key => $value) {
                $key = strip_tags($key);
                if (is_array($value)) {
                    $filterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                } else {
                    $filterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                }
            }
        }
    }
    return $filterArr;
}

// Kiem tra email
function isEmail($email)
{
    $checkEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
    return $checkEmail;
}

// Ham kiem tra so nguyen INT
function isNumberInt($number)
{
    $checkNumber = filter_var($number, FILTER_VALIDATE_INT);
    return $checkNumber;
}

// Ham kiem tra so thuc FLOAT
function isNumberFloat($number)
{
    $checkNumber = filter_var($number, FILTER_VALIDATE_FLOAT);
    return $checkNumber;
}

// Ham kiem tra so dien thoai co dung ding dang hay khong
function isPhone($phone)
{
    // 0334678234
    $checkZero = false;
    // DK1 : Ky ty dau tien la so 0
    if ($phone[0] == '0') {
        $checkZero = true;
        $phone = substr($phone, 1);
    }

    // DK2 : Dang sau no co 9 chu so
    $checkNumber = false;
    if (isNumberInt($phone) && (strlen($phone) == 9)) {
        return true;
    }

    return false;
}

// Kiem tra thong bao loi
function getSmg($smg, $type = 'success')
{
    echo '<div class="alert alert-' . $type . ' ">
                ' . $smg . '
        </div>';
}

// Ham chuyen huong
function redirect($path = 'index.php')
{
    header("location: $path");
    exit;
}

// Ham thong bao loi
function form_error($fileName, $beforeHtml = '', $afterHtml = '', $errors)
{
    return (!empty($errors[$fileName])) ? $beforeHtml . reset($errors[$fileName]) . $afterHtml : null;
}

// Ham hien thi du lieu cu
function old($fileName, $oldData, $default = null)
{
    return (!empty($oldData[$fileName])) ? $oldData[$fileName] : $default;
}

// Ham kiem tra trang thai dang nhap
function isLogin()
{
    $checkLogin = false;
    if (getSession('loginToken')) {
        $tokenLogin = getSession('loginToken');

        // Kiem tra token co giong trong db khong
        $queryToken = oneRaw("SELECT user_id FROM tokenlogin WHERE token = '$tokenLogin'");

        if (!empty($queryToken)) {
            $checkLogin = true;
        } else {
            removeSession('loginToken');
        }
    }
    return $checkLogin;
}
