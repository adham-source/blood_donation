<?php 
    # Include initial file php to show var and connect database
    include './initial.php';    

    # Check if user comming from http request method post
    if($_SERVER['REQUEST_METHOD'] == 'POST'):

        # Store and assign variables and filter sanitasize
        $name       = htmlspecialchars(htmlentities(trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING))));
        $email      = htmlspecialchars(htmlentities(trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL))));
        $password   = htmlspecialchars(htmlentities(trim($_POST['password'])));
        $phone      = htmlspecialchars(htmlentities(trim($_POST['phone'])));
        $address    = htmlspecialchars(htmlentities(trim($_POST['address'])));
        $gender     = htmlspecialchars(htmlentities(trim($_POST['gender'])));
        $types      = htmlspecialchars(htmlentities(trim($_POST['types'])));
        $roles      = htmlspecialchars(htmlentities(trim($_POST['roles'])));


        # Create array var to store errors and sucsess
        $msg_errors     = [];
        $msg_sucsess    = '';

        # Check on some valid input
        # Chek valid name
        if(empty($name)):
            $msg_errors[] = 'Enter your name <srtong> Fill input </strong>';
        elseif(
            filter_var($name, FILTER_VALIDATE_INT) || 
            filter_var($name, FILTER_VALIDATE_EMAIL) ||
            filter_var($name, FILTER_VALIDATE_URL) ||
            filter_var($name, FILTER_VALIDATE_IP)
            ):
            $msg_errors[] = 'Enter <srtong> valid your name </strong>';
        // else:
        //     $msg_sucsess[] = '<div class="alert alert-success">A name has been added successfully</div>';
        endif;

        # Chek valid email
        if(empty($email)):
            $msg_errors[] = 'Enter your email <srtong> Fill input </strong>';
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)):
            $msg_errors[] = 'Enter <srtong> valid your email </strong>';
        // else:
        //     $msg_sucsess[] = '<div class="alert alert-success">A email has been added successfully</div>';
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
        // else:
        //     $msg_sucsess[] = '<div class="alert alert-success">A password has been added successfully</div>';
        endif;

        # Chek valid phone
        if(empty($phone)):
            $msg_errors[] = 'Enter your phone <srtong> Fill input </strong>';
        elseif(
            !filter_var($phone, FILTER_VALIDATE_INT) ||
            filter_var($phone, FILTER_VALIDATE_EMAIL) ||
            filter_var($phone, FILTER_VALIDATE_URL) ||
            filter_var($phone, FILTER_VALIDATE_IP)
            ):
            $msg_errors[] = 'Enter valid your phone <srtong> used any number </strong>';
        elseif(strlen($phone) >= 15):
            $msg_errors[] = 'Phone can\'t be larger than <srtong> 15 </strong> number';
        // else:
        //     $msg_sucsess[] = '<div class="alert alert-success">A password has been added successfully</div>';
        endif;

        # Chek valid gender
        if(empty($gender)):
            $msg_errors[] = 'Select gender <srtong> Fill input </strong>';
        endif;

        # Chek valid address
        if(empty($address)):
            $msg_errors[] = 'Select country <srtong> Fill input </strong>';
        endif;

        # Chek valid types
        if(empty($types)):
            $msg_errors[] = 'Select blood of type <srtong> Fill input </strong>';
        endif;

        # Data info to use image upload 
        $nTmpPath = $_FILES['image']['tmp_name'];
        $nImageMain = $_FILES['image']['name'];
        $typeImage = $_FILES['image']['type'];
        $sizeImage = $_FILES['image']['size'];

        # Export ext from file image
        $extImage = explode('.', $nImageMain);

        # Store ext file image
        $exCurrent = count($extImage);

        # Var to use check ext allowed
        $ext_image = strtolower($extImage[$exCurrent - 1]);

        # Store new image name
        $new_name_img = time() .'_Img_.'. $ext_image;

        # Store image upload mandatory extensios
        $allowExtImages = [
            'jpeg',
            'png',
            'jpg',
            'gif'
        ];


        # input image file upload conditions
        if($sizeImage === 0):
            $msg_errors[] = 'Upload file any image';
        elseif(in_array($ext_image, $allowExtImages)):
            # Save image in directory
            $imagesUpload;

            # path dir with image name
            $pathDirNew = $imagesUpload.$new_name_img;
            
            move_uploaded_file($nTmpPath, $pathDirNew);

        else:
            $msg_errors[] = 'Please upload valid <strong> extinsion </strong> image';
        endif;

        # Check if errors message empty 
        if(empty($msg_errors)):
            # Convert to has password
            $password = md5($password);

            # Insert into database
            $sql_insert = "INSERT INTO `blood_donors` (`name`, `email`, `password`, `phone`, `address`, `image`, `gender`, `roles_id`, `blood_of_type_id`) 
            VALUES ('$name', '$email', '$password', '$phone', '$address', '$new_name_img', '$gender', '$roles', '$types');";

            # Store dada after inser to check connect database
            $result_insert = mysqli_query($connect_db, $sql_insert);

            // $testMsg = 'good insert data';

            # Check result inserted
            if($result_insert):
                $msg_sucsess ='<div class="alert alert-success px-2">An account has been changed and inserted update successfully</div>';
                //$msg_sucsess = '<div class="alert alert-success">A role has been inserted successfully</div>'; 
            endif;
        endif;
    endif;
?>


<!DOCTYPE html>
<html lang="en">
    <!-- Start head -->
    <?php include $layouts . 'head.php'; ?>
    <!-- End head -->
    <body class="sb-nav-fixed">
    
        <!-- Start header nav -->
        <?php include './includes/layouts/header.php';?>
        <!-- End header nav -->
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <!-- Start sidebar nav -->
                <?php include $layouts . 'sidebar.php'; ?>
                <!-- End sidebar nav -->
            </div>
            <div id="layoutSidenav_content">
                <!-- Form to edit user -->
                    <main class="mb-2 mt-2">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-7">
                                    <div class="card shadow-lg border-0 rounded-lg mt-1">
                                        <div class="card-header text-light bg-dark">
                                            <h3 class="font-weight-light my-2">Add Account</h3>
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
                                                <div class="form-row">
                                                    <div class="col-12 mx-auto">
                                                        <div class="form-group">
                                                            <label class="small mb-1" for="name">Name</label>
                                                            <input type="text" name="name" class="form-control py-4" id="name"  placeholder="Enter name .." autocomplete="off" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="small mb-1" for="email">Email</label>
                                                            <input type="text" name="email" class="form-control py-4" id="email"  placeholder="Enter email .." autocomplete="off" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="small mb-1" for="password">Password</label>
                                                            <input type="text" name="password" class="form-control py-4" id="password"  placeholder="Enter password .." autocomplete="off" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="small mb-1" for="phone">Phone</label>
                                                            <input type="text" name="phone" class="form-control py-4" id="phone"  placeholder="Enter Phone .." autocomplete="off" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="small mb-1" for="address">Address</label>
                                                            <select class="custom-select" name="address" id="address">
                                                                <option selected value="">Choose Country</option>
                                                                <option value="EG">Egypt</option>
                                                                <option value="SU">Sudan</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="small mb-1" for="gender">Gender</label>
                                                            <select class="custom-select" name="gender" id="gender">
                                                                <option selected value="">Choose Gender</option>
                                                                <option value="male">Male</option>
                                                                <option value="female">Female</option>
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="small mb-1" for="types">Blood Types</label>
                                                            <select class="custom-select" name="types" id="types">
                                                                <option selected value="">Choose Blood Type</option>
                                                                <?php
                                                                $sql_select = "SELECT * FROM `blood_of_types`";
                                                                $result_select = mysqli_query($connect_db, $sql_select);
                                                                 while($convert_data = mysqli_fetch_assoc($result_select)):?>
                                                                <option value="<?php echo $convert_data ['id']; ?>"><?php echo $convert_data ['types']; ?></option>
                                                                <?php endwhile; ?>
                                                            </select>
                                                                                                                
                                                        </div>
                                                 
                                                        

                                                 
                                                        <div class="form-group">
                                                            <label class="small mb-1" for="roles">Roles</label>
                                                            <select class="custom-select" name="roles" id="roles">
                                                                <option selected value="">Choose roles</option>
                                                                <?php
                                                                $sql_select = "SELECT * FROM `admins`";
                                                                $result_select = mysqli_query($connect_db, $sql_select);
                                                                 while($convert_data = mysqli_fetch_assoc($result_select)):?>
                                                                <option value="<?php echo $convert_data ['id']; ?>"><?php echo $convert_data ['roles']; ?></option>
                                                                <?php endwhile; ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group ">
                                                            <label class="form-label small mb-1" for="image">Choose Image</label>
                                                            <input type="file" name="image" class="form-control" id="image" />
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                               
                                                <div class="form-group mt-3 mb-0">
                                                    <a href="./dashboard_accounts.php" class="btn btn-success">Dashboard</a>
                                                    <button type="submit" class="btn btn-primary">Add Account</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- <div class="card-footer text-center">
                                            <div class="small">
                                                <a href="login.html">Have an account? Go to login</a>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                <!-- Start footer -->
                <?php include $layouts . 'footer.php'; ?>
                <!-- End footer -->
            </div>
        </div>
        <!-- Start file scripts -->
        <?php include $layouts . 'scripts.php'; ?>
    </body>
</html>