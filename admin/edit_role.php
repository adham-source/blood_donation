<?php 
    # Include initial file php to show var and connect database
    include './initial.php'; 

    # Check if user comming from http request method get 
    if($_SERVER['REQUEST_METHOD'] == 'GET'):
        # Filter id 
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

        # Select data query
        $sql_select = "SELECT * FROM `admins` WHERE `id` = " . $id;

        # Store data after select and connect database
        $result_select = mysqli_query($connect_db, $sql_select);

        # Store count rows 
        $count_rows = mysqli_num_rows($result_select);

        # Create array var to store errors
        $msg_errors = [];
        $msg_sucsess = '';

        # Check roles name is exist
        if($count_rows == 0):
            $msg_errors[] = 'name role <srtong> is not exist </strong>';
            # Rdirect to dashboard if role not exist
            header('location: ./dashboard.php');
        else:
            # Convert data to from object to array
            $convert_data = mysqli_fetch_assoc($result_select);
        endif;
    endif;

    # Check if user comming from http request method post
    if($_SERVER['REQUEST_METHOD'] == 'POST'):

        # Store and assign variables and filter sanitasize
        $roles  = htmlspecialchars(trim(filter_var($_POST['rolename'], FILTER_SANITIZE_STRING)));
        $id     = htmlspecialchars(trim(filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT)));
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
        endif;

        # Check if errors message empty 
        if(empty($msg_errors)):
            # Select data query
            $sql_select = "SELECT `id` FROM `admins` WHERE `roles` = '$roles'";

            # Store data after select to check connect database
            $result_select = mysqli_query($connect_db, $sql_select);

            # Store count row 
            $count_rows = mysqli_num_rows($result_select);

            # Check roles name is exist
            if($count_rows == 1):
                $msg_errors[] = 'name role <srtong> is exist </strong>';
            else:
                # Empty message erros to continue
                // $msg_errors = [];
                # Update data query
                $sql_update = "UPDATE `admins` SET `roles` = '$roles' WHERE `id` = " .$id;

                # Store dada after update to check connect database
                $result_update = mysqli_query($connect_db, $sql_update);
                # Check result changed and updated
                if($result_update):
                    $msg_sucsess = '<div class="alert alert-success px-2">A role has been changed and inserted update successfully</div>'; 
                    
                    $msg_errors = [];
                else:
                    //header('location: ./edit_role.php?id='.$convert_data['id']);
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
                                            <h3 class="font-weight-light my-2">Edit Roles</h3>
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
                                            
                                            <form class="" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                                                <div class="form-row">
                                                    <div class="col-12 mx-auto">
                                                        <div class="form-group">
                                                            <label class="small mb-1" for="rolename">Role Name</label>
                                                            <input type="text" name="rolename" value ="<?php if(isset($convert_data['roles'])): echo $convert_data['roles']; endif; ?>" class="form-control py-4" id="rolename"  placeholder="Enter name role" autocomplete="off" />
                                                        </div>
                                                        <input type="hidden" name="id" value="<?php if(isset($convert_data['id'])): echo $convert_data['id']; endif;?>" />
                                                    </div>
                                                    
                                                </div>
                                               
                                                <div class="form-group mt-3 mb-0">
                                                    <?php echo '<a href="./dashboard.php" class="btn btn-success">Dashboard</a>'?>
                                                    <button type="submit" class="btn btn-primary">Save Edit Role</button>
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