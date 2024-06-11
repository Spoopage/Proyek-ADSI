<?php

class Products
{
    private $db;

    public function __construct($db = '')
    {
        $this->setConnect($db);
    }

    public function setConnect($db)
    {
        $this->db = $db;
    }

    public function insert_products($data)
    {
        $insert_data = "INSERT INTO products SET nama_product = ?, deskripsi_product = ?, harga = ?, img_src = ?";
        $insert_data = $this->db->prepare($insert_data);
        $insert_data->execute($data);

        return $insert_data;
    }

    public function insert_cart($data)
    {
        $insert_data = "INSERT INTO cart SET product_id = ?, nama_product = ?, harga = ?, img_src = ?";
        $insert_data = $this->db->prepare($insert_data);
        $insert_data->execute($data);

        return $insert_data;
    }

    public function insert_admin($data)
    {
        $insert_data = "INSERT INTO admins SET username = ?, password = ?, nama_admin = ?, status_aktif = ?";
        $insert_data = $this->db->prepare($insert_data);
        $insert_data->execute($data);
        return $insert_data;
    }

    public function tampil_products()
    {
        $tampil_data = "SELECT * FROM products ORDER BY id ASC";
        $tampil_data = $this->db->prepare($tampil_data);
        $tampil_data->execute();

        return $tampil_data;
    }

    public function tampil_cart()
    {
        $tampil_data = "SELECT * FROM cart ORDER BY id ASC";
        $tampil_data = $this->db->prepare($tampil_data);
        $tampil_data->execute();

        return $tampil_data;
    }

    public function get_products_index($id)
    {
        $tampil_data = "SELECT * FROM products WHERE id = " . $id;
        $tampil_data = $this->db->prepare($tampil_data);
        $tampil_data->execute();

        return $tampil_data;
    }

    public function get_cart_index($id)
    {
        $tampil_data = "SELECT * FROM cart WHERE id = " . $id;
        $tampil_data = $this->db->prepare($tampil_data);
        $tampil_data->execute();

        return $tampil_data;
    }

    public function tampil_data_admin()
    {
        $tampil_data = "SELECT * FROM admins";
        $tampil_data = $this->db->prepare($tampil_data);
        $tampil_data->execute();
        return $tampil_data;
    }

    public function update_status_admin($data) {
        $insert_data = "UPDATE admins SET status_aktif = ? WHERE id = ? ";
        $insert_data = $this->db->prepare($insert_data);
        $insert_data->execute($data);
        return $insert_data;
    }

    public function update_jumlah_cart($data) {
        $insert_data = "UPDATE cart SET jumlah = ? WHERE id = ? ";
        $insert_data = $this->db->prepare($insert_data);
        $insert_data->execute($data);
        return $insert_data;
    }

    public function delete_products($id)
    {
        $delete_data = "DELETE FROM products WHERE id = ?";
        $delete_data = $this->db->prepare($delete_data);
        $delete_data->execute([$id]);

        return $delete_data;
    }

    public function delete_cart($id)
    {
        $delete_data = "DELETE FROM cart WHERE id = ?";
        $delete_data = $this->db->prepare($delete_data);
        $delete_data->execute([$id]);

        return $delete_data;
    }

    public function get_sum_cart(){
        $get_sum = "SELECT SUM(jumlah * harga) from cart";
        $get_sum = $this->db->prepare($get_sum);
        $get_sum->execute();
        return $get_sum;
    }
}
