<?php
    
    /*
     * @author LI Qi
     * This main page is the Login page to connect to the ldap server
     * and authenticate the user
     * I use the Bootstrap to design the item
     */
    
    //Administrator account and password for managing the LDAP database
    $Manager_id = 'admin';
    $Manager_pw = '123456';
    //$domain is the domain name, the same as dc
    $domain = 'reseaux-os.com';
    $ldapconfig['host'] = '161.3.52.253';
    //If accessing a local server, use localhost, and the port defaults to 389.
    $ldapconfig['port'] = 389;
    $ldapconfig['basedn'] = 'dc=reseaux-os,dc=com';
    
    //Get login username and password from input
    $username = $_POST['name'];
    $password = $_POST['password'];
    
    if(isset($_POST['login'])) {
        if(empty($username) || empty($password)) {
            if(empty($username)) {
                echo '<script>alert("Name field is empty.");</script>';
            }
            else if(empty($password)) {
                echo '<script>alert("Password field is empty.");</script>';
            }
        }
        else{
            //Link LDAP server
            $ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
            
            //Determine if the connection is successful
            if($ds) {
                //                echo "[info]: Connect to LDAP server successful.<br>";
                ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
                
                //Find the user
                
                global $ds,$ldapconfig;
                
                $dnn="cn=".$username;
                $dn=$dnn.','.$ldapconfig['basedn'];
                
                error_reporting(0);
                // ignore the warning
                $bind=ldap_bind($ds, $dn, $password);
                
                //Anonymous binding to ordinary users who can only perform specific operations
                //$bind=ldap_bind($ds);
                if ($bind){
                    // echo "[info]: LDAP bind successful.<br>";
                    // Add the interface for administrator operation
                    $url = "contract.php";
                    echo "<script type='text/javascript'>";
                    echo "window.location.href='$url'";
                    echo "</script>";
                }
                else {
                    echo '<script>alert("LDAP bind failed!Mauvais login ou mot de passe");</script>';
                    //                    echo "[info]: " . ldap_error($ds);
                }
            }
            ldap_close($ds);
        }
    }
    ?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
            <title>Contracts</title>
            </head>
    <body>
        
        <h6 style="margin-top:10%;color:#003E3E;text-align:center;font-size:50px">Welcome to Contracts Systeme!
        </h6>
        
        <div style="margin-left:40%;margin-top:50px;margin-right:40%">
            <form action="index.php" method="post" name="form2">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Name</span>
                    </div>
                    <input type="text" class="form-control" aria-label="Example text with button addon" aria-describedby="button-addon1" name="name">
                        </div>
                
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Password</span>
                    </div>
                    <input type="password" name="password" class="form-control" aria-label="Sizing example input"  aria-describedby="inputGroup-sizing-default">
                        </div>
                
                <button type="submit" name="login" class="btn btn-primary active" tabindex="-1" role="button" aria-pressed="true">Log in</button>
                
            </form>
        </div>
        <div style="font-family:arial;font-size:26px">
            
        </div>
        <div class="card-footer text-muted" style="text-align:center;margin-top:17%">
            <p>
            @ 2020  All Rights Reserved<br>
            Copyright ownership belongs to LI Qi, shall not be reproduced , copied, or used in other ways without permission.
            </p>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
