<?php
/**
 * Created by PhpStorm.
 * User: Raimundo Jose
 * Date: 6/12/2019
 * Time: 5:27 AM
 */
?>

<div class="container">
    <br><br>
    <form class="form-inline"></form>
    <form class="form-inline">
        <div class="form-group">
            <label for="curso_ins">Seleccionar o Curso:</label> <br>

            <select class="form-control col-lg-2"  onchange="buscar_periodos(this.value,1);"
                    data-style="btn-primary" data-width="auto" id="curso_id" name="curso_id">
                <?php
                $t =0;
                $resut = mysqli_query($con,'SELECT * FROM curso');
                while ($row = mysqli_fetch_assoc($resut)){
                    if ($t==0){
                        echo '<option value="'. $row['idcurso'].'">-- Selecionar um curso --</option>';
                        $t++;
                    }
                    ?>
                    <option value="<?php echo $row['idcurso'] ?>"><?php echo utf8_encode($row['descricao']) ?></option>
                <?php }  ?>
            </select>
        </div>

        <input type="hidden" value="" id="c_curso" name="c_curso"/>

        <div class="form-group select_pesquisa">
            <label for="periodo">Buscar/ Turma:</label><br>
            <select class="form-control"  data-style="btn-primary" data-width="auto"
                    id="periodo_pesq" name="periodo_pesq" onchange="table_frm_periodos(this.value)">
                <option value="0">Selecionar o Periodo:</option>

                <?php

                $resut = mysqli_query($con,'SELECT * FROM disciplina WHERE turma.idcurso=1');
                while ($row = mysqli_fetch_assoc($resut)){
                    ?>
                    <option value="<?php echo $row['idturma'] ?>"><?php echo utf8_encode($row['descricao']).''; ?></option>
                <?php }  ?>

            </select>
        </div>
        <div class="form-group  periodos_pesquisa"></div>
    </form>

    <br><br>
    <div class="table-responsive tbl_alunos"> </div>
</div>
