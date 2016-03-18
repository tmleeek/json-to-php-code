<?php
/*
Convert JSON to PHP Code
*/


########## Input JSON Here! ##########
$json = '{
    "Description": "This is an example of an edited DL.",
    "DisplayName": "ExampleDL",
    "IsHiddenFromAddressList": false,
    "EmailAddresses": [
        {
            "Action":"remove",
            "Value": "exampledl-alias@example.com",
            "AddressPrimary": false,
            "AddressProtocol": "smtp"
        }
     ],
    "Members": {
      "Recipients": [
      	{
      		"Action":"Remove",
      		"Value": 1
      	},
      	{
      		"Action":"Add",
      		"Value":"mexuser3"
      	}
       ]
    },
    "AcceptMessagesOnlyFrom": {
        "All":"restricted",
        "Recipients": [
      	{
      		"Action":"Remove",
      		"Value":"mexuser3"
      	},
      	{
      		"Action":"Add",
      		"Value":"mexuser2"
      	}
      ]
   }
}
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

?>
