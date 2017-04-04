<?php 
	require_once "Connection.php";
	require_once "Carona.php";

    class CaronaDAO{

		const INSERT_QUERY_IDA = "insert into public.caroneiros (chat_id, user_id, username, travel_hour, route) values (:chat_id, :user_id, :username, :travel_hour, '0'::bit(1))";
		const INSERT_QUERY_VOLTA = "insert into public.caroneiros (chat_id, user_id, username, travel_hour, route) values (:chat_id, :user_id, :username, :travel_hour, '1'::bit(1))";
		
		const LISTA_QUERY_IDA = "select * from public.caroneiros where chat_id = :chat_id and route = '0'::bit(1) ORDER BY travel_hour ASC;";
		const LISTA_QUERY_VOLTA = "select * from public.caroneiros where chat_id = :chat_id and route = '1'::bit(1) ORDER BY travel_hour ASC;";
	
		const REMOVE_QUERY_IDA = "delete from public.caroneiros where chat_id = :chat_id and user_id = :user_id and route = '0'::bit(1)";
		const REMOVE_QUERY_VOLTA = "delete from public.caroneiros where chat_id = :chat_id and user_id = :user_id and route = '1'::bit(1)";
	
		const REMOVE_EXPIRED_QUERY = "delete from Caroneiros where now() - added > interval '1 DAY'";
	
	    
	private $db;
	    
        public function __construct(){
            $this->db = new Database();
        }

		public function getListaIda($chat_id){
			$this->db->query(CaronaDAO::LISTA_QUERY_IDA);
			$this->db->bind(":chat_id", $chat_id);
			
			return $this->montaListaCaronas($this->db->resultSet());
		}
		
		public function getListaVolta($chat_id){
			$this->db->query(CaronaDAO::LISTA_QUERY_VOLTA);
			$this->db->bind(":chat_id", $chat_id);
			
			return $this->montaListaCaronas($this->db->resultSet());
		}
				
		public function adicionarIda($chat_id, $user_id, $username, $travel_hour){
			$travel_hour = $this->acertarStringHora($travel_hour);
			
			$this->db->query(CaronaDAO::INSERT_QUERY_IDA);
			$this->db->bind(":chat_id", $chat_id);
			$this->db->bind(":user_id", $user_id);
			$this->db->bind(":username", $username);
			$this->db->bind(":travel_hour", $travel_hour);
						
			$this->db->execute();
			error_log("Erro: " . $this->db->getError());
		}
		
		public function removerIda($chat_id, $user_id){
			$this->db->query(CaronaDAO::REMOVE_QUERY_IDA);
			$this->db->bind(":chat_id", $chat_id);
			$this->db->bind(":user_id", $user_id);
			
			$this->db->execute();
			error_log("Erro: " . $this->db->getError());
		}
		
		public function adicionarVolta($chat_id, $user_id, $username, $travel_hour){
			$travel_hour = $this->acertarStringHora($travel_hour);
			
			$this->db->query(CaronaDAO::INSERT_QUERY_VOLTA);
			$this->db->bind(":chat_id", $chat_id);
			$this->db->bind(":user_id", $user_id);
			$this->db->bind(":username", $username);
			$this->db->bind(":travel_hour", $travel_hour);
						
			$this->db->execute();
			error_log("Erro: " . $this->db->getError());
		}
		
		public function removerVolta($chat_id, $user_id){
			$this->db->query(CaronaDAO::REMOVE_QUERY_VOLTA);
			$this->db->bind(":chat_id", $chat_id);
			$this->db->bind(":user_id", $user_id);
			
			$this->db->execute();
			error_log("Erro: " . $this->db->getError());
		}
		
	    	public function removerViagensExpiradas(){
 			$this->db->query(CaronaDAO::REMOVE_EXPIRED_QUERY);
 			$this->db->execute();
 			error_log("Erro: " . $this->db->getError());			
 		}
	    
		private function acertarStringHora($travel_hour){
			return $travel_hour .= ":00";
		}
		
		private function montaListaCaronas($resultSet){
			$resultado = array();
			
			foreach ($resultSet as $entrada)
			{
				array_push($resultado, new Carona($entrada));
			}
			
			return $resultado;
		}
    }

    
