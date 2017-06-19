<?php 
function dump($array) 
{
	foreach($array as $key => $value) 
	{
		if(!is_array($array)) 
		{
			echo "Error: supplied value not an array";
			exit;
		}
		echo $key . " " . $value . "<br />";
	}
}

function rt_date($timestamp) 
{	
  return date("d M Y", $timestamp);	
}
  
function check_isset($id) 
{
  if(isset($id)) 
  {
  	return $id;
  }
  else 
  {
  	return 0;
  }
  	
}

function clean_string($string) 
{
    $string = str_replace("$", "", $string);
    $string = str_replace(",", "", $string);
  
    return $string;
}

function substring_exists($needle, $haystack) {
    if(strpos($haystack, $needle) === false) {
        return 0;
    } else {
        return 1;
    }
}
?>