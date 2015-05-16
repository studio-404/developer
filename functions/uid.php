<?php if(!defined("DIR")){ exit(); }
class uid{

	public function generate($length=9)
	{
	    $key = '';
	    list($usec, $sec) = explode(' ', microtime());
	    mt_srand((float) $sec + ((float) $usec * 100000));
	    $inputs = array_merge(range(0,9));
	    for($i=0; $i<$length; $i++)
	    {
	        $key .= $inputs{mt_rand(0,9)};
	    }
	    return $key;
	}

}
?>