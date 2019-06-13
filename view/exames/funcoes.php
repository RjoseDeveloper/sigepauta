<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sisto
 * Date: 6/13/2019
 * Time: 11:09 AM
 */

    class MYSQLConsultas{

        public function __construct(){
            $this->estudantesEscritosCorrenteAno();

        }

        //phpdocs
        function estudantesEscritosCorrenteAno(){

            return 'select tab2.idinscricao, tab1.idutilizador, tab2.data_registo, tab2.iddisciplina, tab2.status_exame as status, tab2.idturma  from 
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
					ORDER BY i.idutilizador) as tab2';
        }
    }

?>