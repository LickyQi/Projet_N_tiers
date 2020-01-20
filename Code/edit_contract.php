<?php
    
    /*
     * @author LI Qi
     * This important php show the page to edit a existing contract
     * Most of the part of this PHP are same to the add_contract.php
     */
    
    
    // The first part is different
    // because that edit the contract should selecte the contract from Mysql
    // and the to update it
    
    include_once("config.php");
    $id = $_GET['id'];
    //selecting data associated with this particular id
    $result = mysqli_query($mysqli, "SELECT * FROM Contracts WHERE id=$id");
    
    if(!empty($result)){
        while($res = mysqli_fetch_array($result)){
            $name = $res['name'];
            $date = $res['date'];
            $company = $res['company'];
            $description = $res['description'];
            $description_pdf = $res['description_pdf'];
            $comment = $res['comment'];
        }
    }
    
    // to update the contract
    if(isset($_POST['update'])){
        
        $id = mysqli_real_escape_string($mysqli, $_POST['id']);
        
        $name = mysqli_real_escape_string($mysqli, $_POST['name']);
        $date = mysqli_real_escape_string($mysqli, $_POST['date']);
        $company = mysqli_real_escape_string($mysqli, $_POST['company']);
        $comment = mysqli_real_escape_string($mysqli, $_POST['comment']);
        
        $fileName = $_FILES['pdf_file']['name'];
        $tmpName  = $_FILES['pdf_file']['tmp_name'];
        //  The temporary filename of the file in which the uploaded file was stored on the server.
        
        // to avoid the error caused by the path of the pdf file
        if(!get_magic_quotes_gpc())
        {
            $fileName = addslashes($fileName);
        }
        
        if(!empty($fileName)){
            $fp=fopen($tmpName,'rb');
            $description_pdf= addslashes(fread($fp,filesize($tmpName)));
            fclose($fp);
            $description = $fileName;
        }
        
        // checking empty fields
        if(empty($name) || empty($date) || empty($company) || empty($description)|| empty($comment)) {
            
            if(empty($name)) {
                echo '<script>alert("Name field is empty.");</script>';
            }
            
            else if(empty($date)) {
                echo '<script>alert("Date field is empty.");</script>';
            }
            
            else if(empty($company)) {
                echo '<script>alert("Company field is empty.");</script>';
            }
            
            else if(empty($description)) {
                echo '<script>alert("Description field is empty.");</script>';
            }
            
            else if(empty($comment)) {
                echo '<script>alert("Comment field is empty.");</script>';
            }
            
            //link to the previous page
            echo '<script>self.history.back(-1);</script>';
        }
        else {
            //updating the table
            $result = mysqli_query($mysqli, "UPDATE Contracts SET name='$name',date='$date',company='$company',description_pdf='$description_pdf', comment= '$comment',description='$description' WHERE id=$id");
            
            //return to the main page
            header("Location: contract.php");
        }
    }
    ?>

<html>
    <head>
        <title>Edit Contract</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
            </head>
    
    <body>
        <div style="margin-top:30px;margin-left:30px">
            <a href="contract.php" class="btn btn-primary btn-sm active" tabindex="-1" role="button" aria-pressed="true">Home</a>
        </div>
        <br/><br/>
        
        <h1 style="font-family:cabri;color:#003E3E;text-align:center;font-size:40px">
            Edit This Contract
        </h1>
        <hr>
        
        <form enctype='multipart/form-data' name="form2" method="post" action="edit_contract.php">
            <INPUT TYPE = "hidden" NAME = "MAX_FILE_SIZE" VALUE ="1000000">
                
                <div style="padding: 20px 500px 500px;">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Name</span>
                        </div>
                        <input type="text" id="name" name="name" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="<?php echo $name;?>">
                            </div>
                    
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Date</span>
                        </div>
                        <input type="date" name="date" class="form-control" aria-label="Sizing example input"  aria-describedby="inputGroup-sizing-default" value="<?php echo $date;?>">
                            </div>
                    
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Company</span>
                        </div>
                        <input type="text" name="company" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="<?php echo $company;?>">
                            </div>
                    
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Description</span>
                        </div>
                        
                        <div class="custom-file">
                            <input type="file" name="pdf_file" accept=".pdf" class="custom-file-input" id="inputFile02" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                </div>
                    </div>
                    
                    <script>
                        $('#inputFile02').on('change',function(){
                                             //get the file name
                                             var fileName = $(this).val().replace('C:\\fakepath\\', " ");;
                                             //replace the "Choose a file" label
                                             $(this).next('.custom-file-label').html(fileName);
                                             })
                        </script>
                    
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Comment</span>
                        </div>
                        <input type="text" name="comment" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="<?php echo $comment;?>">
                            </div>
                    
                    <tr>
                        <td></td>
                        <td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>
                        <button type="submit" name="update" class="btn btn-primary active" tabindex="-1" role="button" aria-pressed="true">Update</button>
                    </tr>
                    
                </div>
                </form>
        
    </body>
</html>

