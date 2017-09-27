<?php

namespace Lib;
use Db;
class model_base { 
    private $aColumns ;//= array(); 
	private $sOrder="";
	private $sLimit="";
    private $sIndexColumn;// = "counts";
	private $db;
	private $sWhere="";

	private $sTable ;
	public function __construct($stable=NULL,$aColumns=NULL, $sIndexColumn=NULL){
		$this->aColumns = $aColumns;
	    $this->sIndexColumn = $sIndexColumn;
		$this->sTable =$stable;
	}
	public function initTable($stable=NULL,$aColumns=NULL, $sIndexColumn=NULL){
		$this->aColumns = $aColumns;
	    $this->sIndexColumn = $sIndexColumn;
		$this->sTable =$stable;
	}
	public function set_no_cache($set_no_cache = true){
		if (!$set_no_cache) {
			return;
		}
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Cache-Control: no-cache, must-revalidate");
	}
    public function set_display(){
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	    {
		    $this->sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
			mysql_real_escape_string( $_GET['iDisplayLength'] );
	    }
		
	}
	public function set_orderby() {
		
		   $fp = fopen('data.txt', 'a');
fwrite($fp, 'asortb');
fwrite($fp, $_GET['iSortCol_0']);
fwrite($fp, 'endsor');
fclose($fp);
		
		if ( isset( $_GET['iSortCol_0'] ) ){
			$this->sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$this->sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
						".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
				}
			}
		
			$this->sOrder = substr_replace( $sOrder, "", -2 );
			if ( $this->sOrder == "ORDER BY" )
			{
				$this->sOrder = "";
			}
	   };		
	}
	public function add_where($fieldcolumn,$fieldvalue){
		    //$this->sWhere .= $where;
			
		   if ( $this->sWhere == "" )
			{
				$this->sWhere = "WHERE ";
			}
			else
			{
				$this->sWhere .= " AND ";
			}
			$this->sWhere .= $fieldcolumn." = '".$fieldvalue."' ";
			
		
	}
	
	public function set_json_content_type() {
		if (defined('DEBUG')) {
			header('Content-Type: application/x-javascript; charset=UTF-8');						
		} else {
			header('Content-Type: application/json');				
		}
	}
	
	public function is_ajax_request() {
	    return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
	}	
	
	public function send_json() {
		
		
		$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $this->aColumns))."
			FROM   
			$this->sTable
			$this->sWhere
			$this->sOrder
			$this->sLimit
		";
	     $fp = fopen('data.txt', 'a');
fwrite($fp, 'yyy1');
fwrite($fp, $sQuery);
fclose($fp);
				
		$this->db = Db::getInstance();
		
		
		$stmt = $this->db->prepare($sQuery);
		try{
		    $stmt->execute();
		}
		catch (PDOException $e){
			//write_log($e->getMessage());
			echo $e->getMessage();
        }
		$rResult = $stmt->fetchAll();
		
		//$rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
		$sQuery = "SELECT FOUND_ROWS()";
		//$rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
		//$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
		$stmt = $this->db->prepare($sQuery);
		try{
		    $stmt->execute();
		}
		catch (PDOException $e){
			//write_log($e->getMessage());
        }
		$aResultFilterTotal=$stmt->fetchAll();
		$iFilteredTotal = $aResultFilterTotal[0][0];
	
	
		$sQuery = "
			SELECT COUNT(".$this->sIndexColumn.")
			FROM   $this->sTable
		";
		$stmt = $this->db->prepare($sQuery);
		try{
		    $stmt->execute();
		}
		catch (PDOException $e){
			write_log($e->getMessage());
        }
		$aResultTotal = $stmt->fetchAll();
		//$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
		//$aResultTotal = mysql_fetch_array($rResultTotal);
		$iTotal = $aResultTotal[0][0];
	
	
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		$m_id=0;
		//while ( $aRow =  $rResult  )
		foreach($rResult as $aRow){
			$row = array();
			for ( $i=0 ; $i<count($this->aColumns) ; $i++ ){
				$row[] = $aRow[ $this->aColumns[$i] ];
			}
			$output['aaData'][] = $row;
		}
	
		echo json_encode( $output );
	}
	
	public function send_javascript_var($var_name, $php_var, $add_var_text = true,$set_no_cache = true) {
		$this->set_no_cache($set_no_cache);			
		$this->set_javascript_content_type();			
		echo Json::get_var($var_name, $php_var, $add_var_text);
	}
	public function set_search(){
		   $fp = fopen('data.txt', 'a');
fwrite($fp, 'asearchb');
fwrite($fp, $_GET['sSearch']);
fwrite($fp, 'ends');
fclose($fp);
		if(isset($_GET['sSearch'])){
			if ( $_GET['sSearch'] != "" ) {
				$this->sWhere = "WHERE (";
				for ( $i=0 ; $i<count($this->aColumns) ; $i++ ){
					$this->sWhere .= $this->aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
				}
				$this->sWhere = substr_replace( $this->sWhere, "", -3 );
				$this->sWhere .= ')';
				
			}
		}
	}


}
	
