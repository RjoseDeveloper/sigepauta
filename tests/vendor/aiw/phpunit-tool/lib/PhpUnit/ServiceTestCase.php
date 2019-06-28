<?php

namespace Aiw\PhpUnit;

/**
 * Description of ServiceTestCase
 *
 * @author ellie
 */
class ServiceTestCase extends \TestDbAcle\PhpUnit\AbstractTestCase {

    private $config = [];
    protected $databaseFacade;
    protected $adapter;

    function __construct() {
        $this->config = $this->getZendTestDbConfig();
        $this->adapter = new \Zend\Db\Adapter\Adapter($this->config);
        $this->databaseFacade = new \Aiw\Db\DatabaseFacade($this->adapter);
    }

    public function getZendTestDbConfig() {
        return [
            'driver' => 'Pdo',
            'dsn' => 'mysql:dbname=' . TEST_DB_NAME . ';host=' . TEST_DB_SERVER,
            'username' => TEST_DB_USERNAME,
            'password' => TEST_DB_PASSWORD,
            'driver_options' => array(
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
        )];
    }

    public function executeSql($sql) {
        $this->adapter->query($sql)->execute();
    }

    public function getTruncatedNow() {
        return date("Y-m-d");
    }

    public function getTestZendDb() {
        return $this->adapter;
    }

    protected function setAutoIncrementAs($table, $nextIncrement) {
        $this->executeSql("ALTER TABLE $table AUTO_INCREMENT = $nextIncrement");
    }

    public function providePdo() {

        return new \PDO($this->config['dsn'], $this->config['username'], $this->config['password']);
    }

    protected function assertException($expectedMessage, callable $callingWrapper) {
        try {
            $callingWrapper();
            $this->fail("Exception is thrown");
        } catch (\Exception $exception) {
            $this->assertEquals($expectedMessage, $exception->getMessage());
        }
    }

}
