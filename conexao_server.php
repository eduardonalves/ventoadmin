<?php



define('DB_HOST','186.202.152.54');

define('DB_USER','edukate');

define('DB_PASS','MysqlLogOn');

define('DB_NAME','edukate');




class Connection{

	

	

	public function __construct($dbHost,$dbUser,$dbPass,$dbName){

		

		$this->dbHost = $dbHost;

		$this->dbUser = $dbUser;

		$this->dbPass = $dbPass;

		$this->dbName = $dbName;

		

		$this->connect();

		

	}

	

	

	public function connect(){

		

		

		$this->openConnection();

		$this->selectDatabase();

		

		}

		

	public function openConnection(){

		

		$this->connection = mysql_connect($this->dbHost,$this->dbUser,$this->dbPass) or include("includes/error.php");

		

		}	

		

	public function selectDatabase(){

		

		

		$this->selection = mysql_select_db($this->dbName) or die(mysql_error());

		

		}	

		

		

	public function query($query){

		

		$this->result = mysql_query($query) or die(mysql_error());

		return $this->result;

		

		}	

	}



$conexao = new Connection(DB_HOST,DB_USER,DB_PASS,DB_NAME);


?>
