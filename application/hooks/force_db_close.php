<?php
// Name of Class as mentioned in $hook['post_controller]
class Force_db_close {
	function __construct() {
	       // Anything except exit() :P
	    }
	// Name of function same as mentioned in Hooks Config
	    function close_db() {
	    	// $this->db->close();
	    	$this->CI = &get_instance();
	    	$this->CI->db->close();
	    }
}