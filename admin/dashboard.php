<?php 
    
    session_start();
    if(isset($_SESSION['root'])):
    
        # Include initial file php to show var and connect database
        include './initial.php';

        # Select data query
        $sql_select = "SELECT * FROM `admins` WHERE 1 ";

        # Store data after select and connect database
        $result_select = mysqli_query($connect_db, $sql_select);

        if(isset($_GET['id'])):

            # Filter id 
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            

            # Check by id from database
            $sql_delete = "DELETE FROM `admins` WHERE `id` = " . $id;

            # Store query result after delete 
            $result_delete = mysqli_query($connect_db, $sql_delete);

            # Check result after delete and redirect dashboard
            if($result_delete):
                header('location: dashboard.php');
            endif;
        endif;

        
        // # Store messages 
        // $msg_warning = [];
        
        // # Check deleted
        // if($result_delete):
        //     $name = "SELECT `roles` FROM `admins` WHERE WHERE `id` = " .$id;
        //     $name_result = mysqli_query($connect_db, $name);
        //     $conver_name = mysqli_fetch_assoc($name_result);
        //     $msg_warning['role'] = 'Warning ! The <strong> ' . $conver_name['roles'] . ' </strong>will be deleted';
        // else:
            
        // endif;

   
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
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item">Settings</li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header bg-dark text-light">
                                <i class="fas fa-table mr-1"></i>
                                Admins Role || 
                                <?php echo '<a class = "text-light" href="./add_role.php"> Add Roles </a>' ?>
                            </div>

                            <div class="card-body">
                                <?php
                                    // //echo $conver_name['roles'];
                                    // if(!empty($msg_warning)):
                                    //     echo 
                                    //     '<div class="alert alert-warning alert-dismissible fade show mb-2" role="alert"> 
                                    //         ' . $msg_warning['roles'] . '
                                    //         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    //             <span aria-hidden="true">&times;</span>
                                    //         </button>
                                    //     </div>';
                                    
                                    // endif;
                                ?>
                                <div class="table-responsive">
                                        
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="bg-dark text-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Roles</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>

                                            <?php 
                                                # To used modal confirm deleted
                                                $counter = 0;
                                                # Show data after convert to array
                                                while($convert_data = mysqli_fetch_assoc($result_select)):
                                                    $counter += 1; 
                                            ?> 
                                                <tr>
                                                    <td> <?php echo $convert_data['id']; ?> </td>
                                                    <td> <?php echo $convert_data['roles']; ?></td>
                                                    <td>
                                                        <a href="./edit_role.php?id=<?php echo $convert_data['id']; ?>" class="btn btn-primary">Edit</a>
                                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal<?php echo $counter;?>">Delete</button>
                                                        <!-- Modal to confirm delete -->
                                                        <div class="modal fade" id="modal<?php echo $counter;?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <div class="alert alert-warning w-100" role="alert">Warning !</div>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p>Are you sure to delete the user role <strong class="text-danger"> <?php echo $convert_data['roles']; ?> </strong> <br /> Click Confirm to Delete or Return</p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <a href="./dashboard.php?id=<?php echo $convert_data['id']; ?>" class="btn btn-danger">Confirm</a>
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Return</button>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td> 
                                                </tr>
                                                
                                            <?php endwhile; ?>            
                                        </tbody>
                                    </table>
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
<?php 
else:
    header('location: ./index.php');
    exit();
endif;
?>
