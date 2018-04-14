<?php
/*
Convert JSON to PHP Code
*/
########## Input JSON Here! ##########
$json = '
{"id":"203","code":"wazn","label":"\u0627\u0644\u0648\u0632\u0646","options":[{"id":"50","label":"\u0631\u0628\u0639 \u062a\u0648\u0644\u0647","price":"100","products":["41"]},{"id":"49","label":"\u0646\u0635\u0641 \u062a\u0648\u0644\u0647","price":"200","products":["40"]},{"id":"48","label":"\u062a\u0648\u0644\u0647 \u0643\u0627\u0645\u0644\u0629","price":"400","products":["39"]}]}
';
########## Input JSON Here! ##########
$data = json_decode($json, true);
function print_boolean($condition){
    if($condition){
        return "true";
    } else {
        return "false";
    }
 }
 function is_multidimensional_array($a){
     foreach($a as $v){
       if(is_array($v)){
         return true;
       }
     }
     return false;
 }
function process_json($data, $step){
  foreach($data as $key => $value){
    if(is_array($value)){
      if(!is_multidimensional_array($value)){
        echo str_repeat("\t", $step) . 'array (' . "\n";
        process_json($value, $step + 1);
        echo str_repeat("\t", $step) . ")," . "\n";
      } else{
        echo str_repeat("\t", $step) . '"' . $key . '" => array (' . "\n";
        process_json($value, $step + 1);
        echo str_repeat("\t", $step) . ")," . "\n";
      }
    }
    else{
      if(is_bool($value)){
        echo str_repeat("\t", $step) . '"' . $key . '" => ' . print_boolean($value) . ',' . "\n";
      } elseif(is_numeric($value)){
        echo str_repeat("\t", $step) . '"' . $key . '" => ' . $value . ',' . "\n";
      } else{
        echo str_repeat("\t", $step) . '"' . $key . '" => "' . $value . '",' . "\n";
      }
    }
  }
}
echo "\$value = array(\n";
process_json($data, 1);
echo ");\n";

$value = array(
	"id" => 203,
	"code" => "wazn",
	"label" => "الوزن",
	"options" => array (
		"0" => array (
			"id" => 50,
			"label" => "ربع توله",
			"price" => 100,
			array (
				"0" => 41,
			),
		),
		"1" => array (
			"id" => 49,
			"label" => "نصف توله",
			"price" => 200,
			array (
				"0" => 40,
			),
		),
		"2" => array (
			"id" => 48,
			"label" => "توله كاملة",
			"price" => 400,
			array (
				"0" => 39,
			),
		),
	),
);


  function printCode($array, $path=false, $top=true) {
    $data = "";
    $delimiter = "~~|~~";
    $p = null;
    if(is_array($array)){
      foreach($array as $key => $a){
        if(!is_array($a) || empty($a)){
          if(is_array($a)){
            $data .= $path."['{$key}'] = array();".$delimiter;
          } else {
            $data .= $path."['{$key}'] = \"".htmlentities(addslashes($a))."\";".$delimiter;
          }
        } else {
          $data .= printCode($a, $path."['{$key}']", false);
        }    
      }
    }

    if($top){
      $return = "";
      foreach(explode($delimiter, $data) as $value){
        if(!empty($value)){
          $return .= '$array'.$value."<br>";
        }
      };
      return $return;
    }

    return $data;
  }
  
  
  echo printCode($value);
  
?>
