<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

class MySqlGuestbookTest extends TestCase
{
    use TestCaseTrait;

    /**
     */
     public function setUp()
         {
            parent::setUp();
            $servername = "34.234.146.130";
            $username = "siddio01";
            $password = "fBNsPQ8YKF4G75vjA3zkzPAJ";
            $dbname = "kb_CancerVariant_Curation";
            // Create connection
            $pdo = new PDO('mysql:...', $user, $password);
            return $this->createDefaultDBConnection($pdo, $database);

          }

          public function sampleQuery()
          {
            $tableNames = ['CVC_cancer_gene_var_CAV_2'];
            $dataSet = $this->setUp()->createDataSet();
            return $dataSet;

}
}
?>
