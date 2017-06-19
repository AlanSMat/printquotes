<?php
class Query 
{
    public $result;

    public function __construct($query = false) 
    {    
        /*$this->pdo = new PDO(DSN, USER, PASS);
        if($query) 
        {
            return $stmt = $this->pdo->query($query);
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

    private function get_table_array ($table_name,$fields)
    {
        $prefix = substr_replace($table_name,"",3) . "_";

        foreach($fields as $key => $value) {
            if ($this->substring_exists($key,$prefix))
                $tableData[$key] = $value;			
        }	
        
        return $tableData;
    }    
    
    private function get_update_string($table_name, $fields) 
    {
        $fields = $this->get_table_array($table_name, $fields);		

        $updatestring = "";

        while(list($key,$value) = each($fields)) 
        {
            if(is_array($value)) {				  
                $x = 0;
                while(list($key2,$value2)=each($value)) 
                {
                    $valinput .= $value2;
                    if($x < count($value)-1) 
                    { 
                        $valinput .= ",";
                        $x++; 
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
        
        $update_info['query_values']  = $fields;
        $update_info['update_string'] = $updatestring;

        return $update_info;
    }        

    public function update_record($pdo,$table_name, $post_array, $where_clause = false) 
    {
        $update_info = $this->get_update_string($table_name, $post_array);

        $query_string = "UPDATE " . $table_name . " SET " . $update_info['update_string'] . " " . $where_clause . "";
        $query_values = $update_info['query_values'];
        $stmt         = $pdo->prepare($query_string);

        $stmt->execute();
    }        

    public function get_insert_string($table_name, $fields) {

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
            
            return $insert_string = "INSERT INTO " . $table_name . " (".$columnstring.") VALUES (".$valuestring.")";
            
        }
        
    }
    
    public function insert_record($pdo, $table_name, $fields) {

        $fields = $this->get_table_array($table_name, $fields);
            
        $insert_string = $this->get_insert_string($table_name, $fields);

        $stmt = $pdo->prepare($insert_string);
        $stmt->execute();

        return $pdo->lastInsertId();
        
    }    
    
    public function save($pdo, $table, $table_id, $id_value, $post_vars) 
    {
        $query_string = "SELECT count(*) FROM " . $table . " WHERE " . $table_id . "='" . $id_value . "'";
        $stmt         = $pdo->prepare($query_string);		
        $stmt->execute();
        $num_rows     = $stmt->fetchColumn();
        
        if($num_rows < 1 || isset($_POST["new"]))
        {
            return $insert_id = $this->insert_record($pdo, $table, $post_vars);
        }
        else 
        {
            $this->update_record($pdo, $table, $post_vars, "WHERE " . $table_id . "='" . $id_value . "'");
        }
    }    
}
?>
