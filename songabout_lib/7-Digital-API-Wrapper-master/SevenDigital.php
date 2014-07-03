<?php
/**
* 7Digital class
*
* 
*
* @copyright  2012 Nick Holdren
* @license    http://www.zend.com/license/3_0.txt   PHP License 3.0
* @version    Release: 1.0
* @link       
* @since      Class available since Release 1.0
*/ 
class SevenDigital{
	
	//7Digital API URL
	static $api_url = 'http://api.7digital.com/1.2/';
	
	//API consumer key	
	static $oauth_consumer_key = '7dteruqxmwun';
	
	/**
	* Constructor for the 7Digital class
	*
	* @throws Some_Exception_Class If something interesting cannot happen 
	*/ 
	public function __construct(){
		
	}
	
	/**
	* Constructor for the 7Digital class
	*
	* @throws Some_Exception_Class If something interesting cannot happen 
	*/ 
	public function request($object, $item, $payload){
		
		$fields_string = '';
		
		foreach($payload as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		$fields_string = rtrim($fields_string,'&');
		
		//Return the response
		return file_get_contents(self::$api_url.$object.'/'.$item.'?'.$fields_string.'&oauth_consumer_key='.self::$oauth_consumer_key);
		
		
	}
	
	/**
	* Constructor for the 7Digital class
	*
	* @throws Some_Exception_Class If something interesting cannot happen 
	*/ 
	public function __destruct(){
		
	}
}