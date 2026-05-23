<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_model extends CI_Model {

    public function dataAdmin() {
        $query = "SELECT * FROM m_pengelola a JOIN m_role b ON a.role_id=b.role_id WHERE a.is_hapus='n' AND a.is_hide='0'";
        return $this->db->query($query)->result_array();
    }

    public function tambahAdmin() {
        $data = [
            'role_id'       => $this->input->post('role_id'),
            'nama_lengkap'  => $this->input->post('nama'),
            'username'      => $this->input->post('name'),
            'password'      => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'is_active'     => 1,
            'created_at'    => date('Y-m-d H:i:s')
        ];
        $this->db->insert('m_pengelola', $data);
    }

    public function editAdmin($primary_id,$passwordlama,$nb) {
        $pass = $this->input->post('password');
        $uname = $this->input->post('name');
        if ($pass=='') {
            $passy = $passwordlama;
        }else{
            $passy = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        }

        if ($nb=='prosesi') {
            $this->db->set([
                'nama_lengkap'  => $this->input->post('nama'),
                'username'      => $uname,
                'password'      => $passy
            ]);
        }else{
            $this->db->set([
                'role_id'       => $this->input->post('role_id'),
                'nama_lengkap'  => $this->input->post('nama'),
                'username'      => $uname,
                'is_active'     => $this->input->post('is_active'),
                'password'      => $passy
            ]);            
        }

        $this->db->where('pengelola_id', $primary_id);
        $this->db->update('m_pengelola');
    }

    public function dataUser() {
        $query = "SELECT * FROM m_customer WHERE is_active!='0' ORDER BY cust_nama ASC";
        return $this->db->query($query)->result_array();
    }


}
