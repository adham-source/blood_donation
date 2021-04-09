<?php 
    session_start();
    # Include initial file php to show var and connect database
    include './initial.php';

    $pageTilte = 'Home'; // Change name all pages after finsh

    # Select data query
    $sql_select = "SELECT * FROM `admins` WHERE 1 ";

    # Srore dada after select
    $result_select = mysqli_query($connect_db, $sql_select);

   
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
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Home</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Home</li>
                        </ol>
                
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Primary Card</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Warning Card</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Success Card</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">Danger Card</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area mr-1"></i>
                                        Area Chart Example
                                    </div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar mr-1"></i>
                                        Bar Chart Example
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header bg-dark text-light">
                                <i class="fas fa-table mr-1"></i>
                                Admins
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="bg-dark text-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Roles</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>

                                            <?php
                                                // # Covert result select from database to array and fetched
                                                // $convert_data = mysqli_fetch_assoc($result_select);

                                                # Show data after convert to array
                                                // foreach($convert_data as $value):
                                                //     echo $convert_data[$value];
                                                // endforeach;

                                                # Show data after convert to array
                                                while($convert_data = mysqli_fetch_assoc($result_select)):
                                            ?>
                                                    <tr>
                                                        <td> <?php echo $convert_data['id']; ?> </td>
                                                        <td> <?php echo $convert_data['roles']; ?> </td>
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
