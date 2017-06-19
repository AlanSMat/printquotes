<?php
class Query 
{
    public $result;

    public function __construct($query = false) 
    {        
        /*if($query) 
        {
            $stmt = $this->pdo->query($query);
            $this->query = $query;
            $this->result = $this->result($query);		
        }*/		
    }

    public function substring_exists($haystack, $needle) 
    {
        if(strpos($haystack, $needle) === false) {
            return 0;
        } else {
            return 1;
        }
    }

    public function result($query) 
    {
        $pdo = new PDO(DSN, USER, PASS);	

        if(isset($this->query) && $stmt = $pdo->query($this->query)) 
        { 			
            if($this->substring_exists(strtolower($query),"insert")) 
                return mysql_insert_id(); 
            elseif($this->substring_exists(strtolower($query),"^select")) 
                return $result; 
            else 
                return; 
        } 
    }        

    public function next($method = -1) 
    { 
        if($method === -1) 
            $method = 'ROW_AS_OBJECT'; 

        if($method === 'ROW_AS_OBJECT') 
            return $this->fetch_object_row(); 
        elseif($method === 'ROW_AS_ARRAY') 
            return $this->fetch_array_row(); 
    }        

    public function fetch_object_row() 
    {
        $stmt = $this->pdo->query($this->query);
        if(!($row = $stmt->fetchObject())) 
            return false; 
        else 
            return $row; 
    } 

    private function get_table_array ($table_name,$vars)
    {
        $prefix = substr_replace($table_name,"",3) . "_";

        foreach($vars as $key => $value) {
            if ($this->substring_exists($key,$prefix))
                $tableData[$key] = $value;			
        }	
        
        return $tableData;
    }    
    
    private function get_update_string($table_name, $vars) 
    {
        $vars = $this->get_table_array($table_name, $vars);		

        $updatestring = "";

        while(list($key,$value) = each($vars)) 
        {
            if(is_array($value)) {				  
                $x = 0;
                while(list($key2,$value2)=each($value)) 
                {
                    $valinput .= $value2;
                    if($x < count($value)-1) 
                    { 
                            $valinput .= ",";$x++; 
                    }
                }
                $columns[] = $key;
                $values[]  = $valinput;
                $x         = 0;
                $valinput  = "";
            }
            else 
            {
                $columns[] = $key;
                $values[]  = $value;
            }
        }

        $numcols = count($columns);
        $numvals = count($values);

        for($i=0;$i<$numcols;$i++) 
        {
            $updatestring .= $columns[$i] . "='" . $values[$i] . "'";

            if($i<$numcols-1) 
                    $updatestring .= ", ";	
        }

        $update_info['query_values']  = $vars;
        $update_info['update_string'] = $updatestring;

        return $update_info;
    }        
    
    public function select($query_string = false) 
    {
        $pdo = new PDO(DSN, USER, PASS);
        $stmt = $pdo->query($query_string);
        //$row = $stmt->fetchObject();
        return $stmt;        
        /*while($row = $stmt->fetchObject()) {
            echo $row->bin_id;
        }*/
        //return $row = $stmt->fetchObject();
        //while($stmt) {
            
        //}
        //return $stmt;
        /*try 
        {
            
            
            $stmt = $pdo->query($query_string);
            return $stmt;
            
        } catch(PDOException $e) {
            
            echo $e->getMessage();
            
        }*/
    }
    
    public function update_record($table_name, $post_array, $where_clause = false) 
    {
        $pdo = new PDO(DSN, USER, PASS);

        if(!$where_clause) 
        {
            throw new Exception("missing WHERE clause");			
        }

        $update_info = $this->get_update_string($table_name, $post_array);

        $query_string = "UPDATE " . $table_name . " SET " . $update_info['update_string'] . " " . $where_clause . "";
        $query_values = $update_info['query_values'];
        $stmt         = $pdo->prepare($query_string);

        $stmt->execute();
    }        
    
    /*
    
    public function connect() 	
    {
        MySQL::connect(DATABASE, HOST, USERNAME, PASSWORD);
    }



    public function num_rows($result = false)
    {
            if(!$result) 
            {
                    return mysql_num_rows($this->result);
            }
            else 		
            {
                    return mysql_num_rows($result);
            }
    }

*/ 

    /* 
     * object _fetch_object_row() 
     */ 
    /*public function fetch_object_row() 
    { 
                    if(!($row = mysql_fetch_object($this->result))) 
                                    return false; 
                    else 
                                    return $row; 
    } */

    /* 
     * array fetch_array_row() 
     */ 
    /*public function fetch_array_row() 
    { 
                    if(!($row = mysql_fetch_array($this->result))) 
                                    return false; 
                    else 
                                    return $row; 
    } 

    public function fetch_row_assoc() 
    {
      $row = mysql_fetch_assoc($this->result);
      $a = array();

            for ($i = 0; $i < mysql_num_fields($this->result); $i++) 
            {		
                    $meta = mysql_fetch_field($this->result, $i); 
                    $a["$meta->name"] = $row["$meta->name"];
            }

            if(count($a) > 0) 
            {
              return $a;
            }
            else 
            {
              throw new Exception("empty fetch_row_assoc array");		  
            }
    }

    public function row_register_session($session_name) 
    {
            $session_name = $this->fetch_row_assoc();
            session_register("session_name");
    }

    public function fetch_objects() 
    { 
                    $obj = Array(); 
                    while($val = @mysql_fetch_object($this->result)) 
                    { 
                                    $obj[] = $val; 
                    } 
                    return $obj; 
    } 

    public function fetch_arrays() 
    { 
                    $arr = Array(); 
                    while($val = @mysql_fetch_array($this->result)) 
                    { 
                                    $arr[] = $val; 
                    } 
                    return $arr; 
    } 

    public function insert_record($table_name, $fields) {

            $fields = $this->get_table_array($table_name, $fields);

            if (is_array($fields)) {		

                    $columnstring = "";
                    $valuestring  = "";

                    while(list($key,$value) = each($fields)) 
                    {
                            $columns[] = $key;
                            $values[]  = $value;					
                    }

                    $numcols = count($columns);
                    $numvals = count($values);

                    for($i = 0;$i < $numcols;$i++) 
                    {
                            $columnstring .= $columns[$i];
                            if($i < $numcols-1) 
                                    $columnstring .= ",";
                    }

                    for($i = 0;$i < $numvals;$i++) 
                    {
                            $valuestring .= "'$values[$i]'";
                            if($i < $numvals-1) 
                                    $valuestring .= ",";
                    }

                    $insert_string = "INSERT INTO ".$table_name." (".$columnstring.") VALUES (".$valuestring.")";

                    return $insert_id = $this->result($insert_string);			
            }
    }	


/*
    public function delete($table, $table_id, $id_value) 
    {
            $query_string = "DELETE FROM " . $table . " WHERE " . $table_id . "='" . $id_value . "'";
            $query = $this->result($query_string);
    }*/
	
}

?>
