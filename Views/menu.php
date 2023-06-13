<?php
require_once("../Config/Conexion2.php");
include("../Views/menu/header.php");

$sql = "SELECT * FROM USUAccessmenu where desc_nivel='Administrador'";
$busca = $ConexionDB->prepare($sql);
$busca->execute();
$registro = $busca->fetchAll(PDO::FETCH_OBJ);
foreach ($registro as $row) :
    $submenu = $row->Desc_acceso;
    echo $row->Desc_acceso . '<br>';

    $sql2 = "SELECT * FROM USUAccesssubmenu where desc_nivel='Administrador' and desc_acceso='$submenu'";
    $busca2 = $ConexionDB->prepare($sql2);
    $busca2->execute();
    $registro2 = $busca2->fetchAll(PDO::FETCH_OBJ);
    foreach ($registro2 as $r) :
        echo '-->' . $r->Desc_submenu . '<br>';
    endforeach;
endforeach;

?>
<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Centro de Salud Santa María</a>

        <?php
        $sql = "SELECT * FROM USUAccessmenu where desc_nivel='root'";
        $busca = $ConexionDB->prepare($sql);
        $busca->execute();
        $registro = $busca->fetchAll(PDO::FETCH_OBJ);
        foreach ($registro as $row) : ?>
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php
                        $submenu = $row->Desc_acceso;
                        echo $row->Desc_acceso;
                        ?>
                    </a>
                    <?php
                    $sql2 = "SELECT * FROM USUAccesssubmenu where desc_nivel='root' and desc_acceso='$submenu'";
                    $busca2 = $ConexionDB->prepare($sql2);
                    $busca2->execute();
                    $registro2 = $busca2->fetchAll(PDO::FETCH_OBJ); ?>

                    <?php foreach ($registro2 as $r) : ?>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <?php echo $r->Desc_submenu ?>
                                </a>
                            </li>
                        </ul>
                    <?php
                    endforeach ?>
                </li>
            </ul>
        <?php endforeach; ?>
    </div>
</nav>

<?php //die(); 
?>