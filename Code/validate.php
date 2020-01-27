<?php
    
    /*
     * @author LI Qi
     * This php implements a function to validate a contract
     * and to sent a e-mail to inform
     * I use PHPMailer and Google Email API to realise this function.
     */
    
    /*
     * I use PHPMailer and Gmail-API to sent the e-mail
     */
    
    // Import PHPMailer classes into the global namespace
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    // Load Composer's autoloader
    require './PHPMailer/src/Exception.php';
    require './PHPMailer/src/PHPMailer.php';
    require './PHPMailer/src/SMTP.php';
    
    //including the database connection file
    include_once("config.php");
    
    $id = $_GET['id'];
    
    // flag to show validation or not
    // 0 - no validation ; 1 - validation ;
    $state = mysqli_real_escape_string($mysqli, '1');
    
    $result_state = mysqli_query($mysqli, "SELECT * FROM Contracts WHERE id=$id");
    $res = mysqli_fetch_array($result_state);
    $state_old = $res['state'];
    
    if($state_old=='1'){
        echo '<script>alert("Canot validate the contract twice!");location.href="contract.php";</script>';
    }
    else{
        //updating the table
        $result = mysqli_query($mysqli, "UPDATE Contracts SET state= '$state' WHERE id=$id");
        
        //send E-mail to informe
        if (isset($_POST['send_email'])){
            $email_add = mysqli_real_escape_string($mysqli, $_POST['email']);
            if(empty($email_add)){
                echo '<script>alert("Email Address field is empty.");</script>';
            }
            else{
                // Instantiation and passing `true` enables exceptions
                $mail = new PHPMailer(true);
                
                try {
                    //Server settings
                    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = 'contarct.test@gmail.com';                     // SMTP username
                    $mail->Password   = 'telecomst';                               // SMTP password
                    $mail->SMTPSecure = 'PHPMailer::ENCRYPTION_STARTTLS';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
                    $mail->Port       = 587;                                    // TCP port to connect to
                    
                    //Recipients
                    $mail->setFrom('contarct.test@gmail.com', 'testContract');
                    $mail->addAddress($email_add);     // Add a recipient
                    //$mail->addAddress('ellen@example.com');               // Name is optional
                    $mail->addReplyTo('contarct.test@gmail.com', 'Information');
                    //$mail->addCC('cc@example.com');
                    //$mail->addBCC('bcc@example.com');
                    
                    // Attachments
                    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
                    
                    // Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'Validation of your contract';
                    $mail->Body    = '<b>Your contract has already been validation!</b>';
                    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                    
                    $mail->send();
                    echo '<script>alert("The Message has been sent!");location.href="contract.php";</script>';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
        }
    }
    ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Validation</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
            </head>
    <body>
        <div style="margin-top:30px;margin-left:30px">
            <a href="contract.php" class="btn btn-primary btn-sm active" tabindex="-1" role="button" aria-pressed="true">Back</a>
        </div>
        <br/>
        <h1 style="font-family:cabri;color:#003E3E;text-align:center;font-size:60px">
            The Contract has already been validation !
        </h1>
        <h1 style="font-family:cabri;color:#003E3E;text-align:center;font-size:30px">
            Do you want to send a email?
        </h1>
        <tr>
            <form action="validate.php" method="post" style="text-align:center">
                <div style="padding: 20px 500px 500px;">
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                            </div>
                    <button type="submit" name="send_email" class="btn btn-primary btn-lg active" tabindex="-1" role="button" aria-pressed="true">Submit</button>
                </div>
            </form>
        </tr></br>
        
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
