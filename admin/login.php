<?php 
    session_start();
    # Include initial file php to show var and connect database
    include './initial.php';

    $pageTilte = 'Login'; // Change name all pages after finsh

    # Check if user comming from http request method post
    if($_SERVER['REQUEST_METHOD'] == 'POST'):
        # Store and assign variables and filter sanitasize
        $email      = htmlspecialchars(htmlentities(trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL))));
        $password   = htmlspecialchars(htmlentities(trim($_POST['password'])));
    

        # Create array var to store errors and sucsess
        $msg_errors     = [];
        $msg_sucsess    = '';

        # Check on some valid inputs

        # Chek valid email
        if(empty($email)):
            $msg_errors[] = 'Enter your email <srtong> Fill input </strong>';
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)):
            $msg_errors[] = 'Enter <srtong> valid your email </strong>';
        endif;

        # Chek valid password
        if(empty($password)):
            $msg_errors[] = 'Enter your password <srtong> Fill input </strong>';
        elseif(
            filter_var($password, FILTER_VALIDATE_INT) || 
            filter_var($password, FILTER_VALIDATE_EMAIL) ||
            filter_var($password, FILTER_VALIDATE_URL) ||
            filter_var($password, FILTER_VALIDATE_IP)
            ):
            $msg_errors[] = 'Enter valid your password <srtong> used any characters </strong>';
        elseif(strlen($password) < 8):
            $msg_errors[] = 'Password can\'t be less than <srtong> 8 </strong> characters';
        endif;

        # Check if errors message empty 
        if(empty($msg_errors)):
            # Covert password by md5
            $password = md5($password);

            # Select data query
            $sql_select = "SELECT * FROM `blood_donors` WHERE `email` = '$email' AND `password` = '$password'";
            # Srore dada after select
            $result_select = mysqli_query($connect_db, $sql_select);
            

            # Check count row in table database
            if(mysqli_num_rows($result_select) == 1):
                # Convert data to from object to array
                $convert_data = mysqli_fetch_assoc($result_select);

                

                # Stor data info into session
                $_SESSION['donors'] = $convert_data;

                # Redirect location
                header('location: ./index.php');

                
            else:
                # Redirect location
                header('location: ./login.php');
            endif;

            $msg_sucsess ='<div class="alert alert-success px-2">An account has been changed and inserted update successfully</div>';
        endif;
    endif;
?>

<!DOCTYPE html>
<html lang="en">
    <!-- Start head -->
    <?php include $layouts . 'head.php'; ?>
    <!-- End head -->
    <body class="bg-light">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header bg-dark text-light">
                                        <h3 class="text-center font-weight-light my-2">Login</h3>
                                    </div>
                                    <div class="card-body">
                                        <?php if(!empty($msg_errors)): ?>
                                            <div class="alert alert-danger alert-dismissible" role="start">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>

                                                <?php foreach($msg_errors as $erros):
                                                        echo $erros . '<br />';
                                                    endforeach; 
                                                    
                                                ?>
                                            </div>
                                            <?php endif; 
                                                if(isset($msg_sucsess)):
                                                    echo $msg_sucsess;
                                                endif;
                                            ?>
                                            
                                        <form class="" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label class="small mb-1" for="email">Email</label>
                                                <input type="text" name="email" class="form-control py-4" id="email"  placeholder="Enter email .." autocomplete="off" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="password">Password</label>
                                                <input type="text" name="password" class="form-control py-4" id="password"  placeholder="Enter password .." autocomplete="off" />
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" />
                                                    <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="#">Forgot Password?</a>
                                                <button type="submit" class="btn btn-primary">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- <div class="card-footer text-center">
                                        <div class="small"><a href="register.html">Need an account? Sign up!</a></div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
           <!-- Start footer -->
           <?php include $layouts . 'footer.php'; ?>
            <!-- End footer -->
        </div>
        <!-- Start file scripts -->
        <?php include $layouts . 'scripts.php' ?>
    </body>
</html>