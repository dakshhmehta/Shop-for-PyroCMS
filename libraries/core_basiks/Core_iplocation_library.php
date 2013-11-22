<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


//http://api.hostip.info/?ip=223.27.30.14

class Core_iplocation_library
{
	protected $errors = array();
	protected $service = 'api.hostip.info/?ip';
	protected $option = '?ip';
	protected $apiKey = '';

	public function __construct(){}

	public function __destruct(){}

	public function setKey($key)
	{
		if(!empty($key)) $this->apiKey = $key;
	}

	public function getError()
	{
		return $this->errors;
	}


	public function do_check($host)
	{
		return $this->getResult($host);
	}




	private function getResult($host)
	{
		$ip = @gethostbyname($host);

		if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6))
		{
			$xml = @file_get_contents('http://' . $this->service . '/' . $this->option . '=' . $ip);


			if (get_magic_quotes_runtime())
			{
				$xml = stripslashes($xml);
			}

			try
			{
				$response = @new SimpleXMLElement($xml);

				foreach($response as $field=>$value)
				{
					$result[(string)$field] = (string)$value;
				}

				return $result;
			}
			catch(Exception $e)
			{
				$this->errors[] = $e->getMessage();
				return;
			}
		}

		$this->errors[] = '"' . $host . '" is not a valid IP address or hostname.';
		return;
	}
}
