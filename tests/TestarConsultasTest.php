<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sisto
 * Date: 6/15/2019
 * Time: 7:21 PM
 */

use PHPUnit\Framework\TestCase;

require_once'../view/exames/funcoes.php';

class TestarConsultasTest extends  TestCase
{
    function testEstudantesEscritosCorrenteAnoComDuasDisciplinasMaximo(){

        $objecto = new MYSQLConsultas();

        $testa="select count(*) nr_de_inscricoes_correntes,idinscricao, idutilizador, data_registo, iddisciplina 
                    from 
	                  (select idinscricao, i.idutilizador, i.data_registo, i.iddisciplina 
			            from inscricao i, utilizador u, disciplina d
			            where year(i.data_registo) in(year(Now())) and u.id=i.idutilizador and d.idDisciplina=i.iddisciplina
			            ORDER BY i.idutilizador asc) sub1
                    GROUP BY idutilizador
                    HAVING COUNT(*)<=2
                    ORDER BY idutilizador desc";

        $this->assertEquals($testa, $objecto->estudantesComNegativasExameRecorrencia());
    }
}