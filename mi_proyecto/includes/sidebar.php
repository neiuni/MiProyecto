 <!-- Sidebar -->
 <nav class="navbar navbar-dark bg-primary navbar-expand-md sidebar">
            <div class="container-fluid flex-column">
                <a class="navbar-brand d-flex align-items-center justify-content-center" href="index.php">
                    <div class="sidebar-brand-icon">
                      
                    </div>
                     <div class="sidebar-brand-text mx-3"><sup></sup></div>
                 </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav flex-column">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span>Panel de Control</span>
                        </a>
                    </li>
                    <hr class="sidebar-divider">
                    <div class="sidebar-heading"></div>
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false">
                            <i class="fas fa-fw fa-film"></i>
                            <span>Pelis</span>
                        </a>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <h6 class="collapse-header">Peliculas</h6>
                                <a class="collapse-item" href="peliculas.php">Lista de Peliculas</a>
                                <a class="collapse-item" href="peliculas.php?estado=A">Peliculas Activas</a>
                                <a class="collapse-item" href="peliculas.php?estado=D">Peliculas NO Activas</a>
                                <a class="collapse-item" href="peliculas_buscar.php?search=">Buscar Peliculas</a>
                                <a class="collapse-item" href="actores.php?search=">Actores</a>
                            </div>
                        </div>
                    </li> 
                    <!-- <?php if ($rol == 'A') { ?>  -->
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUtilities" aria-expanded="false">
                            <i class="fas fa-fw fa-user"></i>
                            <span>Usuarios</span>
                        </a>
                        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-bs-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <h6 class="collapse-header">Usuarios:</h6>
                                <a class="collapse-item" href="usuarios.php">Usuarios</a>
                                <a class="collapse-item" href="conexiones.php">Conexiones</a>
                                <a class="collapse-item" href="conexiones2.php">Con. Publica</a>
                            </div>
                        </div>
                    </li>
                    <?php } ?>
                    <!-- <?php if ($rol == 'E') { ?> --> 
                    <li class="nav-item">
                        <a class="nav-link" href="listas.php">
                            <i class="fas fa-fw fa-list"></i>
                            <span>Listas de Peliculas</span>
                        </a>
                    </li>
                    <?php } ?>
                    <hr class="sidebar-divider">
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseEst" aria-expanded="false">
                            <i class="fas fa-fw fa-chart-area"></i>
                            <span>Estadisticas</span>
                        </a>
                        <div id="collapseEst" class="collapse" aria-labelledby="headingEst" data-bs-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <h6 class="collapse-header">Estadisticas</h6>
                                <a class="collapse-item" href="estadisticas_peliculas.php">Peliculas</a>
                                <a class="collapse-item" href="estadisticas_generos.php">Generos</a>
                            </div>
                        </div>
                    </li>
                    <hr class="sidebar-divider d-none d-md-block">
                    <div class="text-center d-none d-md-inline">
                        <button class="rounded-circle border-0" id="sidebarToggle"></button>
                    </div>
                </ul>
            </div>
        </nav>
        End of Sidebar 
