<?php
//use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//require APPPATH . 'libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class V1 extends REST_Controller
{
    public function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function users_get()
    {
        // Users from a data store e.g. database

        // $users = [
        //     ['id' => 1, 'name' => 'John', 'email' => 'john@example.com', 'fact' => 'Loves coding'],
        //     ['id' => 2, 'name' => 'Jim', 'email' => 'jim@example.com', 'fact' => 'Developed on CodeIgniter'],
        //     ['id' => 3, 'name' => 'Jane', 'email' => 'jane@example.com', 'fact' => 'Lives in the USA', ['hobbies' => ['guitar', 'cycling']]],
        // ];

        $users = $this->Manufriend_model->mm_show_user();

        $id = $this->get('id');

        // If the id parameter doesn't exist return all the users

        if ($id === null) {
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($users) {
                // Set the response and exit
                $this->response($users, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status' => false,
                    'message' => 'No users were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }

        // Find and return a single record for a particular user.

        $id = (int) $id;

        // Validate the id.
        if ($id <= 0) {
            // Invalid id, set the response and exit.
            $this->response(null, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.

        $user = null;

        if (!empty($users)) {
            foreach ($users as $key => $value) {
                if (isset($value['id']) && $value['id'] === $id) {
                    $user = $value;
                }
            }
        }

        if (!empty($user)) {
            $this->set_response($user, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response([
                'status' => false,
                'message' => 'User could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }



    // Get collection

    public function done_get()
    {
        $pass["data"]=$this->Manufriend_model->mm_show_done();

        if ($pass["data"]!=null) {
            $this->set_response($pass, REST_Controller::HTTP_OK);
        } else {
            $this->set_response($pass, REST_Controller::HTTP_NOT_FOUND);
        }
    }


    public function shopping_get()
    {
        $pass["data"]=$this->Manufriend_model->mm_show_shopping();
        if ($pass["data"]!=null) {
            $this->set_response($pass, REST_Controller::HTTP_OK);
        } else {
            $this->set_response($pass, REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function chitchat_get()
    {
        $pass["data"]=$this->Manufriend_model->mm_show_chit_chat();
        if ($pass["data"]!=null) {
            $this->set_response($pass, REST_Controller::HTTP_OK);
        } else {
            $this->set_response($pass, REST_Controller::HTTP_NOT_FOUND);
        }
    }


    public function sport_get()
    {
        $pass["data"]=$this->Manufriend_model->mm_show_sport();
        if ($pass["data"]!=null) {
            $this->set_response($pass, REST_Controller::HTTP_OK);
        } else {
            $this->set_response($pass, REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function attendingparty_get()
    {
        $pass["data"]=$this->Manufriend_model->mm_show_attending_party();
        if ($pass["data"]!=null) {
            $this->set_response($pass, REST_Controller::HTTP_OK);
        } else {
            $this->set_response($pass, REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function all_request_get()
    {
        $pass["data"]=$this->Manufriend_model->mm_show_request();
        if ($pass["data"]!=null) {
            $this->set_response($pass, REST_Controller::HTTP_OK);
        } else {
            $this->set_response($pass, REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function pricetag_get($id)
    {
        $pass["data"]=$this->Manufriend_model->mm_show_price_service($id);

        if ($pass["data"]!=null) {
            $this->set_response($pass, REST_Controller::HTTP_OK);
        } else {
            $this->set_response($pass, REST_Controller::HTTP_NOT_FOUND);
        }
    }




    //======================================================================
    public function users_post()
    {
        // $this->some_model->update_user( ... );
        $message = [
            'id' => 100, // Automatically generated by the model
            'name' => $this->post('name'),
            'email' => $this->post('email'),
            'message' => 'Added a resource'
        ];

        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function auth_post()
    {
        $is_exist =    $this->Manufriend_model->mm_cek_user($this->post("email"), $this->post("password"));
        $user_profile = $this->Manufriend_model->mm_data_user($this->post("email"), $this->post("password"));
        $rolesyou="";
        if ($is_exist>0) {
            if ($user_profile->role_user==3) {
                $rolesyou="Agen";
            } elseif ($user_profile->role_user==2) {
                $rolesyou="Admin";
            } elseif ($user_profile->role_user==1) {
                $rolesyou="User";
            }

            $message = [

            'id_user' => $user_profile->id_user,
            'name' => $user_profile->nama_user,
            'email' =>$user_profile->email_user,
            'message' => 'Berhasil Login',
            'alamat' => $user_profile->alamat_user,
            'rolesyou'=> $rolesyou
        ];

            $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        } else {
            $message = [

              'message' => 'Gagal Login',
         ];

            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED); // CREATED (201) being the HTTP response code
        }
    }

    public function register_post()
    {
        $dataParsing = array(
       "id_user"=>"",

       //andri diganti dengan $this->input->post('namauser');
       "nama_user"=>$this->post('nama_user'),
       "email_user"=>$this->post('email_user'),
       "password_user"=>$this->post('password_user'),
       "telepon_user"=>$this->post('telepon_user'),
       "alamat_user"=>$this->post('alamat_user'),
       "gender_user"=>$this->post('gender_user'),
       "ttl_user"=> date('y-m-d'),
       "role_user"=> 2
     );

        $cekemail = $this->Manufriend_model->mm_cek_email($dataParsing['email_user']);


        if ($dataParsing!=null && $cekemail<1) {
            $data["message"] = "Data Anda berhasil didaftarkan";
            $this->Manufriend_model->mm_insert_new_user($dataParsing);
            $this->set_response($data, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        } elseif ($cekemail>0) {
            $data["message"] = "Data Anda sudah pernah didaftarkan";
            $this->set_response($data, REST_Controller::HTTP_UNAUTHORIZED); // CREATED (201) being the HTTP response code
        } else {
            $data["message"] = "Koneksi gagal";
            $this->set_response($data, REST_Controller::HTTP_UNAUTHORIZED); // CREATED (201) being the HTTP response code
        }
    }

    public function transaction_post()
    {
        $dataParsing = array(
          "id_user"=>"",

          "id_user"=>$this->post('id_user'),
          "id_service"=>$this->post('id_service'),
          "id_status"=>$this->post('id_status'),
          "tanggal_order"=>$this->post('tanggal_order'),
          "pukul_trx"=>$this->post('pukul_trx'),
          "durasi"=>$this->post('durasi'),
          "total_harga"=>$this->post('total_harga'),
          "notes"=>$this->post('notes')
    );

        $cekmasuk = $this->Manufriend_model->mm_insert_transaction($dataParsing);


        $data["message"] = "Berhasil melakukan transaksi";
        $this->set_response($data, REST_Controller::HTTP_OK);
    }

    public function version_get()
    {
        $data = $this->Manufriend_model->mm_show_current_version();
        if ($data!=""|| $data!=null) {

          //  $data["message"] = "Versi sekarang";
            $this->set_response($data, REST_Controller::HTTP_OK); // Oke
        } else {
            $this->set_response($data, REST_Controller::HTTP_UNAUTHORIZED); // Error
        }
    }
}
