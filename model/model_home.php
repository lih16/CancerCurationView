<?php

use Lib\model_base;
$logpath= "/hpc/users/siddio01/www/Development/";
$logfile='report.txt';
file_put_contents($file, $person, FILE_APPEND | LOCK_EX);
class Tumor_Model extends model_base
{
    public function __construct($stable = null, $aColumns = null, $sIndexColumn = null)
    {
        parent::__construct(null, null, null);
    }

    public function getTumor()
    {
        $result = "";
        $this->db = Db::getInstance();

        $sQuery = "select distinct cancer from kb_CancerVariant_Curation.CVC_cancer_gene_var_aws";
        $stmt = $this->db->prepare($sQuery);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            //write_log($e->getMessage());
            echo $e->getMessage();
        }
        $rResult = $stmt->fetchAll();
        foreach ($rResult as $aRow) {
            $result = $result . $aRow[0] . "\n";
        }
        return $result;
    }

    public function getGenes()
    {
        $cancer = $_POST["cancer"];


        $result = "";
        $this->db = Db::getInstance();
        $sQuery = "select distinct gene from kb_CancerVariant_Curation.CVC_cancer_gene_var_aws where cancer='" . $cancer . "'";
        $stmt = $this->db->prepare($sQuery);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            //write_log($e->getMessage());
            echo $e->getMessage();
        }
        $rResult = $stmt->fetchAll();
        foreach ($rResult as $aRow) {
            $result = $result . $aRow[0] . "\n";
        }
        return $result;
    }
    /*
    *This function will retrieve mutation based on selected tumor type and gene.
    *we get the flag information from here(if narrative/report style is written)
    */
    public function getGeneMutations()
    {
        $result = "";
        $cancer = $_POST["cancer"];
        $gene = $_POST["gene"];
        $this->db = Db::getInstance();
        #need combination for flag for display on front end
        $sQuery = "select distinct CONCAT(var,'#',flag) from kb_CancerVariant_Curation.CVC_cancer_gene_var_aws where cancer='" . $cancer . "' and gene='" . $gene . "'";
        $stmt = $this->db->prepare($sQuery);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            //write_log($e->getMessage());
            echo $e->getMessage();
        }
        $rResult = $stmt->fetchAll();
        foreach ($rResult as $aRow) {
            $result = $result . $aRow[0] . "\n";
        }
        return $result;
    }
// temp log file_exists


    public function getNarrative()
    {
      /* for DEBUG temp log file
      */
        $report = $_POST["report"];
        $result = "";
        $cancer = $_POST["cancer"];
        $gene = $_POST["gene"];
        //$variant  =str_replace("p.","",$_POST["variant"]);
        $variant = $_POST["variant"];
        $this->db = Db::getInstance();
        /**
         */
        //$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
        if ($report == 1) {
            $sQuery = "select narrative from kb_CancerVariant_Curation.CVC_viewer_admin_report_aws where gene = '" . $gene . "' and variant = '" . $variant . "'  and cancer = '" . $cancer . "'  order by date_admin desc limit 1";
            file_put_contents($logfile, $sQuery, FILE_APPEND );
        } else {
            $sQuery = "select narrative from kb_CancerVariant_Curation.CVC_viewer_admin_aws where gene = '" . $gene . "' and variant = '" . $variant . "'  and cancer = '" . $cancer . "'  order by date_admin desc limit 1";
            file_put_contents($logfile, $sQuery, FILE_APPEND );
        }
        //$stmt     = $this->db->prepare($sQuery);
        //echo $sQuery;
        //	$stmt->bindParam(':cancer', $cancer);
        // $stmt->bindParam(':gene', $gene);
        // $stmt->bindParam(':variant', $variant);
        //$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);


        $stmt = $this->db->prepare($sQuery);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            //write_log($e->getMessage());
            //DEBUG
            echo $e->getMessage();
            file_put_contents($logfile, $e->getMessage, FILE_APPEND);
        }
        $rResult = $stmt->fetchAll();
        $rowcount = $stmt->rowCount();
        //echo $rowcount;

        if ($rowcount == 1) {
            $result = $rResult[0][0];
            return $result;
        } else {
            /*
            check if the report or not

            */
            if ($report == 1) {
                $stmt = $this->db->prepare("INSERT INTO CVC_viewer_admin_report_aws (cancer, gene,variant,narrative,date_admin,ver_name) VALUES (:cancer, :gene,:mutation,:narrative,:date_admin,:ver_name)");
            } else {
                $stmt = $this->db->prepare("INSERT INTO CVC_viewer_admin_aws (cancer, gene,variant,narrative,date_admin,ver_name) VALUES (:cancer, :gene,:mutation,:narrative,:date_admin,:ver_name)");
            }
            $stmt->bindParam(':cancer', $cancer);
            $stmt->bindParam(':gene', $gene);
            $stmt->bindParam(':mutation', $mutation);
            $stmt->bindParam(':ver_name', $ver_name);
            // $stmt->bindParam(':uid', $uid);
            $stmt->bindParam(':date_admin', $date_admin);
            $stmt->bindParam(':narrative', $narrative);
            $mutation = $_POST["variant"];
            $cancer = $_POST["cancer"];
            $gene = $_POST["gene"];
            $ver_name = "original";
            //$uid        = $_POST["uid"];
            //$narrative  = $_POST["narrative"];
            $narrative = $this->getNarrative_origin();
            //DEBUG
            file_put_contents($logfile, $narrative, FILE_APPEND);
            if ($narrative != "1") {
                echo $narrative;


                $date_admin = date('Y-m-d H:i:s');
                try {
                    $stmt->execute();
                } catch (PDOException $e) {
                    //write_log($e->getMessage());
                    echo $e->getMessage();
                    //DEBUG
                    file_put_contents($logfile, $e->getMessage, FILE_APPEND);


                }
            }
        }
    }

    public function getNarrative_origin()
    {
        $result = "";
        $report = $_POST["report"];
        $this->db = Db::getInstance();

        if ($report == 1) {
            $sQuery = "select report_style from kb_CancerVariant_Curation.CVC_viewer_aws where gene = :gene and variant = :variant and cancer = :cancer";
        } else {
            $sQuery = "select narrative from kb_CancerVariant_Curation.CVC_viewer_aws where gene = :gene and variant = :variant and cancer = :cancer";
        }


        //  $sQuery   = "select narrative from kb_CancerVariant_Curation.CVC_viewer where gene = :gene and variant = :variant and cancer = :cancer";
        $stmt = $this->db->prepare($sQuery);
        $stmt->bindParam(':cancer', $cancer);
        $stmt->bindParam(':gene', $gene);
        $stmt->bindParam(':variant', $variant);
        $cancer = $_POST["cancer"];
        $gene = $_POST["gene"];
        $variant = str_replace("p.", "", $_POST["variant"]);
        //echo $variant."  ".$gene." ".$cancer;
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            write_log($e->getMessage());
            echo "fff" . $e->getMessage();
        }
        $rResult = $stmt->fetchAll();
        $count = $stmt->rowCount();

        if ($count > 0) {
            $result = $rResult[0][0];
        } else {
            $result = "1";
        }
        return $result;
    }

    public function saveComment()
    {
        $report = $_POST["report"];
        $this->db = Db::getInstance();
        if ($report == 1) {
            $stmt = $this->db->prepare("INSERT INTO CVC_viewer_editor_report_aws (cancer, gene,varaint,paragraph_id,uid,date_edit,comment,version_name) VALUES (:cancer, :gene,:varaint,:pid,:uid,:date_edit,:comment,:version_name)");
        } else {
            $stmt = $this->db->prepare("INSERT INTO CVC_viewer_editor_aws (cancer, gene,varaint,paragraph_id,uid,date_edit,comment,version_name) VALUES (:cancer, :gene,:varaint,:pid,:uid,:date_edit,:comment,:version_name)");
        }
        $stmt->bindParam(':cancer', $cancer);
        $stmt->bindParam(':gene', $gene);
        $stmt->bindParam(':varaint', $mutation);
        $stmt->bindParam(':pid', $pid);
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':date_edit', $date_edit);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':version_name', $version_name);

        $cancer = $_POST["cancer"];
        $gene = $_POST["gene"];
        $mutation = $_POST["mutation"];
        $pid = $_POST["pid"];
        $uid = $_POST["uid"];

        $comment = $_POST["comment"];
        $version_name = $_POST["version"];
        $date_edit = date('Y-m-d H:i:s');
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            //write_log($e->getMessage());
            echo $e->getMessage();
        }
    }

    public function getComment()
    {
        $cancer = $_GET["cancer"];
        $gene = $_GET["gene"];
        $mutation = $_GET["mutation"];
        $version = $_GET["version"];
        $report = $_GET["report"];


        $this->db = Db::getInstance();
        //$sQuery   = "select uid,comment,date_edit from  where cancer='" . $cancer . "'";

        if ($report == 1) {
            $stmt = $this->db->prepare("select paragraph_id, uid,comment,date_edit from CVC_viewer_editor_report_aws  where cancer= :cancer and gene = :gene and varaint = :mutation and version_name = :version order by paragraph_id asc"); // removed limit 1
        } else {
            $stmt = $this->db->prepare("select paragraph_id, uid,comment,date_edit from CVC_viewer_editor_aws  where cancer= :cancer and gene = :gene and varaint = :mutation and version_name = :version order by paragraph_id asc"); // removed limit 1
        }
        $stmt->bindValue(':gene', $gene);
        $stmt->bindValue(':mutation', $mutation);
        $stmt->bindValue(':cancer', $cancer);
        $stmt->bindValue(':version', $version);
        // $stmt->bindValue(':pid', $pid);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            //write_log($e->getMessage());
            echo $e->getMessage();
        }


        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    ////////////////
    public function modifyNarrative()
    {
        $status = $_POST["status"];
        $report = $_POST["report"];
        $this->db = Db::getInstance();
        if ($status == 1) {
            if ($report == 1) {
                $sql = "UPDATE CVC_viewer_admin_report_aws SET  narrative= :narrative,date_admin = :date_admin WHERE  ver_name = :ver_name and cancer= :cancer and gene = :gene and varaint = :mutation";
            } else {
                $sql = "UPDATE CVC_viewer_admin_aws SET  narrative= :narrative,date_admin = :date_admin WHERE  ver_name = :ver_name and cancer= :cancer and gene = :gene and varaint = :mutation";
            }
            $statement = $pdo->prepare($sql);
            $stmt->bindValue(':gene', $gene);
            $stmt->bindValue(':mutation', $mutation);
            $stmt->bindValue(':cancer', $cancer);
            $statement->bindValue(':narrative', $narrative);
            $statement->bindValue(':ver_name', $ver_name);
            $statement->bindValue(':date_admin', $date_admin);


            $cancer = "adf"; //$_POST["cancer"];
            $gene = $_POST["gene"];
            $ver_name = $_POST["ver_name"];
            $uid = $_POST["uid"];
            $narrative = $_POST["narrative"];
            $date_admin = date('Y-m-d H:i:s');
            try {
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        } else {
            if ($report == 1) {
                $stmt = $this->db->prepare("INSERT INTO CVC_viewer_admin_report_aws (cancer, gene,varaint,narrative,date_admin,ver_name) VALUES (:cancer, :gene,:varaint,:narrative,:date_admin,:ver_name)");
            } else {
                $stmt = $this->db->prepare("INSERT INTO CVC_viewer_admin_aws (cancer, gene,varaint,narrative,date_admin,ver_name) VALUES (:cancer, :gene,:varaint,:narrative,:date_admin,:ver_name)");
            }
            $stmt->bindParam(':cancer', $cancer);
            $stmt->bindParam(':gene', $gene);
            $stmt->bindParam(':varaint', $mutation);
            $stmt->bindParam(':ver_name', $ver_name);
            //$stmt->bindParam(':uid', $uid);
            $stmt->bindParam(':date_admin', $date_admin);
            $stmt->bindParam(':narrative', $narrative);

            $cancer = "adf"; //$_POST["cancer"];
            $gene = $_POST["gene"];
            $ver_name = $_POST["ver_name"];
            //$uid=$_POST["uid"];
            $narrative = $_POST["narrative"];
            // $narrative  = $_POST["narrative"];
            $date_admin = date('Y-m-d H:i:s');
            try {
                $stmt->execute();
            } catch (PDOException $e) {
                //write_log($e->getMessage());
                echo $e->getMessage();
            }
        }
    }

    public function getNarrativeList()
    {
        $report = $_GET["report"];
        if ($report == 1) {
            $table = 'CVC_viewer_admin_report_aws';
        } else {
            $table = 'CVC_viewer_admin_aws';
        }

        $primaryKey = 'ver_name';

        $columns = array(
            array(
                'db' => 'narrative',
                'dt' => 0
            ),
            array(
                'db' => 'ver_name',
                'dt' => 1
            ),
            array(
                'db' => 'date_admin',
                'dt' => 2
            )
        );

        $gene = $_GET['gene'];
        $cancer = $_GET['cancer'];
        $variant = $_GET['variant'];



        $whereResult = " gene='" . $gene . "' and cancer ='" . $cancer . "' and variant='" . $variant . "' ";
        // fwrite($fp, $whereResult);
        // fclose($fp);
        require('ssp.class.php');
        //$result=SSP::simple( $_GET, "", $table, $primaryKey, $columns );
        $result = SSP::complex($_GET, "", $table, $primaryKey, $columns, $whereResult, null);
        //fwrite($fp,$result);
        //fclose($fp);

        echo json_encode($result);
    }

    public function saveNarrative()
    {
        $report = $_POST["report"];
        $status = $_POST["saveormodify"];
        //echo $status;
        $this->db = Db::getInstance();
        if ($status == 1) {
            if ($report == 1) {
                $sql = "UPDATE CVC_viewer_admin_report_aws SET  narrative= :narrative,date_admin = :date_admin WHERE  ver_name = :ver_name and cancer= :cancer and gene = :gene and variant = :mutation";
            } else {
                $sql = "UPDATE CVC_viewer_admin_aws SET  narrative= :narrative,date_admin = :date_admin WHERE  ver_name = :ver_name and cancer= :cancer and gene = :gene and variant = :mutation";
            }
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':gene', $gene);
            $stmt->bindParam(':mutation', $mutation);
            $stmt->bindParam(':cancer', $cancer);
            $stmt->bindParam(':narrative', $narrative);
            $stmt->bindParam(':ver_name', $ver_name);
            $stmt->bindParam(':date_admin', $date_admin);
            $mutation = $_POST["mutation"];
            $cancer = $_POST["cancer"];
            $gene = $_POST["gene"];
            $ver_name = $_POST["ver_name"];
            $uid = $_POST["uid"];
            $narrative = $_POST["narrative"];
            $date_admin = date('Y-m-d H:i:s');
            echo $sql;
            try {
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        } else {
            if ($report == 1) {
                $stmt = $this->db->prepare("INSERT INTO CVC_viewer_admin_report_aws (cancer, gene,variant,narrative,date_admin,ver_name) VALUES (:cancer, :gene,:mutation,:narrative,:date_admin,:ver_name)");
            } else {
                $stmt = $this->db->prepare("INSERT INTO CVC_viewer_admin_aws (cancer, gene,variant,narrative,date_admin,ver_name) VALUES (:cancer, :gene,:mutation,:narrative,:date_admin,:ver_name)");
            }
            $stmt->bindParam(':cancer', $cancer);
            $stmt->bindParam(':gene', $gene);
            $stmt->bindParam(':mutation', $mutation);
            $stmt->bindParam(':ver_name', $ver_name);
            // $stmt->bindParam(':uid', $uid);
            $stmt->bindParam(':date_admin', $date_admin);
            $stmt->bindParam(':narrative', $narrative);
            $mutation = $_POST["mutation"];
            $cancer = $_POST["cancer"];
            $gene = $_POST["gene"];
            $ver_name = $_POST["ver_name"];
            $uid = $_POST["uid"];
            $narrative = $_POST["narrative"];

            $date_admin = date('Y-m-d H:i:s');
            try {
                $stmt->execute();
            } catch (PDOException $e) {
                //write_log($e->getMessage());
                echo $e->getMessage();
            }
        }
    }
}
