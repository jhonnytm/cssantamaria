<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    require_once("Layouts/header.php");
?>
<h4> Usuarios</h4>
<button type="button" class="btn btn-outline-success btn-lg">Nuevo</button>
<button type="button" class="btn btn-outline-success btn-lg ">Dark</button>
<button type="button" class="btn btn-outline-success btn-lg">Buscar</button>
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">DNI</th>
      <th scope="col">Nombres</th>
      <th scope="col">Apellidos</th>
      <th scope="col">Email</th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach ($dato as $key => $value);
      foreach ($value as $v);?>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>


    <?php endforeach
    ?>

</table>
<?php
    
    
    var_dump($datos);

    require_once("Layouts/footer.php");?>
</body>
</html>
