<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sisto
 * Date: 6/16/2019
 * Time: 6:48 AM
 */

/**
 * Esta classe e de Exames Especiais
 */
 
require_once 'C:\xampp\htdocs\sigepauta\dbconf\getConection.php';
 
class ExamesEspeciais{

    public function __construct(){

    }

    /**
     * Funcao que retorna uma consulta de alunos inscritos no ano corrente, do nivel 3 ou 4
     *com no maximo duas inscricoes registadas
     * @return string
     */
    function estudantesEscritosCorrenteAnoComDuasDisciplinasMaximo(){

        return "select count(*) nr_de_inscricoes_correntes,idinscricao, idutilizador, data_registo, iddisciplina 
                    from 
	                  (select idinscricao, i.idutilizador, i.data_registo, i.iddisciplina 
			            from inscricao i, utilizador u, disciplina d, turma t
			            where year(i.data_registo) in(year(Now())) and u.id=i.idutilizador and d.idDisciplina=i.iddisciplina
			            and t.descricao!='Nivel - 1' and t.idturma=i.idturma and t.descricao!='Nivel - 2' 
			            ORDER BY i.idutilizador asc) sub1
                    GROUP BY idutilizador
                    HAVING COUNT(*)<=2
                    ORDER BY idutilizador desc";
    }

    /**
     * Funcao retorna uma consulta de estudantes
     * @return string
     */
    function utilizadoresEdisciplinas(){
        return"select DISTINCT i.idinscricao, i.idutilizador, i.data_registo, i.iddisciplina, i.status_exame as estado, i.idturma
                    from inscricao i, utilizador u, disciplina d
                    where i.iddisciplina=d.idDisciplina and u.id=i.idutilizador";
    }

    /**
     * Funcao retorna uma consulta de estudantes com nota negativa no exame normal
     * @return string
     */
    function estudantesComNegativasExameNormal(){
        return "select en.nota, dataPub, a.nome, p.idusers as idutilizador, da.descricaoteste, p.idDisciplina, p.idcurso from pautanormal p, aluno a, estudante_nota en, data_avaliacao da	
				      where p.idusers=a.idutilizador and en.idaluno=a.idaluno and p.idPautaNormal=en.idPautaNormal and da.id_data=p.idTipoAvaliacao 
					    and da.descricaoteste='Exame Normal' and en.nota<10";
    }

    /**
     * Funcao retorna uma consulta de estudantes com nota negativa no exame de recorrencia
     * @return string
     */
    function estudantesComNegativasExameRecorrencia(){
        return "select en.nota, dataPub, a.nome, p.idusers as idutilizador, da.descricaoteste, p.idDisciplina, p.idcurso from pautanormal p, aluno a, estudante_nota en, data_avaliacao da
				      where p.idusers=a.idutilizador and en.idaluno=a.idaluno and p.idPautaNormal=en.idPautaNormal and da.id_data=p.idTipoAvaliacao 
					    and da.descricaoteste='Exame Recorrencia' and en.nota<10";
    }

    /**
     * Funcao retorna uma consulta de estudantes inscritos no ano corrente e
     * com no maximo duas disciplinas do 3 ou 4 nivel
     * @param1 mixed
     * @param2 mixed
     * @return string
     */

    function juntandoConsultasUmEDois($tab1, $tab2){

        return "select tab3.idinscricao, tab3.idutilizador, tab3.iddisciplina, tab3.data_registo, 
                  tab3.estado, tab3.idturma from (select tab2.idinscricao, tab1.idutilizador, tab2.data_registo,
                   tab2.iddisciplina, tab2.estado, tab2.idturma 
                      from ($tab1) as tab1, ($tab2) as tab2
                      where tab2.idutilizador=tab1.idutilizador ORDER BY tab2.idutilizador) as tab3
		          ";
    }

    /**
     * Funcao retorna uma consulta de estudantes com nota negativa
     * no exame normal e de recorrencia
     * @param1 mixed
     * @param2 mixed
     * @return string
     */

    function juntandoConsultasTresEQuatro($sub3, $sub4){
        return "select sub3.idutilizador, sub3.nota, sub3.dataPub, sub3.descricaoteste, sub3.idDisciplina, 
                      sub3.idcurso from 
		              (select DISTINCT sub2.idutilizador, sub2.nota, sub2.dataPub, sub2.descricaoteste, sub2.idDisciplina, 
		                sub2.idcurso from ($sub3) as sub1, ($sub4) as sub2	where sub1.idutilizador=sub2.idutilizador) as sub3
		                ORDER BY sub3.idDisciplina
		           ";
    }

    /**
     * Funcao retorna uma consulta de estudantes e disciplinas que se inscreveu no corrente ano e
     * com nota negativa no exame normal e de recorrencia
     * @return string
     */

    function juntandoTodasConsultas(){
        $consultas = new ExamesEspeciais();
		
		$tabela1 = $consultas->estudantesEscritosCorrenteAnoComDuasDisciplinasMaximo();
		$tabela2 = $consultas->utilizadoresEdisciplinas();

		$tabelaFinal_12= $consultas->juntandoConsultasUmEDois($tabela1, $tabela2);

		$tabela3 = $consultas->estudantesComNegativasExameNormal();
		$tabela4 = $consultas->estudantesComNegativasExameRecorrencia();

		$tabelaFinal_34 = $consultas->juntandoConsultasTresEQuatro($tabela3, $tabela4);


        $value= "select idinscricao, nomeCompleto, curso, d.descricao as disciplina, tab6.data_registo, tab6.nivelDaCadeira, 
                      tab6.estado from (select idinscricao, tab4.idutilizador,tab4.iddisciplina, c.descricao as curso, 
                      tab4.data_registo, estado, t.descricao as nivelDaCadeira from ($tabelaFinal_12) as tab4, ($tabelaFinal_34) as tab5, curso c, turma t
                      where tab4.iddisciplina=tab5.idDisciplina and tab4.idutilizador=tab5.idutilizador and c.idcurso=tab5.idcurso 
                          and t.idturma=tab4.idturma) as tab6, utilizador u, disciplina d
                      WHERE u.id=tab6.idutilizador and d.idDisciplina=tab6.iddisciplina and year(tab6.data_registo) in(year(Now()))
                  ";
        return $value;
    }

    /**
     * Funcao retorna uma lista de estudantes inscritos e com no maximo de duas disciplinas do 3 ou 4 ano
     * com notas negativas de exame normal e de recorrencia das mesmas
     * @param string
     * @return mixed
     */

    function result($query){
        $consultas = new ExamesEspeciais();
		$con = new mySQLConnection();
		$consultaGeral =  $consultas->juntandoTodasConsultas();

		$result = mysqli_query($con->openConection(), "select * from ($consultaGeral) as tab7 $query");

        $con->closeDatabase();
		return $result;
	}
}