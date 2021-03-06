<div class="header w-100 h-20" >
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark w-100">
        <div class="container-fluid w-100">
            <a class="navbar-brand" href="#">Sistema Gestor de Actividades Complementarias</a>
            <?php
                if(isset($_SESSION['loggedin'])){
            ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <div class="btn-group dropstart">
                            <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://cdn-icons-png.flaticon.com/512/3132/3132084.png" alt="Opciones" style="height: 30px; width:30px ; ">
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Mi Perfil</a></li>
                                <?php
                                    if(isset($_SESSION['id_alumno'])){
                                ?>
                                        <li><a class="dropdown-item" href="../alumno/carga.php">Mi Carga Complementaria</a></li>
                                <?php
                                    }
                                ?>
                                <li><a class="dropdown-item" href="http://localhost/Extraescolares/views/layout/login/password.php">Cambiar Contraseña</a></li>
                                <li><a class="dropdown-item" onclick="salir()">Salir</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            <?php
                }
            ?>
        </div>
    </nav>
</div>