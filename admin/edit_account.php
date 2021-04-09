<?php 
    # Include initial file php to show var and connect database
    include './initial.php'; 

    # Check exist id comming get
    # Check if user comming from http request method get 
    if($_SERVER['REQUEST_METHOD'] == 'GET'):
        # Filter id 
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

        # Select data query
        $sql_select = "SELECT * FROM `blood_donors` WHERE `id` = " . $id;

        # Store data after select and connect database
        $result_select = mysqli_query($connect_db, $sql_select);

        # Store count rows 
        $count_rows = mysqli_num_rows($result_select);

        # Create array var to store errors
        $msg_errors = [];
        $msg_sucsess = '';

        # Check Account name is exist
        if($count_rows == 0):
            $msg_errors[] = 'Account name  <srtong> is not exist </strong>';
            # Rdirect to dashboard if Blood donors name not exist
            //header('location: ./dashboard_accounts.php');
        else:
            # Convert data to from object to array
            $convert_data = mysqli_fetch_assoc($result_select);
        endif;
    endif;

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
       $id         = htmlspecialchars(trim(filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT)));


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
            # Update data query
            $sql_update = "UPDATE `blood_donors`SET 
                                                    `name`      = '$name',
                                                    `email`     = '$email',
                                                    `password`  = '$password',
                                                    `phone`     = '$phone',
                                                    `address`   = '$address',
                                                    `image`     = '$new_name_img',
                                                    `gender`    = '$gender',
                                                    `types`     = '$types',
                                                    `roles`     = '$roles'
                                                WHERE `id` = " . $id;

            var_dump($sql_update) . '<br />';
            # Store dada after update to check connect database
            $result_update = mysqli_query($connect_db, $sql_update);
            var_dump($result_update) . '<br />';
            # Check result changed and updated
            if($result_update):
                $msg_sucsess = '<div class="alert alert-success px-2">An account has been changed and inserted update successfully</div>'; 
                $testMsg = 'error';
                $msg_errors = [];
            else:
                //header('location: ./edit_role.php?id='.$convert_data['id']);
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
        <?php include $layouts . 'header.php';?>
        <!-- End header nav -->
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <!-- Start sidebar nav -->
                <?php include $layouts . 'sidebar.php'; ?>
                <!-- End sidebar nav -->
            </div>
            <div id="layoutSidenav_content">
                <!-- Form to edit user -->
                    <main class="mb-2 mt-5">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-7">
                                    <div class="card shadow-lg border-0 rounded-lg mt-2">
                                        <div class="card-header text-light bg-dark">
                                            <h3 class="font-weight-light my-2">Edit Account</h3>
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
                                                # Check messages sucsess
                                                if(isset($msg_sucsess)):
                                                    echo $msg_sucsess;
                                                endif;
                                            ?>
                                            
                                            <?php 
                                            var_dump($sql_update) . '<br />';
                                            echo '<br />id from post = ' .$_POST['id']; ?>
                                            <form class="" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                                                <div class="form-row">
                                                    <?php 
                                                        
                                                        $sql_select = "SELECT `blood_donors` . * , `blood_of_types` . `types`, `admins` . `roles`
                                                        FROM `blood_donors` JOIN `blood_of_types` 
                                                        ON `blood_donors` . `blood_of_type_id` =  `blood_of_types` . `id`
                                                        JOIN `admins` ON `blood_donors` . `roles_id` = `admins` . `id`";
                                                    ?>            
                                                    <div class="col-12 mx-auto">
                                                        <input type="hidden" name="id" value="<?php if(isset($convert_data['id'])): echo $convert_data['id']; endif;?>" />

                                                        <div class="form-group">
                                                            <label class="small mb-1" for="name">Name</label>
                                                            <input type="text" name="name" value="<?php if(isset($convert_data['name'])): echo $convert_data['name']; endif;?>" class="form-control py-4" id="name"  placeholder="Enter name .." autocomplete="off" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="small mb-1" for="email">Email</label>
                                                            <input type="text" name="email" value="<?php if(isset($convert_data['email'])): echo $convert_data['email']; endif;?>" class="form-control py-4" id="email"  placeholder="Enter email .." autocomplete="off" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="small mb-1" for="password">Password</label>
                                                            <input type="text" name="password" value="<?php if(isset($convert_data['password'])): echo $convert_data['password']; endif;?>" class="form-control py-4" id="password"  placeholder="Enter password .." autocomplete="off" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="small mb-1" for="phone">Phone</label>
                                                            <input type="text" name="phone" value="<?php if(isset($convert_data['phone'])): echo $convert_data['phone']; endif;?>" class="form-control py-4" id="phone"  placeholder="Enter Phone .." autocomplete="off" />
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
                                                                <option value="male" <?php if(isset($convert_data['gender'])): echo "selected"; endif; ?> >
                                                                                    <?php if(isset($convert_data['gender'])): echo $convert_data['gender']; endif; ?>
                                                                </option>
                                                                <option value="female" <?php if(isset($convert_data['gender'])): echo "selected"; endif; ?> >
                                                                                    <?php if(isset($convert_data['gender'])): echo $convert_data['gender']; endif; ?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="small mb-1" for="types">Blood Types</label>
                                                            <select class="custom-select" name="types" id="types">
                                                                <option selected value="">Choose Blood Type</option>
                                                                <?php
                                                                
                                                                //$sql_select = "SELECT * FROM `blood_donors` WHERE 1";
                                                                $result_select = mysqli_query($connect_db, $sql_select);
                                                                 while($convert_data = mysqli_fetch_assoc($result_select)):?>
                                                                <option value="<?php echo $convert_data ['types']; ?>" <?php if(isset($convert_data['types'])): echo "selected"; endif; ?>>
                                                                <?php echo $convert_data ['types']; ?></option>
                                                                <?php endwhile; ?>
                                                            </select>
                                                                                                                
                                                        </div>

                                    
                                                        <div class="form-group">
                                                            <label class="small mb-1" for="roles">Roles</label>
                                                            <?php
                                                                
                                                                # Store data after select and connect database
                                                                $result_select = mysqli_query($connect_db, $sql_select);
                                                                $convert_data = mysqli_fetch_assoc($result_select); 
                                                            ?>
                                                            <input type="text" name="roles" value="<?php if(isset($convert_data['id'])): echo $convert_data['roles']; endif;?>" class="form-control py-4" id="roles"  placeholder="Enter roles .." autocomplete="off" readonly />
                                                            
                                                        </div>

                                                        <div class="form-group ">
                                                            <label class="form-label small mb-1" for="image">Choose Image</label>
                                                            <input type="file" name="image" class="form-control" id="image" />
                                                        </div>
                                                    </div>

                                                    
                                                </div>
                                               
                                                <div class="form-group mt-3 mb-0">
                                                    <?php echo '<a href="./dashboard_accounts.php" class="btn btn-success">Dashboard</a>'?>
                                                    <button type="submit" class="btn btn-primary">Save Edit Account</button>
                                                </div>
                                            </form>
                                        </div>
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
        <?php include $layouts . 'scripts.php' ?>
    </body>
</html>