<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

class MySqlGuestbookTest extends TestCase
{
    use TestCaseTrait;

    /**
     */
     public function getConnection()
         {
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
            $sql = "SELECT cancer, gene, var FROM CVC_cancer_gene_var_CAV_2";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
    // output data of each row
        while($row = $result->fetch_assoc()) {
          echo $row["cancer"]. $row["gene"]. $row["var"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
}
}
?>
