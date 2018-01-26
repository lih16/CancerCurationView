<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

abstract class MyApp_Tests_DatabaseTestCase extends TestCase
{
    use TestCaseTrait;

    // only instantiate pdo once for test clean-up/fixture load
    static private $pdo = null;

    // only instantiate PHPUnit_Extensions_Database_DB_IDatabaseConnection once per test
    private $conn = null;

    final public function getConnection()
    {
        if ($this->conn === null) {
            if (self::$pdo == null) {
                self::$pdo = new PDO('mysql:dbname=CVC_cancer_gene_var_CAV_2;host=ec2-34-234-146-130', 'siddio01', 'fBNsPQ8YKF4G75vjA3zkzPAJ');
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, 'kb_CancerVariant_Curation');
        }

        return $this->conn;
    }
}
?>
