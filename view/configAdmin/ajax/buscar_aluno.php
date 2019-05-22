<?php

/*-------------------------
Autor: rjose
---------------------------*/
/* Connect To Database*/

require '../QuerySql/PessoaSQL.php';

$pessoa = new PessoaSQL();

    $queries = $pessoa->get_all_pessoa(1,$_SESSION['username']);
    $query = mysqli_query($con, $queries);?>

        <div class="table-responsive">
            <table class="table">
                <tr class="info">
                    <th>Codigo</th>
                    <th>Nome Completo</th>
                    <th>Naturalidade</th>
                    <th>Morada</th>
                    <th>Sexo</th>
                    <th>Docença Frequente</th>
                    <th>Data de Ingresso</th>
                    <th class='text-right'>Acções</th>

                </tr>

                <?php while ($row = mysqli_fetch_array($query)) {

                    $id_pessoa = $row['idpessoa'];
                    $codigo = $row['nr_mec'];
                    $fullname = $row['fullname'];
                    $sexo = $row['sexo'];
                    $endereco = $row['bairro'];
                    $docenca = $row['docenca_freq'];
                    $distrito = $row['distrito'];
                    //$data = $row['data_nascimento'];
                    $date_added = date('d/m/Y', strtotime($row['data_nascimento']));

                    ?>

                    <input type="hidden" value="<?php echo $codigo;?>"
                           id="nombre_cliente<?php echo $codigo;?>">
                    <input type="hidden" value="<?php echo $sexo;?>"
                           id="telefono_cliente<?php echo $sexo;?>">
                    <input type="hidden" value="<?php echo $docenca;?>"
                           id="email_cliente<?php echo $docenca;?>">
                    <input type="hidden" value="<?php echo $endereco;?>"
                           id="direccion_cliente<?php echo $endereco;?>">
                    <input type="hidden" value="<?php echo $date_added;?>"
                           id="status_cliente<?php echo $date_added;?>">
                    <tr>

                        <td><?php echo $codigo; ?></td>
                        <td><?php echo $fullname; ?></td>
                        <td><?php echo $distrito;?></td>
                        <td><?php echo $endereco;?></td>
                        <td><?php echo $sexo;?></td>
                        <td><?php echo $docenca;?></td>
                        <td><?php echo $date_added;?></td>

                        <td><span class="pull-right">
					<a href="#" class='btn btn-default' title='Actualizar Dados'
                       onclick="obtener_datos('<?php echo $id_pessoa;?>');"><i class="glyphicon glyphicon-edit"></i></a>

                                <a href="#" class='btn btn-default' title='Dados do Encarregado' data-toggle="modal"
                                   data-target="#list_encarregado" data-backdrop="false"
                                   onclick="listar_Encarregado('<?php echo $id_pessoa; ?>')"><i class="glyphicon glyphicon-list"></i>
                                </a>
                                <a href="#" class='btn btn-default' title='Adicionar Encarregado'  onclick="get_item_val('<?php echo $id_pessoa;?>')"
                                   data-toggle="modal" data-target="#registar_encarregado" data-backdrop="false" "><i class="glyphicon glyphicon-plus"></i>
                                </a>


                            </span>

                        </td>

                    </tr>
                <?php
                }
                ?>

            </table>
        </div>