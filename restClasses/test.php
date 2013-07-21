<?php
class test extends restClassTemplate
{	
	public function helloWorld()
	{
		//checks the functions dynamic args against the args you want
		$args = $this->checkArgs(func_get_args(), array('value1'));
		
		if($args)
		{
			echo('Hello World<br/>Value1: '.$args['value1']);
			
			if(isset($args['value2']))
			{
				echo('<br/>Value2: '.$args['value2']);
			}
		}
	}
}
?>