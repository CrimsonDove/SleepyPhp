<?php
require "restClass.template.php";
class rest
{
	function callFunction($data)
	{
		//you can change this to whatever folder you would like
		$classFolder = "restClasses";
		
		if(file_exists($classFolder))
		{
			$callClass = $data['CLASS'];
			$callFunc = $data['FUNCTION'];
			
			$callGArgs = null;
			if(isset($data['G_ARGS']))
				$callGArgs = $data['G_ARGS'];
			
			$callFile = $classFolder.'/'.$callClass.'.php';
			
			//check if class/file exists
			if(file_exists($callFile))
			{
				//grabs the script file
				require $callFile;
				
				//checks if the function we are trying to call can be run
				if(is_callable($callClass.'::'.$callFunc))
				{
					$CLASS = new $callClass();
					
					//if no args call the class, if args call with args
					if($callGArgs == null)
						$CLASS->$callFunc();
					else
						$CLASS->$callFunc($callGArgs);
				}
			}
		}
		else
		{
			echo "folder '".$classFolder."' does not exit, please check your code";
		}
	}
}
	//main part of the script
	//gathers the get data sent via htaccess and parses it for data
	if(isset($_GET['data']))
	{
		//parse URI data
		$data	= htmlspecialchars( $_GET['data']);
		$frag	= explode('/', $data);
		$count	= count($frag);
		
		//Ignore ending /
		if($frag[$count-1] == '')
			$count -= 1;
		
		//our fancy shinanagins
		$output = null;
		
		if($count >= 2)
		{
			//sets the class & function were calling
			$output['CLASS'] = $frag[0];
			$output['FUNCTION'] = $frag[1];
			
			//checks to see if we have any arguments, or the proper argument amount
			if($count > 2 && $count%2 == 0)
			{			
				for($i = 2;$i <= $count-1; $i +=2)
				{
					$output['G_ARGS'][$frag[$i]] = $frag[$i+1];
				}
			}
			//if there is an extra argname at the end BUT it has no value ignore the argument
			else if($count > 2)
			{
				
				for($i = 2;$i <= $count-2; $i +=2)
				{
					$output['G_ARGS'][$frag[$i]] = $frag[$i+1];
				}
			}
			
			//Sends all parsed data to function to try and call c
			$restapi = new rest();
			$output['G_ARGS']['TYPE'] = 'GET';
			$restapi->callFunction($output);
		}
		else if($count == 1 && $data == "post")
		{
			//we can now send data via post, and the great thing is that you can use the EXACT SAME data via post or get and acheive the same results
			if(isset($_POST))
			{
				//make sure the two basic values are there
				if(isset($_POST['class']) && isset($_POST['function']))
				{
					$restapi = new rest();
					$postCount = count($_POST);
					
					$output = null;
					$output['CLASS'] = $_POST['class'];
					$output['FUNCTION'] = $_POST['function'];
					
					//check for arguments then send to the function caller
					if($postCount > 2)
					{
						foreach ($_POST as $key => $value)
						{
							if($key != 'class' && $key != 'function')
							{
								$output['G_ARGS'][$key] = $value;
							}
						}
					}
					
					$output['G_ARGS']['TYPE'] = 'POST';
					$restapi->callFunction($output);
				}
			}
		}
	}
?>
