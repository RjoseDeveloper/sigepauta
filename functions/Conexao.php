<?php
	class mySQLConnection{
		
		private $connection;

        private $URL = "localhost";
        private $USER ="root";
        private $DB ="pautas_fe";
        private $PASSWORD="dblinkx";
        private $PORT ="3307";

		public function __construct(){
			$this->openConection();
			
			}
		public function openConection(){

			$this->connection = mysqli_connect($this->URL,$this->USER,$this->PASSWORD,$this->DB)
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



