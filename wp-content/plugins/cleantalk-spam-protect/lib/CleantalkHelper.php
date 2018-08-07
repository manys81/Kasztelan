<?php

class CleantalkHelper
{
	const URL = 'https://api.cleantalk.org';
	
	public static $cdn_pool = array(
		'cloud_flare' => array(
			'103.21.244.0/22',
			'103.22.200.0/22',
			'103.31.4.0/22',
			'104.16.0.0/12',
			'108.162.192.0/18',
			'131.0.72.0/22',
			'141.101.64.0/18',
			'162.158.0.0/15',
			'172.64.0.0/13',
			'173.245.48.0/20',
			'188.114.96.0/20',
			'190.93.240.0/20',
			'197.234.240.0/22',
			'198.41.128.0/17',
		),
	);
	
	/*
	*	Getting arrays of IP (REMOTE_ADDR, X-Forwarded-For, X-Real-Ip, Cf_Connecting_Ip)
	*	reutrns array('remote_addr' => 'val', ['x_forwarded_for' => 'val', ['x_real_ip' => 'val', ['cloud_flare' => 'val']]])
	*/
	static public function get_ips()
	{	
		$ips = array(
			'remote_addr'     => '',
			'x_forwarded_for' => '',
			'x_real_ip'       => '',
			'cloud_flare'     => '',
		);
		$headers = self::get_request_headers();
		
		// Getting IP
		
		// REMOTE_ADDR
		$ips['remote_addr'] = $_SERVER['REMOTE_ADDR'];
		
		// X-Forwarded-For
		if( isset($headers['X-Forwarded-For']) ){
			$tmp = explode(",", trim($headers['X-Forwarded-For']));
			$ips['x_forwarded_for']= trim($tmp[0]);
		}
		
		// X-Real-Ip
		if(isset($headers['X-Real-Ip'])){
			$tmp = explode(",", trim($headers['X-Real-Ip']));
			$ips['x_real_ip']= trim($tmp[0]);
		}
		
		// Cloud Flare
		if(isset($headers['Cf_Connecting_Ip'])){
			foreach(self::$cdn_pool['cloud_flare'] as $cidr){
				if($this->ip_mask_match($ips['remote_addr'], $cidr)){
					$ips['cloud_flare'] = $headers['Cf_Connecting_Ip'];
					break;
				}
			}
		}
		
		// Validating IPs
		foreach($ips as $key => $ip){
			$ips[$key] = self::ip_validate($ip) 
				? $ip
				: null;
		}
		return $ips;
	}
	
	/*
	*	Getting IP from REMOTE_ADDR or Cf_Connecting_Ip if set
	*	reutrns (string)
	*/
	static public function get_ip_real()
	{	
		$headers = self::get_request_headers();
		
		// REMOTE_ADDR
		$ip = $_SERVER['REMOTE_ADDR'];
		
		// Cloud Flare
		if(isset($headers['Cf_Connecting_Ip'])){
			foreach(self::$cdn_pool['cloud_flare'] as $cidr){
				if($this->ip_mask_match($ips['remote_addr'], $cidr)){
					$ip = $headers['Cf_Connecting_Ip'];
					break;
				}
			}
		}
		
		return self::ip_validate($ip) ? $ip : false;
	}
	
	// Return validated REMOTE_ADDR
	static public function get_ip_remote_addr()
	{
		if(isset($_SERVER['REMOTE_ADDR'])){
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return isset($ip) && self::ip_validate($ip) ? $ip : null;
	}
	
	// Return validated X-Forwarded-For
	static public function get_ip_x_forwarded_for()
	{
		$headers = self::get_request_headers();
		if(isset($headers['X-Forwarded-For'])){
			$tmp = explode(',', trim($headers['X-Forwarded-For']));
			$ip  = trim($tmp[0]);
		}
		return isset($ip) && self::ip_validate($ip) ? $ip : null;
	}
	
	// Return validated X-Real-Ip
	static public function get_ip_x_real_ip()
	{
		$headers = self::get_request_headers();
		if(isset($headers['X-Real-Ip'])){
			$tmp = explode(',', trim($headers['X-Real-Ip']));
			$ip  = trim($tmp[0]);
		}
		return isset($ip) && self::ip_validate($ip) ? $ip : null;
	}
	
	// Return validated Cloud Flare
	static public function get_ip_cloud_flare()
	{
		$headers = self::get_request_headers();
		if(isset($headers['Cf_Connecting_Ip'])){
			foreach(self::$cdn_pool['cloud_flare'] as $cidr){
				if($this->ip_mask_match($_SERVER['remote_addr'], $cidr)){
					$ip = $headers['Cf_Connecting_Ip'];
					break;
				}
			}
		}
		return isset($ip) && self::ip_validate($ip) ? $ip : null;
	}
	
	static public function ip_mask_match($ip, $cidr){
		$exploded = explode ('/', $cidr);
		$net = $exploded[0];
		$mask = 4294967295 << (32 - $exploded[1]);
		return (ip2long($ip) & $mask) == (ip2long($net) & $mask);
	}
	
	/*
	*	Validating IPv4, IPv6
	*	param (string) $ip
	*	returns (string) 'v4' || (string) 'v6' || (bool) false
	*/
	static public function ip_validate($ip)
	{
		// IPv4
		if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4))
			return 'v4';	
		// IPv6
		if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6))
			return 'v6';
		// Unknown
		return false;
	}
	
	/* 
	 * If Apache web server is missing then making
	 * Patch for apache_request_headers() 
	 */
	static public function get_request_headers()
	{
		$headers = array();	
		foreach($_SERVER as $key => $val){
			if(preg_match('/\AHTTP_/', $key)){
				$server_key = preg_replace('/\AHTTP_/', '', $key);
				$key_parts = explode('_', $server_key);
				if(count($key_parts) > 0 and strlen($server_key) > 2){
					foreach($key_parts as $part_index => $part){
						$key_parts[$part_index] = function_exists('mb_strtolower') ? mb_strtolower($part) : strtolower($part);
						$key_parts[$part_index][0] = strtoupper($key_parts[$part_index][0]);					
					}
					$server_key = implode('-', $key_parts);
				}
				$headers[$server_key] = $val;
			}
		}
		return $headers;
	}
	
	    
    /**
     * Function gets information about spam active networks 
     *
     * @param string api_key
     * @return JSON/array 
     */
    static public function get_2s_blacklists_db($api_key, $do_check = true)
	{
		$request = array(
			'agent' => APBCT_AGENT,
			'method_name' => '2s_blacklists_db',
			'auth_key' => $api_key,
		);
		
		$result = self::sendRawRequest(self::URL, $request);
		// $result = $do_check ? self::checkRequestResult($result, '2s_blacklists_db') : $result;
		
        return $result;
    }

	/**
	 * Function gets access key automatically
	 *
	 * @param string website admin email
	 * @param string website host
	 * @param string website platform
	 * @return type
	 */
	static public function getAutoKey($email, $host, $platform, $timezone = null, $do_check = true)
	{		
		$request = array(
			'method_name' => 'get_api_key',
			'agent' => APBCT_AGENT,
			'email' => $email,
			'website' => $host,
			'platform' => $platform,
			'timezone' => $timezone,
			'product_name' => 'antispam',
		);
		
		$result = self::sendRawRequest(self::URL, $request);
		// $result = $do_check ? self::checkRequestResult($result, 'get_api_key') : $result;
		
		return $result;
	}
	
	/**
	 * Function gets information about renew notice
	 *
	 * @param string api_key
	 * @return type
	 */
	static public function noticeValidateKey($api_key, $path_to_cms, $do_check = true)
	{
		$request = array(
			'agent' => APBCT_AGENT,
			'method_name' => 'notice_validate_key',
			'auth_key' => $api_key,
			'path_to_cms' => $path_to_cms	
		);
		
		$result = self::sendRawRequest(self::URL, $request);
		$result = $do_check ? self::checkRequestResult($result, 'notice_validate_key') : $result;
		
		return $result;
	}
	
	/**
	 * Function gets information about renew notice
	 *
	 * @param string api_key
	 * @return type
	 */
	static public function noticePaidTill($api_key, $do_check = true)
	{
		$request = array(
			'agent' => APBCT_AGENT,
			'method_name' => 'notice_paid_till',
			'auth_key' => $api_key
		);
		
		$result = self::sendRawRequest(self::URL, $request);
		$result = $do_check ? self::checkRequestResult($result, 'notice_paid_till') : $result;
		
		return $result;
	}

	/**
	 * Function gets spam report
	 *
	 * @param string website host
	 * @param integer report days
	 * @return type
	 */
	static public function getAntispamReport($host, $period = 1)
	{
		$request=Array(
			'agent' => APBCT_AGENT,
			'method_name' => 'get_antispam_report',
			'hostname' => $host,
			'period' => $period
		);
		
		$result = self::sendRawRequest(self::URL, $request);
		// $result = $do_check ? self::checkRequestResult($result, 'get_antispam_report') : $result;
		
		return $result;
	}
	
	/**
	 * Function gets spam statistics
	 *
	 * @param string website host
	 * @param integer report days
	 * @return type
	 */
	static public function getAntispamReportBreif($api_key, $do_check = true)
	{
		
		$request = array(
			'agent' => APBCT_AGENT,
			'method_name' => 'get_antispam_report_breif',
			'auth_key' => $api_key,
		);
		
		$result = self::sendRawRequest(self::URL, $request);
		$result = $do_check ? self::checkRequestResult($result, 'get_antispam_report_breif') : $result;
		
		$tmp = array();
		for( $i = 0; $i < 7; $i++ )
			$tmp[ date( 'Y-m-d', time() - 86400 * 7 + 86400 * $i ) ] = 0;
		
		$result['spam_stat']    = array_merge( $tmp, isset($result['spam_stat']) ? $result['spam_stat'] : array() );
		$result['top5_spam_ip'] = isset($result['top5_spam_ip']) ? $result['top5_spam_ip'] : array();
		
		return $result;		
	}
	
	static public function sendRawRequest($url,$data,$isJSON=false,$timeout=3)
	{	
		
		$result = null;
		if(!$isJSON){
			$data = http_build_query($data);
			$data = str_replace("&amp;", "&", $data);
		}else{
			$data = json_encode($data);
		}
		
		$curl_exec = false;

		if (function_exists('curl_init') && function_exists('json_decode')){
		
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			
			// receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// resolve 'Expect: 100-continue' issue
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
			
			$result = curl_exec($ch);
			
			if($result !== false)
				$curl_exec = true;
			
			curl_close($ch);
		}
		if(!$curl_exec){
			
			$opts = array(
				'http'=>array(
					'method'  => "POST",
					'timeout' => $timeout,
					'content' => $data,
				)
			);
			$context = stream_context_create($opts);
			$result = @file_get_contents($url, 0, $context);
		}
		
		return $result;
	}
	
	/**
	 * Function checks server response
	 *
	 * @param string result
	 * @param string request_method
	 * @return mixed (array || array('error' => true))
	 */
	static public function checkRequestResult($result, $method_name = null)
	{		
		// Errors handling
		
		// Bad connection
		if(empty($result)){
			return array(
				'error' => true,
				'error_string' => 'CONNECTION_ERROR'
			);
		}
		
		// JSON decode errors
		$result = json_decode($result, true);
		if(empty($result)){
			return array(
				'error' => true,
				'error_string' => 'JSON_DECODE_ERROR'
			);
		}
		
		// Server errors
		if($result && (isset($result['error_no']) || isset($result['error_message']))){
			return array(
				'error' => true,
				'error_string' => "SERVER_ERROR NO: {$result['error_no']} MSG: {$result['error_message']}",
				'error_no' => $result['error_no'],
				'error_message' => $result['error_message']
			);
		}
		
		// Pathces for different methods
		
		// mehod_name = notice_validate_key
		if($method_name == 'notice_validate_key' && isset($result['valid'])){
			return $result;
		}
		
		// Other methods
		if(isset($result['data']) && is_array($result['data'])){
			return $result['data'];
		}
	}
	
	/**
	 * Prepares an adds an error to the plugin's data
	 *
	 * @param string type
	 * @param mixed array || string
	 * @returns null
	 */
	static public function addError($type, $error, $set_time = true)
	{	
		global $apbct;
		
		$error_string = is_array($error)
			? $error['error_string']
			: $error;
		
		// Exceptions
		if( ($type == 'send_logs'          && $error_string == 'NO_LOGS_TO_SEND') ||
			($type == 'send_firewall_logs' && $error_string == 'NO_LOGS_TO_SEND')
		)
			return;
		
		if($set_time == true)
			$apbct->data['errors'][$type]['error_time']   = current_time('timestamp');
		$apbct->data['errors'][$type]['error_string'] = $error_string;
		$apbct->save('data');
	}
	
	/**
	 * Deletes an error from the plugin's data
	 *
	 * @param mixed (array of strings || string 'elem1 elem2...' || string 'elem') type
	 * @param delay saving
	 * @returns null
	 */
	static public function deleteError($type, $save_flag = false)
	{
		global $apbct;
		
		$before = empty($apbct->data['errors']) ? 0 : count($apbct->data['errors']);
		
		if(is_string($type))
			$type = explode(' ', $type);
		
		foreach($type as $val){
			if(isset($apbct->data['errors'][$val])){
				unset($apbct->data['errors'][$val]);
			}
		}
		
		$after = empty($apbct->data['errors']) ? 0 : count($apbct->data['errors']);
		// Save if flag is set and there are changes
		if($save_flag && $before != $after)
			$apbct->save('data');
	}
	
	/**
	 * Deletes all errors from the plugin's data
	 *
	 * @param delay saving
	 * @returns null
	 */
	static public function deleteAllErrors($save_flag = false)
	{
		global $apbct;
		
		if(isset($apbct->data['errors']))
			unset($apbct->data['errors']);
		
		if($save_flag)
			$apbct->save('data');
	}
}
