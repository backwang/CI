<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2006 - 2011 EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 2.0
 * @filesource	
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Memcached Caching Class 
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Core
 * @author		ExpressionEngine Dev Team
 * @link		
 */

class CI_Cache_redis extends CI_Driver {

	 public        $_Server;
        public        $_Host;
        public        $_Port;
 
        public        $_Varvar;                //数组变量
        public        $_Vartime;                //时间变量
        public        $_Interval;                //时间间隔
        public        $_Runflag;                //执行开关
 
        function __construct()
        {
                $this->_Server        = new Redis();
                $this->_Host                = '127.0.0.1';
                $this->_Port                = '6379';
 
               // $this->_Varvar                = 'batchvar';
               // $this->_Vartime                = 'batchtime';
                $this->_Interval        = 50;
                $this->_Runflag                = false;
  
                $this->_Server->connect($this->_Host, $this->_Port);
                $this->_Server->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);    //存取操作必需要序列化，这点与memcached不同
                
        }
 
        /**
         * 添加
         */
        public function setex($key,$ttl,$value)
        {
                return $this->_Server->setex($key,$ttl, $value);
        }
 
        /**
         * 获取
         */
        public function get($key)
        {
                return $this->_Server->get($key);
        }
 
        /**
         * 清空
         */
        public function clear($id)
        {
                return $this->_Server->delete($id);
        }
 
        /**
         * 刷新
         */
        public function refresh($id)
        {
                return $this->_Server->set($id, time());
        }

		public function is_supported()
	{
		if ( ! extension_loaded('redis'))
		{
			log_message('error', 'The redis Extension must be loaded to use redis Cache.');
			
			return FALSE;
		}
		
		 
		return TRUE;
	}

}
// End Class

/* End of file Cache_memcached.php */
/* Location: ./system/libraries/Cache/drivers/Cache_memcached.php */