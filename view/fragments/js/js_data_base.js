var db = prepareDatabase();

var table_curso ='CREATE TABLE IF NOT EXISTS curso'+
'(idcurso INTEGER PRIMARY KEY, descricao TEXT )';

var table_acesso ='CREATE TABLE IF NOT EXISTS ctr_acesso '+
'(idacesso INTEGER PRIMARY KEY AUTOINCREMENT,user TEXT,pass TEXT, utilizador TEXT, fullname TEXT)';

var table_disciplina ='CREATE TABLE IF NOT EXISTS disciplina'+
'(id INTEGER,descricao TEXT, codigo TEXT)';

var table_pauta ='CREATE TABLE IF NOT EXISTS pauta_normal(idpauta INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,'+
                           'disciplina INTEGER , avaliacao INTEGER,curso INTEGER, data DATATIME,'+
						   'FOREIGN KEY (disciplina) REFERENCES disciplina (id),'+
						   'FOREIGN KEY (curso) REFERENCES curso (idcurso) )';

var table_estudante_nota ='CREATE TABLE IF NOT EXISTS estudante_notas'+
'(idestudante INTEGER PRIMARY KEY AUTOINCREMENT, nrmec TEXT,fullname TEXT, nota FLOAT, idpauta INTEGER, '+
'FOREIGN KEY (idpauta) REFERENCES pauta_normal (idpauta))';

var table_estudante ='CREATE TABLE IF NOT EXISTS estudante'+
'(id INTEGER PRIMARY KEY AUTOINCREMENT,nrmec INTEGER,fullname TEXT, idcurso INTEGER,'+
'FOREIGN KEY (idcurso) REFERENCES curso (idcurso))';


function rowButtons( id, traveler ) {
		return '<form align="center"><input type="button" class="salvar" data-mini="true" data-inline="true" value="Editar" onClick="javascript:editGo(' + id + ')"/>' +
			'<input type="button" value="Excluir" data-mini="true" class="salvar" data-inline="true" onClick="javascript:deleteGo(' + id + ', &quot;' + traveler + '&quot;)"/></form>';
	}

function countRows() {

            if(!db) return;
            db.transaction(function (t) {

                t.executeSql('SELECT COUNT(*) AS c FROM estudante_notas', [], function (t, r) {
                    var c = r.rows.item(0).c;
                    //element('rowCount').innerHTML = c ? c : 0;

                }, function(t, e) {
                    jAlert('countRows: ' + e.message,'Erro');
            });
      });
    }

 // Main display function
        function dispResults(val) {
            if(errorMessage) {
                element('results').innerHTML = errorMessage;
                return;
            }

            countRows();    // update the row count each time the display is refreshed
		    var bt = new bwTable();

			if (db){

                db.transaction(function(t) {    // readTransaction sets the database to read-only
                    t.executeSql('SELECT * FROM estudante_notas ORDER BY fullname ASC', [], function(t, r) {

                    if (r.rows.length > 0){
                        bt.setHeader(['Nr.Mec', 'Nome Completo', 'Classifica��o', 'Ac��es']);


                        for(var i = 0; i < r.rows.length; i++ ) {
                            var row = r.rows.item(i);
                            bt.addRow([row.nrmec, row.fullname, row.nota, rowButtons(row.idestudante, row.nrmec)]);
						}

                        //element('results').innerHTML = bt.getTableHTML();
                        //element('travelForm').elements['nota'].focus();

					}else{
						$('.sl').hide();
						$('.bwTable').hide();
					 }

					});
                });


			$('.preparar_pauta').click(function (){
				$('.bwTable').remove();
				$('.disciplinac').html("");
				preparar_pauta_env();
			});

		}

	} // fim funcao displya result


        function initDisp() {

               dispResults(0);
               db.transaction(function (t) {

				t.executeSql('SELECT COUNT(*) AS c FROM ctr_acesso', [], function (t, r) {
                    if (r.rows.item(0).c > 0 ){

					t.executeSql('SELECT fullname FROM ctr_acesso', [], function (t, r) {
                        $('.utilizador').html('Docente: '+r.rows.item(0).fullname); // insere dados na tabela ctr_acesso

					 }, function(t, e) {
						alert('Buscar nome Docente: ' + e.message);
					});

				} // insere dados na tabela ctr_acesso

                 }, function(t, e) {
                    alert('Insercao ctr_acesso: ' + e.message);
                });


                t.executeSql('SELECT COUNT(*) AS c FROM ctr_acesso', [], function (t, r) {
                    if (r.rows.item(0).c <= 0 ){ insertAcesso();



				}; // insere dados na tabela ctr_acesso

                 }, function(t, e) {
                    alert('Insercao ctr_acesso: ' + e.message);
                });

               t.executeSql('SELECT COUNT(*) AS c FROM disciplina', [], function (t, r) {
                    if(r.rows.item(0).c <= 0){ insertDisciplina(); }//insere tabela disciplina

                }, function(t, e) {alert('insercao disciplina: ' + e.message);

                });

                t.executeSql('SELECT COUNT(*) AS c FROM curso', [], function (t, r) {
                    if ( r.rows.item(0).c <= 0){ insertCurso();}  // insere tabela curso
                    }, function(t, e) {
                    alert('insercao do curso: ' + e.message);
                });

                 t.executeSql('SELECT COUNT(*) AS c FROM estudante', [], function (t, r) {

                          if ( r.rows.item(0).c <= 0){insertEstudante();} // insere tabela estudante

                    }, function(t, e) {
                    alert('insercao do estudante: ' + e.message);
                });
        })


  }


// verifica suporte ao browser

function getOpenDatabase() {

    try {

        if( !! window.openDatabase ) return window.openDatabase;
        else return undefined;

    } catch(e) {
        return undefined;
    }
}

// abre o banco de dados

function prepareDatabase() {
    var odb = getOpenDatabase();
    if(!odb) {

		dispError('Caro Utilizador:<br/>O navegador de internet  instalado no seu dispositivo n�o possui suporte para'+
		'armazenamento  de dados no espa�o local <br/>'+
			'aconselhamos que use os navegadores de internet como: <br/>'+
			'[1]-Opera<br/>-Sarari<br/>[4] � chrome<br/>[5] - opera-mobile  e obtenha as suas ultimas vers�es');

	return undefined;

    } else {
        var db = odb('esimop', '1.0','eSimop-ac', 10*1024*1024);

            db.transaction(function (t) {

            t.executeSql(table_pauta, [], function(t, r) {}, function(t, e) {
                alert('create pauta: ' + e.message);
            });

             t.executeSql(table_estudante_nota , [], function(t, r) {}, function(t, e) {
                alert('create estudante_nota: ' + e.message);
            });

            t.executeSql(table_curso, [], function(t, r) {}, function(t, e) {
                alert('create curso: ' + e.message);
            });

            t.executeSql(table_estudante, [], function(t, r) {}, function(t, e) {
                alert('create estudante: ' + e.message);
            });

            t.executeSql(table_acesso, [], function(t, r) {}, function(t, e) {
                alert('create acesso: ' + e.message);
            });

             t.executeSql(table_disciplina, [], function(t, r) {}, function(t, e) {
                alert('create disciplina: ' + e.message);
            });
        });
        return db;
    }
}



  function insertEstudante () {

       $.ajax({

          url: "offlineApp/Sqlite_data_base.php",
          type:"POST",
          data:{acao:3},
          dataType:"json",
          success: function (result){

          db.transaction( function(t) {

              for (var i =0; i< result.length; i++){

                    t.executeSql('INSERT INTO estudante(nrmec,fullname,idcurso) VALUES (?, ?, ? )',
                               [result[i].nrmec, result[i].fullname, result[i].curso],function(t, r) {},
                                function(t, e) {
                                    alert('create estudante: ' + e.message);
                    });
               }

             });

                 } // fim sucesss
        }) // fim ajax;

     }

     function insertCurso() {

            $.ajax({

                    url: "offlineApp/Sqlite_data_base.php",
                    type:"POST",
                    data:{acao:4},
                    dataType:"json",

                   success: function (result){

                           db.transaction( function(t) {
                              for (var i =0; i< result.length; i++){

                                t.executeSql('INSERT INTO curso(idcurso,descricao) VALUES(?,?)',[result[i].id, result[i].descricao] ,function(t, r) {},
                                function(t, e) {
                                    alert('insert curso: ' + e.message);
                                });


                              }

                           })
                    }
            });

     }

	 function insertAcesso() {

             $.ajax({
                    url: "offlineApp/Sqlite_data_base.php",
                    type:"POST",
                    data:{acao:1},
                    dataType:"json",
                    success: function (result){

                          db.transaction( function(t) {

                             t.executeSql('INSERT INTO ctr_acesso(user,pass,utilizador,fullname) VALUES (?,?,?,?)',
                                 [result[0].username, result[0].password,result[0].utilizador, result[0].fullname],
                                 function(t, r) {}, function(t, e) { alert('insert ctr_acesso: ' + e.message);
                           });

                         })

                     }
          });

     }

     function insertDisciplina () {


              $.ajax({

                    url: "offlineApp/Sqlite_data_base.php",
                    type:"POST",
                    data:{acao:5},
                    dataType:"json",
                    success: function (result){

                    db.transaction( function(t) {

                        for (var i = 0; i< result.length; i++){

                             t.executeSql('INSERT INTO disciplina(id,descricao,codigo) VALUES (?, ?, ? )',
                             [result[i].id, result[i].descricao,result[i].codigo], function(t, r) {}, function(t, e) {
                                    alert('create estudante: ' + e.message);
                              });

                          }
                     });
                  }
          })
}



/*---------------------------- Fim banco de dados ---------------------------------------------------------------*/


