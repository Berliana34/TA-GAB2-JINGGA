<?php
defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH."libraries/Server.php";

class buku extends Server {

    //buat konstruktor
    public function __construct()
        {
                parent::__construct();
                 //panggil model "Mbuku"
                $this->load->model("Mbuku","model",TRUE);
        }

	//buat fungsi "GET"
    function service_get()
    {
       
        
        //panggil fungsi "get_data"
       $hasil = $this->model->get_data();

        $this->response(array("buku" =>
        $hasil),200);

    }

    //buat fungsi "POST"
    function service_post()
    {
       
        //ambil parameter token data yang akan diisi
        $data = array(
            "id" => $this->post("id"),
            "judul" => $this->post("judul"),
            "jenis" => $this->post("jenis"),
            "token" => base64_encode($this->post("id")),
        );
        // panggil method "save data"
        $hasil = $this->model->save_data($data["id"],
        $data["judul"],$data["jenis"],$data["token"]);
        // jika hasil = 0
        if($hasil == 0 )
        {
            $this->response(array("status" =>"Data Buku Berhasil Disimpan"),200);
        }
        // jika hasil != 0
        else
        {
            $this->response(array("status" =>"Data Buku Gagal Disimpan !"),200);
        }

 
    }
    //buat fungsi "PUT"
    function service_put()
    {
     //panggil model "Mbuku"
     $this->load->model("Mbuku","model",true);
     //ambil parameter token data yang akan diisi
     $data = array(
         "id" => $this->put("id"),
         "judul" => $this->put("judul"),
         "jenis" => $this->put("jenis"),
         "token" => base64_encode($this->put("token")),
     );   

      // panggil method "update_data"
      $hasil = $this->model->update_data($data
      ["id"],$data["judul"],$data["jenis"],$data["token"]);

      //jika hasil == 0
        if($hasil == 0 )
        {
            $this->response(array("status" =>"Data Buku Berhasil Diubah"),200);
        }
        // jika hasil != 0
        else
        {
            $this->response(array("status" =>"Data Buku Gagal Diubah !"),200);
        }
    }
    //buat fungsi "DELETE"
    function service_delete()
    {
        // panggil model "Mbuku"
        $this->load->model("Mbuku","model",TRUE);
        //ambil parameter token "(id)"
        $token = $this->delete("id");
        //panggil fungsi "delete_data"
        $hasil = $this->model->delete_data
        (base64_encode($token));
        if($hasil == 1)
        {
            $this->response(array("status" =>"Data buku Berhasil Dihapus"),200);
        }
        // jika proses delete gagal
        else
        {
            $this->response(array("status" => "Data
            buku Gagal Dihapus !"),200);
        }

    }
}
