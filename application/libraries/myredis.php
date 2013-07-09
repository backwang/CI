<?php
class Myredis 
{
	public $CI;
	public function __construct()
	{
		$this->CI =& get_instance();
		 
	}
	function query_cache($key, $model, $method, $params = array(), $ttl)
{
 

// Required model not loaded?
// Load models on demand
if( ! in_array($model, $CI->load->_ci_models, TRUE))
{ 
   $this->CI->load->model($model);
   
}
// Ref this model

$handler = & $this->CI->$model; 
// Cache is disabled when we are in DEV or other unkonwn situations
if( ! $this->CI->cache->redis->is_supported())
{ 
return call_user_func_array(array($handler, $method), $params);
}

// Valid cache item? If so, we've done!
if( ! $data = $this->CI->cache->redis->get($key))
{ 
	// Fetch data from model
	$data = call_user_func_array(array($handler, $method), $params);
	// WARINING: EMPTY results (such as 0, FALSE) may be ignored!
	if( ! empty($data))
	{
	// Make the results cacheable!
	$this->CI->cache->redis->setex($key, $ttl, $data);

 
	}
}
 

return $data;
}
}
?>