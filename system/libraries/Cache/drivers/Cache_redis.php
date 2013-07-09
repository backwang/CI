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
 
        public        $_Varvar;                //�������
        public        $_Vartime;                //ʱ�����
        public        $_Interval;                //ʱ����
        public        $_Runflag;                //ִ�п���
 
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
                $this->_Server->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);    //��ȡ��������Ҫ���л��������memcached��ͬ
                
        }
 
        /**
         * ���
         */
        public function setex($key,$ttl,$value)
        {
                return $this->_Server->setex($key,$ttl, $value);
        }
 
        /**
         * ��ȡ
         */
        public function get($key)
        {
                return $this->_Server->get($key);
        }
 
        /**
         * ���
         */
        public function clear($id)
        {
                return $this->_Server->delete($id);
        }
 
        /**
         * ˢ��
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