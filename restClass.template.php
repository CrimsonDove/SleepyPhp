<?php
class restClassTemplate
{
	function __construct()
	{
	}
	
	//Checks the arguments sent and tests them against an array
	//used to see if the sent arguments match what you require
	public function checkArgs($inArgs, $test)
	{
		//counts the input args and required args
		$countArgs = count($inArgs);
		$countTest = count($test);
		
		//checks to make sure theres actually arguments
		if($countArgs == 1 && $countTest > 0)
		{
			$countArgs = count($inArgs[0]);
			$inArgs = $inArgs[0];
		}
		else
			return null;
		
		//gets the keys of the array members
		$keys = array_keys($inArgs);
		
		//a counter to see how many contained keys we have
		$containCount = 0;
		for($a=0; $a<$countArgs; $a++)
		{
			for($t=0; $t<$countTest; $t++)
			{
				if($keys[$a] == $test[$t])
				{
					$containCount ++;
					break;
				}
			}
		}
		
		//checks if we met the requirements
		if($containCount == $countTest)
			return $inArgs;
		else
			return null;
		
	}
	
	public function serialize($command, $array)
	{
		$buffer = "";
		foreach($array as $key=>$value)
		{
			$buffer .= $key.": ".$value."\r\n";
		}
		
		return strtoupper(bin2hex($command."\r\n".$buffer."\r\n"));
	}
}
?>