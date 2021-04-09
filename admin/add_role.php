<?php 
    # Include initial file php to show var and connect database
    include './initial.php';    

    # Check if user comming from http request method post
    if($_SERVER['REQUEST_METHOD'] == 'POST'):

        # Store and assign variables and filter sanitasize
        $roles = htmlspecialchars(trim(filter_var($_POST['rolename'], FILTER_SANITIZE_STRING)));

        # Create array var to store errors
        $msg_errors = [];
        $msg_sucsess = '';

        # Check on some valid input
        if(empty($roles)):
            $msg_errors[] = 'Enter any name role <srtong> Fill input </strong>';
        elseif(
            filter_var($roles, FILTER_VALIDATE_INT) || 
            filter_var($roles, FILTER_VALIDATE_EMAIL) ||
            filter_var($roles, FILTER_VALIDATE_URL) ||
            filter_var($roles, FILTER_VALIDATE_IP)
            ):
            $msg_errors[] = 'Enter role <srtong> valid name </strong>';
        else:
            $msg_sucsess = '<div class="alert alert-success">A role has been added successfully</div>';
        endif;

        # Check if errors message empty 
        if(empty($msg_errors)):
            # Select data query
            $sql_select = "SELECT `id` FROM `admins` WHERE `roles` = '$roles'";

            # Store dada after select to check connect database
            $result_select = mysqli_query($connect_db, $sql_select);

            # Store count rows 
            $count_rows = mysqli_num_rows($result_select);

            # Check roles name is exist
            if($count_rows == 1):
                $msg_errors[] = 'name role <srtong> is exist </strong>';
                $msg_sucsess = '';
            else:
                # Insert into database
                $sql_insert = "INSERT INTO `admins` (`roles`) VALUES ('$roles')";

                # Store dada after inser to check connect database
                $result_insert = mysqli_query($connect_db, $sql_insert);

                # Check result inserted
                if($result_insert):
                    $msg_sucsess = '<div class="alert alert-success">A role has been inserted successfully</div>'; 
                endif;
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
                    <main class="mb-2 mt-5">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-7">
                                    <div class="card shadow-lg border-0 rounded-lg mt-2">
                                        <div class="card-header text-light bg-dark">
                                            <h3 class="font-weight-light my-2">Add Roles</h3>
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
                                                            <label class="small mb-1" for="rolename">Role Name</label>
                                                            <input type="text" name="rolename" class="form-control py-4" id="rolename"  placeholder="Enter name role" autocomplete="off" />
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                               
                                                <div class="form-group mt-3 mb-0">
                                                    <a href="./dashboard.php" class="btn btn-success">Dashboard</a>
                                                    <button type="submit" class="btn btn-primary">Add Role</button>
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
        <?php include $layouts . 'scripts.php' ?>
    </body>
</html>