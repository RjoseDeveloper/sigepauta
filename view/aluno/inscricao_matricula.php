<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 6/12/2019
 * Time: 5:25 AM
 */
session_start();
include '../layouts/head.php';

require_once("../../dbconf/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once("../../dbconf/conexion.php");//Contiene funcion que conecta a la base de datos
?>
<div class="jumbotron container">
<div class="container">

    <form class="form-horizontal" method="post" id="guardar_inscricao" name="guardar_inscricao">

        <div class="col-xs-12 msg_sucesso" style=" padding: 8px;
                     color: #0000CC; font-size: 18px;"> ADICIONAR DISCIPLINAS DO SEMESTRE </div>

        <div class="col-xs-6 pull-left">

            <?php
            if ($_SESSION['tipo'] != 'estudante'){
                ?>

                <label for="user">Seleccionar Aluno:</label>

                <select class="form-control" data-style="btn-primary"
                        data-width="auto" id="user" name="user" required="">
                    <?php
                    $resut = mysqli_query($con,'SELECT * FROM utilizador INNER JOIN previlegio
                                                    on previlegio.idprevilegio = utilizador.idprevilegio
                                                    AND previlegio.tipo="estudante"');
                    while ($row = mysqli_fetch_assoc($resut)){ ?>
                        <option value="<?php echo $row['id'] ?>">
                            <?php echo utf8_encode($row['nomeCompleto']) ?></option>
                    <?php }  ?>
                </select>

            <?php }else{?>

                <input name="user" id="user" value="<?php echo $_SESSION['id'] ?>" type="hidden"/>
            <?php }?>

            <label for="curso">Curso:</label>

        <select class="form-control" data-style="btn-primary" onchange="lista_turmas(this.value)"
                    data-width="auto" id="curso" name="curso" required="">
                <option value="0">--Seleccionar Curso--</option>
                <?php
                $resut = mysqli_query($con,"select * from curso");

                while ($row = mysqli_fetch_assoc($resut)){ ?>
                    <option value="<?php echo $row['idcurso'] ?>">
                        <?php echo utf8_encode($row['descricao']) ?></option>
                <?php }  ?>

            </select>

            <div class="list_turma"> </div>

        </div>

        <div class="col-xs-6 pull-right">

            <label for="turno">Turno:</label>
            <select class="form-control"  data-style="btn-primary"
                    data-width="auto" id="turno" name="turno" required="">
                <?php
                $resut = mysqli_query($con,'SELECT * FROM turno');
                while ($row = mysqli_fetch_assoc($resut)){ ?>
                    <option value="<?php echo $row['idturno'] ?>">
                        <?php echo utf8_encode($row['descricao']) ?></option>
                <?php }  ?>
            </select>

            <label for="regime">Regime:</label>
            <select class="form-control"  data-style="btn-primary"
                    data-width="auto" id="regime" name="regime" required="">
                <?php
                $resut = mysqli_query($con,'SELECT * FROM regime');
                while ($row = mysqli_fetch_assoc($resut)){ ?>
                    <option value="<?php echo $row['idregime'] ?>">
                        <?php echo utf8_encode($row['descricao']) ?></option>
                <?php }  ?>
            </select>

            <br>

            <div class="pull-right">
                <button type="submit" class="btn btn-info" id="btn_inscricao"> Guardar Dados</button>

                <!--                        <a href="#" class="btn btn-success" id="btn_print" onclick="imprimir_ficha()">-->
                <!--                            <span class="glyphicon glyphicon-print" title="Imprimir"></span></a>-->
            </div>
        </div>
    </form>
</div>
</div>