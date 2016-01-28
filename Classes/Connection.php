<?php
    include_once "Config.php";
    class Database{

        private $host;
        private $user;
        private $pass;
        private $dbname;
        private $dbh;
        private $error;

        public function __construct(){

            $this->host = Config::getBotConfig("DBHost");
            $this->user = Config::getBotConfig("DBUser");
            $this->pass = Config::getBotConfig("DBPass");
            $this->dbname = Config::getBotConfig("DBName");

            //Set dsn
            $dsn = 'pgsql:host=' . $this->host . ';dbname=' . $this->dbname;

            //define pdo options
            $options = array(
                PDO::ATTR_PERSISTENT => TRUE,
                PDO::ATTR_ERRMODE   => PDO::ERRMODE_EXCEPTION
            );

            //create instance
            try{
                $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            }   
            //gonna catch' em all (errors)
            catch(PDOException $e){
                $this->error = $e->getMessage();
            }
        }

        public function query($query){
            $this->stmt = $this->dbh->prepare($query);
        }

        public function bind($param, $value, $type = null){
            if (is_null($type)) {
                switch (true) {
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;

                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;

                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    
                    default:
                        $type = PDO::PARAM_STR;
                        break;
                }
            }

            $this->stmt->bindValue($param, $value, $type);
        }

        public function execute(){
			try{
                return $this->stmt->execute();
            }   
            catch(PDOException $e){
                $this->error = $e->getMessage();
            }
        }

        public function resultSet(){
            $this->execute();
			try{
                return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
            }   
            catch(PDOException $e){
                $this->error = $e->getMessage();
            }
        }

        public function single(){
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_ASSOC);   
        }

        public function rowCount(){
            return $this->stmt->rowCount();
        }

        public function debugDumbParams(){
            return $this->stmt->debugDumbParams();
        }
		
		public function getError(){
			return $this->error;
		}
		
		public function getTotalTables(){
			$this->query("SELECT table_schema,table_name FROM information_schema.tables");
			$this->execute();
			return $this->rowCount();
		}
    }

    