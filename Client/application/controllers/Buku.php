<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku extends CI_Controller 
{

	public function index()
	{
        $data['tampil'] = json_decode($this->client->simple_get(APIBUKU));

        // foreach($data["tampil"] -> buku as $result)
        // {
        // echo $result->id_buku."<br>";
        //}
        
        $this->load->view('vw_buku',$data);
	}

    function setDelete()
    {
       //buat variabel json
       $json = file_get_contents("php://input");
       $hasil = json_decode($json);

       $delete = json_decode($this->client->simple_delete(APIBUKU, array("id" => $hasil->id)));



       // isi nilai err
       // $err = 0;

       // kirim hasil ke "vw_buku"
       echo json_encode(array("statusnya" => $delete->status));
   }

   function addBuku()
   {
       $this->load->view('en_buku');
   }

   // buat fungsi untuk simpan data buku
   function setSave()
   {
       // baca nilai dari fetch
       $data = array(
           "id" => $this->input->post("id"),
           "judul" => $this->input->post("judul"),
           "jenis" => $this->input->post("jenis"),
       );

       $save = json_decode(
           $this->client->simple_post(APIBUKU, $data)
       );

       // kirim hasil ke "vw_buku"
       echo json_encode(array("statusnya" => $save->status));
   }
}
  