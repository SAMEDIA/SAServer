<?php
class SongAboutDB extends MySQLi {
    protected static $instance;

    private function __construct($db_name = "") {
        // turn of error reporting
        //mysqli_report(MYSQLI_REPORT_OFF);
		
	$conn = mysql_connect('localhost', 'songabou_db001', 'yN3)AH?GaQT%');
    //$conn = mysql_connect('localhost', 'root', 'mysql');
	if (!$conn) {
    	die('Could not connect: ' . mysql_error());
	}
	mysql_select_db($db_name, $conn);
	
	
	$db = (object) "";
	$db->host = 'localhost';
	$db->user = 'songabou_db001';
	$db->pass = 'yN3)AH?GaQT%';
	$db->schema = $db_name;
	$db->port = '3306';
	/*
	$db = (object) "";
	$db->host = 'localhost';
	$db->user = 'root';
	$db->pass = 'mysql';
	$db->schema = $db_name;
<<<<<<< HEAD
	$db->port = '3306';*/

=======
	$db->port = '3306';
	*/
>>>>>>> FETCH_HEAD
	// connect to the database
	@parent::__construct($host, $db->user, $db->pass, $db->schema, $port, false);

	// check if a connection is established
	if (mysqli_connect_errno()) {
		throw new Exception(mysqli_connect_error(), mysqli_connect_errno()); 
	}
	
	// set charset
	@parent::set_charset('utf8');
		
    }

    public static function getInstance($db_name = "") {
        if (!self::$instance[$db_name]) {
            self::$instance[$db_name] = new self($db_name);
        }
        return self::$instance[$db_name];
    }
	
	public function escape($string) {
		return $this->real_escape_string($string);
	}

    public function query($query) {
        if (!$this->real_query($query)) {
            throw new exception( $this->error, $this->errno );
        }
        $result = new mysqli_result($this);
        return $result;
    }

    /*public function prepare($query) {
        $stmt = new mysqli_stmt($this, $query);
        return $stmt;
    }
	
	public static function isSetup() {
		try {
			$db = self::getInstance();
			$rs = $db->query("SHOW tables LIKE 'site'");
			return ($rs->num_rows > 0) ? true : false;
		} catch (Exception $e) {
			return false;
		}
	}*/
	
	public static function getRow($sql, $db_name = "", $return_type = "object") {
		$db = self::getInstance($db_name);
		if (strtoupper(substr($sql,-7)) != "LIMIT 1") $sql .= " LIMIT 1";
		$rs = $db->query($sql);
		if ($rs->num_rows > 0) {
			switch(strtolower($return_type)) {
				case "array":
					$row = $rs->fetch_array();
					break;
				case "assoc":
					$row = $rs->fetch_assoc();
					break;
				case "row":
					$row = $rs->fetch_row();
					break;
				default:
					$row = $rs->fetch_object();
			}
			$rs->close();
			return $row;
		} else return false;
	}
	
	function cleanFormat($theString) {
		$cleanString = mysql_real_escape_string($theString);
		return $cleanString;
	}	
}