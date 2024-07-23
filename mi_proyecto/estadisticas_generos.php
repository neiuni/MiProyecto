<?php include("includes/sesiones.php"); ?>
<?php include("includes/config.php");?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php 
     $headTitle .= "";
     $headDescription .= "";
     $headKeywords .=""; 
     $menugrupo  = 'estadisticas'; // para mostrar (show) grupo de menu
     $menuenlace = 'est_generos'; // para activar (active)  enlace en menu
    include("includes/head.php");
    ?>
</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include("includes/sidebar.php");?>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include("includes/topbar.php");?>

                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Estadisticas Genero</h1>
                  
                    </div>
                    <!-- Donut Chart -->
                    <div class="col-xl-12 ">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Donut Chart</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                    <hr>
                                    Styling for the donut chart can be found in the
                                    <code>/js/demo/chart-pie-genero.js</code> file.
                                </div>
                            </div>
                        </div>

                    <!-- Content Row -->
                   

                    <!-- Content Row -->

                  
                    <!-- Content Row -->
                 

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include("inc_footer.php");?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
    <?php
     include("./inc_conexion_peliculas.php");
    $query = "
    SELECT genero.genero as nombre, peli_genero.generoid,count(peli_genero.generoid) as contador 
    FROM `peli_genero` 
    inner join genero on genero.id = peli_genero.generoid
    group by generoid
    order by count(peli_genero.generoid)";
    $resultado = mysqli_query($conpel,$query);
    $legend = [];
    $data = [];
    if(mysqli_num_rows($resultado)!=0){   
            while($fila=mysqli_fetch_array($resultado)){ 
                array_push($legend,$fila['nombre']);
                array_push($data,$fila["contador"]);
            }
    }
    print_r($legend);
    print_r($data);
    $jlegend = json_encode($legend);
    $jdata = json_encode($data);
    $numValores = count($legend);
    ?>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
   <?php include("includes/logout.php"); ?>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script>
     // Obtencion de valores de los arrays $legen y $data de php */
     var legend,data,numvalores;
        legend  = <?php echo $jlegend;?>;
        const legendt = Object.values(legend);
        data = <?php echo $jdata;?>; 
        const datat = Object.values(data); 
        const numValores =  <?php echo $numValores;?>;
        console.log('LEGEND : ' + legend);
        console.log('LEGEND tipo : ' + typeof(legend));
        console.log('DATA : ' + data);
        console.log('LEGENDT : ' + legendt);
        console.log('LEGENDT tipo : ' + typeof(legendt));
    </script>
     <script src="js/demo/chart-pie-genero.js"></script> 

</body>

</html>