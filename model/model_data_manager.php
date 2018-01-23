<?php

use Lib\model_base;

class Data_Model extends model_base
{
    public function __construct($stable = null, $aColumns = null, $sIndexColumn = null)
    {
        parent::__construct(null, null, null);
    }
    /* function to register new user
    * create new user
    *
    */
    public function addAlteration($cancer, $gene, $alteration, $oncotree)
    {
        //copy v$report = $_POST["report"];

        $this->db = Db::getInstance();

        $stmt = $this->db->prepare("INSERT INTO CVC_cancer_gene_var (cancer, gene,var,oncotreeCode) VALUES (:cancer, :gene,:var,:oncotreeCode)");

        $stmt->bindParam(':cancer', $cancer);
        $stmt->bindParam(':gene', $gene);
        $stmt->bindParam(':var', $alteration);
        $stmt->bindParam(':oncotreeCode', $oncotree);


        try {
            $stmt->execute();
            return 2;
        }
        catch (PDOException $e) {
            //write_log($e->getMessage());
            echo $e->getMessage();
            return 3;
        }
    }
    public function getAlteration()
    {
        //session_start(); // Starting Session

        $error = ''; // Variable To Store Error Message
        //    if (isset($_POST['submit']))
        {
            $this->db = Db::getInstance(); {
                // Define $username and $password
                $cancer  = $_POST['cancer'];
                $gene  = $_POST['gene']; //
                $variant  = $_POST['alteration']; //
                $query = "select altID FROM CVC_cancer_gene_var where cancer='" . $cancer . "' and gene='" . $gene . "' and variant='" . $alteration . "'";
                $stmt = $this->db->prepare($query);
                try {
                    $stmt->execute();
                }
                catch (PDOException $e) {
                    //write_log($e->getMessage());
                    echo $e->getMessage();
                }
                $rows     = $stmt->fetchAll();
                $num_rows = count($rows);

                if ($num_rows == 1) {

                    return 1; //indicated that Id alreaday exist;

                } else {
                    return $this->addAlteration($cancer, $gene,$variant);
                }
            }

        }
    }

    public function addPreNarrative($cancer, $gene, $alteration,$narrative,$curator )
    {
        //copy v$report = $_POST["report"];

        $this->db = Db::getInstance();

        $stmt = $this->db->prepare("INSERT INTO CVC_viewer (cancer, gene,variant,narrative, curator) VALUES (:cancer, :gene,:variant,:narrative,:curator)");

        $stmt->bindParam(':cancer', $cancer);
        $stmt->bindParam(':gene', $gene);
        $stmt->bindParam(':variant', $alteration);
        $stmt->bindParam(':narrative', $narrative);
        $stmt->bindParam(':curator', $curator);


        try {
            $stmt->execute();
            return 2;
        }
        catch (PDOException $e) {
            //write_log($e->getMessage());
            echo $e->getMessage();
            return 3;
        }
    }
    public function getPreNarrative()
    {
        //session_start(); // Starting Session

        $error = ''; // Variable To Store Error Message
        //    if (isset($_POST['submit']))
        {
            $this->db = Db::getInstance(); {
                // Define $username and $password
                $cancer  = $_POST['cancer'];
                $gene  = $_POST['gene']; //
                $variant  = $_POST['alteration']; //
                $narrative  = $_POST['narrative']; //
                $query = "select narrative FROM CVC_viewer where cancer='" . $cancer . "' and gene='" . $gene . "' and variant='" . $alteration . "'";
                $stmt = $this->db->prepare($query);
                try {
                    $stmt->execute();
                }
                catch (PDOException $e) {
                    //write_log($e->getMessage());
                    echo $e->getMessage();
                }
                $rows     = $stmt->fetchAll();
                $num_rows = count($rows);

                if ($num_rows == 1) {

                    return 1; //indicated that Id alreaday exist;

                } else {
                    return $this->addPreNarrative($cancer, $gene,$variant,$narrative,$curator);
                }
            }

        }
    }

    public function addReportNarrative($cancer, $gene, $alteration,$narrative,$curator )
    {
        //copy v$report = $_POST["report"];

        $this->db = Db::getInstance();

        $stmt = $this->db->prepare("INSERT INTO CVC_viewer (cancer, gene,variant,narrative, curator) VALUES (:cancer, :gene,:variant,:narrative,:curator)");

        $stmt->bindParam(':cancer', $cancer);
        $stmt->bindParam(':gene', $gene);
        $stmt->bindParam(':variant', $alteration);
        $stmt->bindParam(':narrative', $narrative);
        $stmt->bindParam(':curator', $curator);


        try {
            $stmt->execute();
            return 2;
        }
        catch (PDOException $e) {
            //write_log($e->getMessage());
            echo $e->getMessage();
            return 3;
        }
    }
    public function getReportNarrative()
    {
        //session_start(); // Starting Session

        $error = ''; // Variable To Store Error Message
        //    if (isset($_POST['submit']))
        {
            $this->db = Db::getInstance(); {
                // Define $username and $password
                $cancer  = $_POST['cancer'];
                $gene  = $_POST['gene']; //
                $variant  = $_POST['alteration']; //
                $reportStyle  = $_POST['reportStyle']; //
                $query = "select report-style FROM CVC_viewer where cancer='" . $cancer . "' and gene='" . $gene . "' and variant='" . $alteration . "'";
                $stmt = $this->db->prepare($query);
                try {
                    $stmt->execute();
                }
                catch (PDOException $e) {
                    //write_log($e->getMessage());
                    echo $e->getMessage();
                }
                $rows     = $stmt->fetchAll();
                $num_rows = count($rows);

                if ($num_rows == 1) {

                    return 1; //indicated that Id alreaday exist;

                } else {
                    return $this->addReportNarrative($cancer, $gene,$variant,$reportStyle,$curator);
                }
            }

        }
    }






}

?>
