<?php 

    class Carona{

        private $chat_id;
        private $user_id;
        private $username;
        private $travel_hour;
        private $route;
        private $location;

        public function __construct($data){
            $this->chat_id = $data["chat_id"];
			$this->user_id = $data["user_id"];
			$this->username = $data["username"];
			$this->travel_hour = $data["travel_hour"];
            $this->route = $data["route"];
            $this->location = $data["location"];
        }
		
		public function __toString(){
			if(!empty($this->location)) {
			    return substr($this->travel_hour, 0, -3) . " - @" . $this->username . " (" .$this->location . ")";
            } else {
			    return substr($this->travel_hour, 0, -3) . " - @" . $this->username;
            }
		}
		
		public function ehIda(){
			return $this->route == 0;
		}
    }

    