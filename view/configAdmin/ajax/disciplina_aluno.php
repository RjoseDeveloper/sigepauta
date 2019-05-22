<?php

/*-------------------------
Autor: rjose
---------------------------*/
/* Connect To Database*/
$pessoa = new PessoaSQL();
$queries = $pessoa->get_disciplina_aluno($_SESSION['username']);
$query = mysqli_query($con, $queries);?>

<div class="table-responsive col-8 tbl_disciplina">
<!--    <div class="pull-right"><button class="btn btn-primary" onclick="enable_inscricao()">Adicionar Dusciplina </button></div>-->
<!---->
<!--    <br><br>-->
    <table class="table">
        <tr class="info">

            <th>Codigo</th>
            <th>Descrição</th>
            <th>Creditos</th>
            <th>Natureza</th>
            <th>Data de Inscricao</th>
            <th>Status</th>
            <th class='text-right'>Acções</th>

        </tr>

        <?php while ($row = mysqli_fetch_array($query)) {

            $codigo = $row['codigo'];
            $descricao = $row['descricao'];
            $creditos = $row['creditos'];;
            $natureza = $row['natureza'];
            $id_disp = $row['idDisciplina'];
            $date_added = date('d/m/Y', strtotime($row['data_registo']));
            $status = $row['status'];

            if ($status != 1 ){$text_estado="Aceite";$label_class='label-success';}
            else{$text_estado="Rejeitada";$label_class='label-warning';}

            ?>

            <tr>

                <td><?php echo $codigo; ?></td>
                <td><?php echo $descricao; ?></td>
                <td><?php echo $creditos;?></td>
                <td><?php echo $natureza;?></td>
                <td><?php echo $date_added;?></td>
                <td class='text-center'><span class="label <?php echo $label_class;?>"><?php echo $text_estado;?></span></td>
                <td><span class="pull-right">
                                <a href="#" class='btn btn-default' title='Exluir da Lista' "><i class="glyphicon glyphicon-trash"></i>
                        </a>

                            </span>

                </td>

            </tr>
        <?php
        }
        ?>

    </table>
</div>