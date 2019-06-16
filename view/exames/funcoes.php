<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sisto
 * Date: 6/13/2019
 * Time: 11:09 AM
 */

    class MYSQLConsultas{

        public function __construct(){
            //$this->estudantesEscritosCorrenteAnoComDuasDisciplinasMaximo();

        }

        /**
         * @return string
         */
        function estudantesEscritosCorrenteAnoComDuasDisciplinasMaximo(){

            return "select count(*) nr_de_inscricoes_correntes,idinscricao, idutilizador, data_registo, iddisciplina 
                    from 
	                  (select idinscricao, i.idutilizador, i.data_registo, i.iddisciplina 
			            from inscricao i, utilizador u, disciplina d
			            where year(i.data_registo) in(year(Now())) and u.id=i.idutilizador and d.idDisciplina=i.iddisciplina
			            ORDER BY i.idutilizador asc) sub1
                    GROUP BY idutilizador
                    HAVING COUNT(*)<=2
                    ORDER BY idutilizador desc";
        }

        function utilizadoresEdisciplinas(){
            return"select DISTINCT i.idinscricao, i.idutilizador, i.data_registo, i.iddisciplina, i.status_exame as estado, i.idturma
                    from inscricao i, utilizador u, disciplina d
                    where i.iddisciplina=d.idDisciplina and u.id=i.idutilizador";
        }

        function estudantesComNegativasExameNormal(){
            return "select en.nota, dataPub, a.nome, p.idusers as idutilizador, da.descricaoteste, p.idDisciplina, p.idcurso from pautanormal p, aluno a, estudante_nota en, data_avaliacao da	
				      where p.idusers=a.idutilizador and en.idaluno=a.idaluno and p.idPautaNormal=en.idPautaNormal and da.id_data=p.idTipoAvaliacao 
					    and da.descricaoteste='Exame Normal' and en.nota<10";
        }

        function estudantesComNegativasExameRecorrencia(){
            return "select en.nota, dataPub, a.nome, p.idusers as idutilizador, da.descricaoteste, p.idDisciplina, p.idcurso from pautanormal p, aluno a, estudante_nota en, data_avaliacao da
				      where p.idusers=a.idutilizador and en.idaluno=a.idaluno and p.idPautaNormal=en.idPautaNormal and da.id_data=p.idTipoAvaliacao 
					    and da.descricaoteste='Exame Recorrencia' and en.nota<10";
        }

        function estudantesDoNivelUm(){
            return"select DISTINCT idinscricao, i.idutilizador, i.iddisciplina, c.descricao as curso, i.data_registo, t.descricao as nivel
                    from inscricao i, curso c, turma t
                    WHERE t.descricao='Nivel - 1' and t.idturma=i.idturma and c.idcurso=t.idcurso
                    order by i.idutilizador DESC";
        }

        function estudantesDoNivelDois(){
            return"select DISTINCT idinscricao, i.idutilizador, i.iddisciplina, c.descricao as curso, i.data_registo, t.descricao as nivel
                    from inscricao i, curso c, turma t
                    WHERE t.descricao='Nivel - 2' and t.idturma=i.idturma and c.idcurso=t.idcurso
                    order by i.idutilizador DESC";
        }

        function juntandoConsultasUmEDois($tab1, $tab2){

            return "select tab3.idinscricao, tab3.idutilizador, tab3.iddisciplina, tab3.data_registo, 
                  tab3.estado, tab3.idturma from (select tab2.idinscricao, tab1.idutilizador, tab2.data_registo,
                   tab2.iddisciplina, tab2.estado, tab2.idturma 
                      from ($tab1) as tab1, ($tab2) as tab2
                      where tab2.idutilizador=tab1.idutilizador ORDER BY tab2.idutilizador) as tab3
		          ";
        }
        function juntandoConsultasTresEQuatro($sub3, $sub4){
            return "select sub3.idutilizador, sub3.nota, sub3.dataPub, sub3.descricaoteste, sub3.idDisciplina, 
                      sub3.idcurso from 
		              (select DISTINCT sub2.idutilizador, sub2.nota, sub2.dataPub, sub2.descricaoteste, sub2.idDisciplina, 
		                sub2.idcurso from ($sub3) as sub1, ($sub4) as sub2	where sub1.idutilizador=sub2.idutilizador) as sub3
		                ORDER BY sub3.idDisciplina
		           ";
        }

        function juntandoTodasConsultas($tab4, $tab5)
        {

            return "select distinct idinscricao, nomeCompleto, curso, d.descricao as disciplina, tab6.data_registo, tab6.nivelDaCadeira, 
                      tab6.estado from (select idinscricao, tab4.idutilizador,tab4.iddisciplina, c.descricao as curso, 
                      tab4.data_registo, estado, t.descricao as nivelDaCadeira from ($tab4) as tab4, ($tab5) as tab5, curso c, turma t
                      where tab4.iddisciplina=tab5.idDisciplina and tab4.idutilizador=tab5.idutilizador and c.idcurso=tab5.idcurso 
                          and t.idturma=tab4.idturma) as tab6, utilizador u, disciplina d
                      WHERE u.id=tab6.idutilizador and d.idDisciplina=tab6.iddisciplina and year(tab6.data_registo) in(year(Now()))
                  ";
        }

}

?>