<?php

use Lib\model_base;

class Data_Manager_Model extends model_base
{
    public function __construct($stable = null, $aColumns = null, $sIndexColumn = null)
    {
        parent::__construct(null, null, null);
    }
    /* function to call cmd function to convert word to html
    * call cmd command and than return result
    *
    */
   private   function cmd_exec($cmd, &$stdout, &$stderr)
   {
    $outfile = tempnam(".", "cmd");
    $errfile = tempnam(".", "cmd");
    $descriptorspec = array(
        0 => array("pipe", "r"),
        1 => array("file", $outfile, "w"),
        2 => array("file", $errfile, "w")
    );
    $proc = proc_open($cmd, $descriptorspec, $pipes);

    if (!is_resource($proc)) return 255;

    fclose($pipes[0]);    //Don't really want to give any input

    $exit = proc_close($proc);
    $stdout = file($outfile);
    $stderr = file($errfile);

    unlink($outfile);
    unlink($errfile);
    return $exit;
    }
    /* uses cmd_exec to call java jar to convert word to html
    * call cmd_exec command and than return result
    * jar location is currently hardcoded
    * print_r is php function to Prints human-readable information about a variable
    * file_get_contents — Reads entire file into a string
    */

    private function getNarrativebyWord($inputWordFile, $outputHtmlFile)
    {
      $this->cmd_exec('java -jar /var/www/html/Development/tools/wordtohtml.jar '.$inputWordFile.'  '.$outputHtmlFile.' > logfile.txt',$returnvalue,$error);
      print_r($returnvalue);
      print_r($error);
      $output=file_get_contents($outputHtmlFile, true);
      return $output;
    }

    /* addPreNarrative
    *  adds pre-narrative to cvc_viewer  with narrative being converted from word to html
    */
    public function addPreNarrative($can_pre, $gene_pre, $alteration_pre)
    {
        //copy v$report = $_POST["report"];

        $this->db = Db::getInstance();

        $stmt = $this->db->prepare("INSERT INTO CVC_viewer (cancer, gene,variant,narrative) VALUES (:cancer, :gene,:variant,:narrative)");

        $stmt->bindParam(':cancer', $can_pre);
        $stmt->bindParam(':gene', $gene_pre);
        $stmt->bindParam(':variant', $alteration_pre);
        $stmt->bindParam(':narrative', $narrative1);
        //$stmt->bindParam(':curator', $curator);

        $narrative1 = $this->getNarrativebyWord("/var/www/html/Development/tools/PRE.doc","itworks.html");
        try {
            $stmt->execute();
            echo $e->getMessage();
            return 2;
        }
        catch (PDOException $e) {
            //write_log($e->getMessage());
            echo $e->getMessage();
            return 3;
        }
    }

    /* getPreNarrative
    *  gets pre-narrative Cancer-Gene-Alteration and narrative word file from user input
    */
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
              //  $curator = $_POST['curator']; //


                $query = "select narrative FROM CVC_viewer where cancer='" . $cancer . "' and gene='" . $gene . "' and variant='" . $variant . "'";
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
                    return $this->addPreNarrative($cancer, $gene,$variant);
                }
            }

        }
    }

    /* addReportNarrative
    *  adds Report-narrative to cvc_viewer  with narrative being converted from word to html
    */
    public function addReportNarrative($can_pre, $gene_pre, $alteration_pre )
    {

        $this->db = Db::getInstance();

        $stmt = $this->db->prepare("INSERT INTO CVC_viewer (cancer, gene,variant,report_style) VALUES (:cancer, :gene,:variant,:report_style)");

        $stmt->bindParam(':cancer', $can_pre);
        $stmt->bindParam(':gene', $gene_pre);
        $stmt->bindParam(':variant', $alteration_pre);
        $stmt->bindParam(':report_style', $report_style);
        //$stmt->bindParam(':curator', $curator);

        $report_style = $this->getNarrativebyWord("/var/www/html/Development/tools/PRE.doc","itworks.html");
        try {
            $stmt->execute();
            echo $e->getMessage();
            return 2;
        }
        catch (PDOException $e) {
            //write_log($e->getMessage());
            echo $e->getMessage();
            return 3;
        }
    }


    /* getReportNarrative
    *  gets Report-narrative Cancer-Gene-Alteration and narrative word file from user input
    */
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
              //  $curator = $_POST['curator']; //


                $query = "select report-style FROM CVC_viewer where cancer='" . $cancer . "' and gene='" . $gene . "' and variant='" . $variant . "'";
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
                    return $this->addPreNarrative($cancer, $gene,$variant);
                }
            }

        }
    }

    /* addAlteration
    *  add new row to cancer_gene_var
    */
    public function addAlteration($can, $gen, $alteratio, $oncotre)
    {
        //copy v$report = $_POST["report"];

        $this->db = Db::getInstance();

        $stmt = $this->db->prepare("INSERT INTO CVC_cancer_gene_var (cancer, gene,var,oncotreeCode) VALUES (:cancer, :gene,:var,:oncotreeCode)");

        $stmt->bindParam(':cancer', $can);
        $stmt->bindParam(':gene', $gen);
        $stmt->bindParam(':var', $alteratio);
        $stmt->bindParam(':oncotreeCode', $oncotree);

        $cancer     = $can;
        $gene       = $gen;
        $alteration = $alteratio;
        $oncotree   = $oncotre;


        try {
            $stmt->execute();
            echo $e->getMessage();
            return 2;
        }
        catch (PDOException $e) {
            //write_log($e->getMessage());
            echo $e->getMessage();
            return 3;
        }
    }

    /* getAlteration
    *  gets cancer, gene, alteration from user input
    */
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
                $onctree   = $_POST["oncotreeCode"];
                $query = "select id FROM CVC_cancer_gene_var where cancer='" . $cancer . "' and gene='" . $gene . "' and var='" . $alteration . "'";
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
                    echo $e->getMessage();

                } else {
                    return $this->addAlteration($cancer, $gene,$variant, $onctree);
                }
            }

        }
    }







}

?>
