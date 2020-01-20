<?php
    /*
     * @author LI Qi
     * This important php implements the function to add a new contract
     */
    
    
    include("config.php");
    
    include ("/Library/WebServer/Documents/ntiers/pdf2text/PdfToText.phpclass");
    
    if(isset($_POST['Submit'])) {
        $name = mysqli_real_escape_string($mysqli, $_POST['name']);
        $date = mysqli_real_escape_string($mysqli, $_POST['date']);
        $company = mysqli_real_escape_string($mysqli, $_POST['company']);
        $comment = mysqli_real_escape_string($mysqli, $_POST['comment']);
        
        
        $error = $_FILES['file']['error'];
        $fileName = $_FILES['pdf_file']['name'];
        $tmpName  = $_FILES['pdf_file']['tmp_name'];
        // The temporary filename of the file in which the uploaded file was stored on the server.
        
        if(!get_magic_quotes_gpc())
        {
            $fileName = addslashes($fileName);
        }
        
        if(!empty($fileName)){
            $fp=fopen($tmpName,'rb');
            
            //Convert pdf to blob
            $description_pdf= addslashes(fread($fp,filesize($tmpName)));
            
            //Convert pdf to text
            $pdf = new PdfToText ($tmpName);
            
            $description_text= mysqli_real_escape_string($mysqli,$pdf -> Text);
            
            fclose($fp);
            $description = $fileName;
        }
        
        // flag to show validation or not
        $_POST['state'] = '0';
        $state = mysqli_real_escape_string($mysqli, $_POST['state']);
        
        // checking empty fields
        if(empty($name) || empty($date) || empty($company) || empty($description)|| empty($comment) ) {
            
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
            // if all the fields are not empty
            // insert data to database
            
            $result = mysqli_query($mysqli, "INSERT INTO Contracts (date,company,description,name,comment,state,description_pdf,description_text) VALUES ('$date','$company','$description','$name','$comment','$state','$description_pdf','$description_text')");
            
            // return to the main page
            header("Location: contract.php");
        }
    }
    ?>

<html>
    <head>
        <title>Add Contract</title>
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
            Add a New Contract
        </h1>
        <hr>
        
        <form enctype='multipart/form-data' action="add_contract.php" method="post" name="form1">
            <INPUT TYPE = "hidden" NAME = "MAX_FILE_SIZE" VALUE ="1000000">
                
                <div style="padding: 20px 500px 500px;">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Name</span>
                        </div>
                        <input type="text" name="name" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                    
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Date</span>
                        </div>
                        <input type="date" name="date" class="form-control" aria-label="Sizing example input"  aria-describedby="inputGroup-sizing-default">
                            </div>
                    
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Company</span>
                        </div>
                        <input type="text" name="company" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                    
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Description</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" name="pdf_file" accept=".pdf" class="custom-file-input" id="inputFile01" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                </div>
                    </div>
                    
                    <script>
                        $('#inputFile01').on('change',function(){
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
                        <input type="text" name="comment" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                    
                    <tr>
                        <td></td>
                        <button type="submit" name="Submit" class="btn btn-primary active" tabindex="-1" role="button" aria-pressed="true">Add</button>
                    </tr>
                    
                </div>
                </form>
    </body>
</html>
