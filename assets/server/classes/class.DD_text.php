<?php
class DD_text
{	
	public function __construct() 
	{
            $this->pdo = new PDO(DSN, USER, PASS);
	}
	
	/*private function dd_value($query, $db_field, $id)
	{	 
	  $q = new Query($query);	
	  $i = 1;
	  $ary = array();
	  
          $q = $pdo->query($query);
                    
	  while($row = $q->fetch()) 
	  {	    
	    $ary[$i++] = $row["" . $db_field . ""];	
	  }	
	  
	  if(count($ary) == 0) 
	  {
	    echo "Error: dd_value array empty";
	    exit;
	  }
	  
	  return $ary[$id];
	}*/

	public function printer($printer_id = false, $return_prefix = true) 
	{
	    if(!$printer_id) { 
	        echo "Error: printer_id missing";
	        exit;
	    }
	  
            $stmt = $this->pdo->query("SELECT * FROM prn_printer WHERE prn_id='" . $printer_id . "'");
            $row = $stmt->fetchObject();
          
	    if($return_prefix) 
	    {
	        return substr(strtoupper($row->prn_printer), 0, 3);
	    }
	    else 
	    {
	        return $row->prn_printer;
	    }		  
	}
	
	public function binding($binding_id = false) 
	{
	    if(!$binding_id) { 
	        echo "Error: binding_id missing";
	        exit;
	    }
	  
            $stmt = $this->pdo->query("SELECT * FROM bin_binding WHERE bin_id='" . $binding_id . "'");
	  	  
	    return $row = $stmt->fetchObject();		  
	}	

	public function host_product($host_product_id = false) 
	{
	    if(!$host_product_id) { 
	        echo "Error: host_product_id missing";
	        exit;
	    }
	  
            $stmt = $this->pdo->query("SELECT * FROM hos_hostproduct WHERE hos_id='" . $host_product_id . "'");
          	  
	    return $row = $stmt->fetchObject();		  
	}
}

?>