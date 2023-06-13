<?php
require_once('../Config/Conexion2.php');
?>
<div class="modal fade" role="dialog" id="resultadoedit3_<?php echo $row->Id_Examen ?>">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Modifica Resultado</h4>
        </div>
        <div class="modal-body">
            <form action="../Models/M_resultadoedit.php" method="post" name="resultado">
                <label>Examen de laboratorio :</label><br>
                <input type=hidden name="nroorden" value="<?php echo $row->Nroorden ?>">
                <input type=hidden name="idexamen" value="<?php echo $row->Id_Examen ?>">
                <input type=hidden name="estado" value="<?php echo $estado ?>">
                <input type=text name="examen" size="75%" value="<?php echo $row->Descexamen ?>" readonly><br>
                <label>Resultado :</label><br>
                <input type=text name="resultado" size="100%" value="<?php echo $row->Resultado_uno ?>"><br>
                <button type="submit" name="editar" class="btn btn-success"><span class="glyphicon glyphicon-check"></span> Actualizar Ahora</a>
            </form>
        </div>
        <div class="modal-footer">
            <!--<button type="button" name="cancel" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Cancel</button>-->
            </button>
        </div>
    </div>
</div>
</div>