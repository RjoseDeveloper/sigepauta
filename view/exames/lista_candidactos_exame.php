<?php

/*-------------------------
Autor: rjose
---------------------------*/
/* Connect To Database*/
require_once("../../dbconf/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once("../../dbconf/conexion.php");//Contiene funcion que conecta a la base de datos
include('../ajax/is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
require_once("../../Query/DocenteSQL.php");

$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

if($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $aColumns = array('idinscricao');//Columnas de busqueda
    $sTable = "inscricao";
    $sWhere = "";
    if ($_GET['q'] != "") {
        $sWhere = "WHERE (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    }

    $sWhere .= " order by idinscricao desc";
    
    include '../ajax/pagination.php'; //include pagination file
    //pagination variables
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 4; //how much records you want to show
    $adjacents = 4; //gap between pages after number of adjacents
    $offset = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable $sWhere");
    $row = mysqli_fetch_array($count_query);
    $numrows = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload = 'exame_extraordinario.php';
    //main query to fetch the data


    $sql = "select * from (select idinscricao, nomeCompleto, curso, d.descricao as disciplina, tab6.data_registo, tab6.nivel, tab6.dataPub, status from
	(select idinscricao, tab4.idutilizador,tab4.iddisciplina, c.descricao as curso, tab4.data_registo, tab5.nota,tab5.dataPub, tab5.descricaoteste, status, t.descricao as nivel from 
		(select tab3.idinscricao, tab3.idutilizador, tab3.iddisciplina, tab3.data_registo, status, tab3.idturma from
			(select tab2.idinscricao, tab1.idutilizador, tab2.data_registo, tab2.iddisciplina, tab2.status_exame as status, tab2.idturma  from 
				(select count(*) nr_de_inscricoes_correntes,idinscricao, idutilizador, data_registo, iddisciplina from 
					(select idinscricao, i.idutilizador, i.data_registo, i.iddisciplina 
						from inscricao i, utilizador u, disciplina d
						where year(i.data_registo) in(year(Now())) and u.id=i.idutilizador and d.idDisciplina=i.iddisciplina
						ORDER BY i.idutilizador asc) sub1
				GROUP BY idutilizador
				HAVING COUNT(*)<=2
				ORDER BY idutilizador) as tab1,

				(select idinscricao, i.idutilizador, i.data_registo, i.iddisciplina, i.status_exame, i.idturma	
					from inscricao i, utilizador u, disciplina d
					where year(i.data_registo) in(year(Now())) and u.id=i.idutilizador and d.idDisciplina=i.iddisciplina
					ORDER BY i.idutilizador) as tab2

			where tab2.idutilizador=tab1.idutilizador	
			ORDER BY tab2.idutilizador) as tab3, disciplina d, utilizador u
		where d.idDisciplina=tab3.iddisciplina and tab3.idutilizador=u.id
		order by tab3.idutilizador) as tab4,

	(select sub3.idusers, sub3.nota, sub3.dataPub, sub3.descricaoteste, sub3.idDisciplina, sub3.idcurso from 
		(select DISTINCT sub2.idusers, sub2.nota, sub2.dataPub, sub2.descricaoteste, sub2.idDisciplina, sub2.idcurso from 
			(select en.nota, dataPub, a.nome, p.idusers, da.descricaoteste, p.idDisciplina, p.idcurso from pautanormal p, aluno a, estudante_nota en, data_avaliacao da	
				where p.idusers=a.idutilizador and en.idaluno=a.idaluno and p.idPautaNormal=en.idPautaNormal and da.id_data=p.idTipoAvaliacao 
					and da.descricaoteste='Exame Normal' and en.nota<10) as sub1,

			(select en.nota, dataPub, a.nome, p.idusers, da.descricaoteste, p.idDisciplina, p.idcurso from pautanormal p, aluno a, estudante_nota en, data_avaliacao da
				where p.idusers=a.idutilizador and en.idaluno=a.idaluno and p.idPautaNormal=en.idPautaNormal and da.id_data=p.idTipoAvaliacao 
					and da.descricaoteste='Exame Recorrencia' and en.nota<10) as sub2

		where sub1.idusers=sub2.idusers) as sub3
		ORDER BY sub3.idDisciplina) as tab5, curso c, turma t

	where tab4.iddisciplina=tab5.idDisciplina and tab4.idutilizador=tab5.idusers and c.idcurso=tab5.idcurso and t.idturma=tab4.idturma) as tab6, utilizador u, disciplina d

  WHERE u.id=tab6.idutilizador and d.idDisciplina=tab6.iddisciplina) as tab10 
  $sWhere LIMIT $offset,$per_page";

    $query = mysqli_query($con, $sql);

   //loop through fetched data
    if ($numrows > 0) {
        ?>

        <div class="table-responsive container">
            <table class="table">
                <th>ID</th>
                <th>NOME COMPLETO</th>
                <th>CURSO</th>
                <th>DISCIPLINA</th>
                <th>DATA DE INSCRICAO</th>
                <th>Nivel</th>
<!--                <th>Nota de Exame</th>-->
                <th>DATA DE PUBLICACAO</th>
                <th>STATUS</th>
                <!--                <th><span class="pull-right">Acções</span></th>-->

                </tr>
                <?php while ($row = mysqli_fetch_array($query)) {

                    $idinscricao = $row['idinscricao'];
                    $nomeCompleto = $row['nomeCompleto'];
                    $curso = $row['curso'];
                    $disciplina = $row['disciplina'];
                    $data_registo = $row['data_registo'];
                    $status = $row['status'];
                    $nivel = $row['nivel'];
                    $dataPub = $row['dataPub'];
//                    $nota = $row['nota'];
                    ?>

                    <input type="hidden" value="<?php echo $idinscricao;?>"
                           id="nombre_cliente<?php echo $idinscricao;?>">
                    <input type="hidden" value="<?php echo $nomeCompleto;?>"
                           id="nombre_cliente<?php echo $nomeCompleto;?>">
                    <input type="hidden" value="<?php echo $curso;?>"
                           id="curso<?php echo $curso;?>">
                    <input type="hidden" value="<?php echo $disciplina;?>"
                           id="disciplina<?php echo $disciplina;?>">
                    <input type="hidden" value="<?php echo $data_registo;?>"
                           id="status_cliente<?php echo $data_registo;?>">
                    <input type="hidden" value="<?php echo $nivel;?>"
                           id="nivel<?php echo $nivel;?>">
<!--                    <input type="hidden" value="--><?php //echo $nota;?><!--"-->
<!--                           id="nota--><?php //echo $nota;?><!--">-->
                    <input type="hidden" value="<?php echo $dataPub;?>"
                           id="dataPub<?php echo $dataPub;?>">
                    <input type="hidden" value="<?php echo $estado;?>"
                           id="estado<?php echo $estado;?>">
                    <tr>
                        <td><?php echo $idinscricao; ?></td>
                        <td><?php echo $nomeCompleto; ?></td>
                        <td><?php echo $curso;?></td>
                        <td><?php echo $disciplina;?></td>
                        <td><?php echo $data_registo ?></td>
                        <td><?php echo $nivel ?></td>
<!--                        <td>--><?php //echo $nota ?><!--</td>-->
                        <td><?php echo $dataPub ?></td>
                        <!--                        <td>--><?php //echo $status; ?><!--</td>-->

                        <?php if($status=='HABILITADO'){?>
                            <td>
                                <button data-toggle='tab' title="DESABILITAR O ESTADO" class='btn btn-info btn-sm'
                                        onclick="enable_status(this.value)" value="<?php echo $idinscricao;?>">
                                    <span class='glyphicon glyphicon-check'><?php echo " " .$status;?></span>
                                </button>
                            </td>
                        <?php }else{?>
                            <td>
                                <button data-toggle='tab' title="HABILITAR O ESTADO" class='btn btn-warning btn-sm'
                                        onclick="enable_status(this.value)" value="<?php echo $idinscricao;?>">
                                    <span class='glyphicon glyphicon-edit'><?php echo " " .$status;?></span>
                                </button>
                            </td>
                        <?php } ?>
                    </tr>

                <?php } ?>
                <tr>
                    <td colspan=8><span class="pull-right">
					<?php
                    echo paginate($reload, $page, $total_pages, $adjacents);
                    ?></span></td>
                </tr>
            </table>
        </div>
        <?php
    }
}
?>