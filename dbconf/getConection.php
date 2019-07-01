<?php
	class mySQLConnection{
		
		private $connection;

        private $URL = "localhost";
        private $USER ="root";
        private $DB ="pautas_fe";
        private $PASSWORD="mysql";
        private $PORT ="3306";

//    private $URL = "jsftj8ez0cevjz8v.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
//    private $USER ="ufm6xc4c1m8wcg8b";
//    private $DB ="ja75c6n0soets4l4";
//    private $PASSWORD="g3ellqs2nhznnd7b";
//    private $PORT ="3306";

		public function __construct(){
			$this->openConection();
			
			}
		public function openConection(){

			$this->connection = mysqli_connect($this->URL,$this->USER,$this->PASSWORD,$this->DB,$this->PORT)
				or die(mysqli_error());
			return($this->connection);
				}
				
		public function closeDatabase(){
			if (isset($this->connection)){
				mysqli_close($this->connection);
				unset($this->connection);
				}
			}
		public function query($sql){
			$result = mysqli_query($sql, $this->connection);
			if (!$result){
				die("Erro no metodo de Consulta: ".mysqli_errno());
			}
		return($result);
		}
	
	}
	
?>



