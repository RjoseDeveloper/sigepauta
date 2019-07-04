<?php 
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;


class DataBaseFileConnTest extends TestCase{
 
    use TestCaseTrait;
    // só instancia o pdo uma vez para limpeza de teste e carregamento de ambiente
     static private $pdo = null;
     // só instancia PHPUnit_Extensions_Database_DB_IDatabaseConnection uma vez por teste
     private $conn = null;
     
     //cria um objecto que contem a conexao e o esquema de base de dados, explicitado no phpunit.xml
     
     /**
        * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
     public function getConnection(){
         if (!$this->conn) 
         {
             if (self::$pdo == null) 
             {
                 self::$pdo = new PDO( $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'],$GLOBALS['DB_PASSWD'] );
             }
             $this->conn = $this->createDefaultDBConnection(self::$pdo, $GLOBALS['DB_DBNAME']);
         }
         return $this->conn;
     }
     
     public function executeSelectQuery($myQuery){
      
         $conn = $this->getConnection()->getConnection();
         $query = $conn->query($myQuery);
         return $query->fetchAll(PDO::FETCH_ASSOC);
     }
     
     public function executeUpdateQuery($myQuery){
         $conn = $this->getConnection()->getConnection();
         $conn->query($myQuery);
     }
     
     public function executeDeleteQuery($myQuery){  
         $conn = $this->getConnection()->getConnection();
         $conn->query("SET FOREIGN_KEY_CHECKS=0");
         $conn->query($myQuery);
         $conn->query("SET FOREIGN_KEY_CHECKS=1");
     }
     
     public function executeInsertQuery($myQuery){    
         $conn = $this->getConnection()->getConnection();
         $conn->query($myQuery);
     }
    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
     public function getDataSet() {
         return null;
     }

}