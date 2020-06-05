<?php

//Create message varsd
$msg = '';
//make class for message - green for success and red for fail
$msgClass = '';

//check for submit
if(filter_has_var(INPUT_POST, 'submit')){
    // if submitted get the form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    //do some validation - Check required fields
    //check to see if nothing is empty
    if(!empty($email) && !empty($name) && !empty($message)){
        // If Passed, check to ensure user has a valid email
        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            //Failed
            $msg = 'Please enter a valid email';
            //set class for message
            $msgClass = 'alert-danger';
        }else{
            //passed
            //Set up recipient email
            $toEmail = 'supprt@me.com';
            $subject = 'Cntact request from'.$name;
            $body= 
            '<h2> Contact request </h2>
            <h4>NAME: </h4><p>'.$name.'</p>
            <h4>EMAIL: </h4><p>'.$email.'</p>
            <h4>MESSAGE: </h4><p>'.$message.'</p>
            ';

            //Email Headers
            $headers = "MINE-Version: 1.0"."\r\n";
            // .= means append
            $headers .= "Content-Type:text/html;charset=UTF-8"."/r/n";

            //additional headers
            $headers .="From: ".$name."<".$email.">"."\r\n";

            //if statement for mail function
            //if it sends
            if(mail($toEmail, $subject, $body, $headers)){
                //Email sent
                $msg = 'Your email has been sent!';
                //set class for message
                $msgClass = 'alert-success';
            }else{
                //Failed
                $msg = 'Your email was not sent';
                //set class for message
                $msgClass = 'alert-danger';
            }
        }
    }else{
        //Failed
        $msg = 'Please enter all fields';
        //set class for message
        $msgClass = 'alert-danger';

    }
}


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Contact us</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-default navbar-dark bg-dark">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">my Website</a>
            </div>
        </div>
    </nav> 
    <br>
    <div class="container">

    <!-- If message is not empty -->
    <?php if($msg != ''): ?>
        <div class="alert <?php echo $msgClass; ?>">
            <?php echo $msg; ?>
        </div>
    <?php endif; ?>
    <!-- !!!!!!!!!!!!!!!!!!!!! -->
    

        <form  method="post" action=" <?php echo $_SERVER['PHP_SELF']; ?> ">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" 
                value="<?php echo isset($_POST['name']) ? $name : ''; ?>">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? $email : ''; ?>">
            </div>
            <div class="form-group">
                <label>Message</label>
                <textarea name="message" class="form-control"><?php echo isset($_POST['message']) ? $message : ''; ?></textarea>
            </div>
            <br>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            
        
        </form>
    
    
    </div>
    
</body>
</html>