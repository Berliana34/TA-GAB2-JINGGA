<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mbuku extends CI_Model {

	// buat method untuk tampil data
    function get_data()
    {
        //mengambil hanya id
        //$this->db->select("id")

        $this->db->select("id AS id_buku,
        id AS id_buku,
        judul AS judul_buku,
        jenis AS jenis_buku
        ");

        $this->db->from("tb_buku");
        $this->db->order_by("id","ASC");

        $query = $this->db->get()->result();
        return $query;

    }

	   // function get_data($username)
    // {
    //     $this->db->select("username,key");
    //     $this->db->from("tb_auth");
    //     $this->db->where("username = '$username'");
    //     $query = $this->db->get()->result();

    //     return $query;
    // }
	
    //buat fungsi untuk hapus data
    function delete_data($token)
    {
        // cek apakah id ada/tidak
        $this->db->select("id");
        $this->db->from("tb_buku");
        $this->db->where("TO_BASE64(id) = '$token'");
        //eksekusi query
        $query = $this->db->get()->result();
        //jika id ditemukan
        if(count($query) == 1)
        {
            // hapus data buku
            $this->db->where("TO_BASE64(id) = '$token'");
            $this->db->delete("tb_buku");
            // kirim nilai hasil = 1
            $hasil = 1;
        }
        //jika id tidak ditemukan 
        else
        {   
            //kirim nilai hasil = 0
            $hasil = 0;
        }
        // kirim variabel hasil ke "controller" buku
        return $hasil;
    }
    
    // buat fungsi untuk simpan data
    function save_data($id,$judul,$jenis,$token)
    {
       // cek apakah id ada/tidak
       $this->db->select("id");
       $this->db->from("tb_buku");
       $this->db->where("TO_BASE64(id) = '$token'");
       //eksekusi query
       $query = $this->db->get()->result();
       //jika id ditemukan
       if(count($query) == 0)
       {
         // isi nilai untuk masing2 field
         $data = array(
            "id" => $id,
            "judul" => $judul,
            "jenis" => $jenis,
         );
         // simpan data
         $this->db->insert("tb_buku",$data);
         $hasil= 0;

       }
      // jika id ditemukan
      else
      {
        $hasil = 1;
      }
      return $hasil;
    }

    //FUNGSI UNTUK UBAH DATA
    function update_data($id,$judul,$jenis,$token)
    {
       // cek apakah id ada/tidak
       $this->db->select("id");
       $this->db->from("tb_mahasiswa");
       //$this->db->where("id = '$id'");
       $this->db->where("TO_BASE64(id) !='$token' AND id = '$id' ");
       //eksekusi query
       $query = $this->db->get()->result();
       //jika id ditemukan
       if(count($query) == 0)
       {
          // isi nilai untuk masing2 field
          $data = array(
            "id" => $id,
            "judul" => $judul,
            "jenis" => $jenis,
         );

          // ubah data mahasiswa
          $this->db->where("TO_BASE64(id) = '$token'");
          $this->db->update("tb_mahasiswa",$data);
          // kirim nilai hasil = 0
          $hasil = 0;
       }
       else
       {
         $hasil = 1;
       }
       return $hasil;
    }

}

