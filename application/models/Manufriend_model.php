

		<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

		class Manufriend_model extends CI_model {


				public function __construct() {
					 parent::__construct();


					//  header("Access-Control-Allow-Origin: *");
					//  header("Content-Type: application/json; charset=UTF-8");
					//  header("Access-Control-Allow-Methods: POST");
					//  header("Access-Control-Allow-Methods: GET");
					//  header("Access-Control-Max-Age: 3600");
					//  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


				}

			public function mm_insert_user($data){
				$this->db->insert('manufriend_user',$data);
			}
			public function mm_delete_user($data){
				$this->db->where($data);
				$this->db->delete('manufriend_user',$data);
			}
			public function mm_update_user($data){
				$this->db->where($data);
				$this->db->update('manufriend_user',$data);
			}

		    //=====================================================
		    //
		    //

		    public function mm_cek_user($email_user, $password){
		    	$this->db->where("email_user",trim($email_user));
		    	$this->db->where("password_user",trim($password));
		    	$query=$this->db->get("manufriend_user");

		    	return $query->num_rows();
		    }

		    public function mm_cek_email($email_user){
		        $this->db->where("email_user",trim($email_user));
		        $query=$this->db->get("manufriend_user");

		        return $query->num_rows();
		    }

		    public function mm_data_user($email_user, $password){
		    	$this->db->where("email_user",trim($email_user));
		    	$this->db->where("password_user",trim($password));
		    	$query=$this->db->get("manufriend_user");

		    	return $query->row();
		    }

		    public function mm_insert_new_user($data){
		        $this->db->insert("manufriend_user",$data);
		    }

		    public function mm_show_transaction(){


						// $query = $this->db->query("Select * from ");
		        $this->db->select('*');
		        $this->db->from('manufriend_user');
		        $this->db->join('manufriend_transaction', 'manufriend_user.id_user = manufriend_transaction.id_user');
		        $this->db->join('manufriend_service', 'manufriend_service.id_service = manufriend_transaction.id_service');
		        $this->db->join('manufriend_status', 'manufriend_status.id_status = manufriend_transaction.id_status');

		        $q = $this->db->get();
		        return $q->result();
		    }

		    public function mm_update_transaction_to_ongoing($id_trx){
		        $data = array(
		            'id_status' => 2,
		        );
		        $this->db->where('id_trx', $id_trx);
		        $this->db->update('manufriend_transaction', $data);
		    }

		    public function mm_log_transaction($data=array()){
		        $this->db->insert("manufriend_log_trx", $data);
		    }

		    public function mm_show_user(){
		        $this->db->select('*');
		        $this->db->from('manufriend_user');
		        // $this->db->where('role_user',2);

		        $q = $this->db->get();
		        return $q->result();
		    }

		    public function mm_show_request(){
		        $this->db->select('*');
		        $this->db->from('manufriend_user');
		        $this->db->join('manufriend_transaction', 'manufriend_user.id_user = manufriend_transaction.id_user');
		        $this->db->join('manufriend_service', 'manufriend_service.id_service = manufriend_transaction.id_service');
		        $this->db->where('id_status',1);
		        // $this->db->join('manufriend_status', 'manufriend_status.id_status = manufriend_transaction.id_status');

		        $q = $this->db->get();
		        return $q->result();
		    }

		    public function mm_show_ongoing(){
		        $this->db->select('*');
		        $this->db->from('manufriend_user');
		        $this->db->join('manufriend_transaction', 'manufriend_user.id_user = manufriend_transaction.id_user');
		        $this->db->join('manufriend_service', 'manufriend_service.id_service = manufriend_transaction.id_service');
		        // $this->db->join('manufriend_status', 'manufriend_status.id_status = manufriend_transaction.id_status');
		        $this->db->where('id_status',2);

		        $q = $this->db->get();
		        return $q->result();
		    }

		    public function mm_show_done(){
		        $this->db->select('*');
		        $this->db->from('manufriend_user');
		        $this->db->join('manufriend_transaction', 'manufriend_user.id_user = manufriend_transaction.id_user');
		        $this->db->join('manufriend_service', 'manufriend_service.id_service = manufriend_transaction.id_service');
		        // $this->db->join('manufriend_status', 'manufriend_status.id_status = manufriend_transaction.id_status');
		        $this->db->where('id_status',3);

		        $q = $this->db->get();
		        return $q->result();
		    }

		    public function mm_show_hang_out(){
		        $this->db->select('*');
		        $this->db->from('manufriend_user');
		        $this->db->join('manufriend_transaction', 'manufriend_user.id_user = manufriend_transaction.id_user');
		        // $this->db->join('manufriend_service', 'manufriend_service.id_service = manufriend_transaction.id_service');
		        $this->db->join('manufriend_status', 'manufriend_status.id_status = manufriend_transaction.id_status');
		        $this->db->where('id_service',1);

		        $q = $this->db->get();
		        return $q->result();
		    }

		    public function mm_show_shopping(){
		        $this->db->select('*');
		        $this->db->from('manufriend_user');
		        $this->db->join('manufriend_transaction', 'manufriend_user.id_user = manufriend_transaction.id_user');
		        // $this->db->join('manufriend_service', 'manufriend_service.id_service = manufriend_transaction.id_service');
		        $this->db->join('manufriend_status', 'manufriend_status.id_status = manufriend_transaction.id_status');
		        $this->db->where('id_service',2);

		        $q = $this->db->get();
		        return $q->result();
		    }

		    public function mm_show_chit_chat(){
		        $this->db->select('*');
		        $this->db->from('manufriend_user');
		        $this->db->join('manufriend_transaction', 'manufriend_user.id_user = manufriend_transaction.id_user');
		        // $this->db->join('manufriend_service', 'manufriend_service.id_service = manufriend_transaction.id_service');
		        $this->db->join('manufriend_status', 'manufriend_status.id_status = manufriend_transaction.id_status');
		        $this->db->where('id_service',3);

		        $q = $this->db->get();
		        return $q->result();
		    }

		    public function mm_show_sport(){
		        $this->db->select('*');
		        $this->db->from('manufriend_user');
		        $this->db->join('manufriend_transaction', 'manufriend_user.id_user = manufriend_transaction.id_user');
		        // $this->db->join('manufriend_service', 'manufriend_service.id_service = manufriend_transaction.id_service');
		        $this->db->join('manufriend_status', 'manufriend_status.id_status = manufriend_transaction.id_status');
		        $this->db->where('id_service',4);

		        $q = $this->db->get();
		        return $q->result();
		    }

		    public function mm_show_attending_party(){
		        $this->db->select('*');
		        $this->db->from('manufriend_user');
		        $this->db->join('manufriend_transaction', 'manufriend_user.id_user = manufriend_transaction.id_user');
		        // $this->db->join('manufriend_service', 'manufriend_service.id_service = manufriend_transaction.id_service');
		        $this->db->join('manufriend_status', 'manufriend_status.id_status = manufriend_transaction.id_status');
		        $this->db->where('id_service',5);

		        $q = $this->db->get();
		        return $q->result();
		    }

				public function mm_show_price_service($idService){

						$this->db->where("id_service",$idService);
						$q =  $this->db->get("manufriend_service");
						return $q->row();
				}

				public function mm_show_current_version(){

					$this->db->where("status",1);
					$q =  $this->db->get("manufriend_version");
					return $q->row();
				}


		}
