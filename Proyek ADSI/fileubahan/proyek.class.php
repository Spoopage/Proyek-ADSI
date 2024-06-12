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

    public function insert_products($data) {
        $query = "INSERT INTO products (name, id, stock) VALUES (:name, :id, :stock)";
        $statement = $this->db->prepare($query);

        $statement->bindParam(':name', $data['name']);
        $statement->bindParam(':id', $data['id']);
        $statement->bindParam(':stock', $data['stock']);

        return $statement->execute();
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

    public function insert_transaksi($data)
    {
        $insert_data = "INSERT INTO transaksi (id, customer_id, customer_name, total, transaction_date) VALUES (?, ?, ?, ?, ?)";
        $insert_data = $this->db->prepare($insert_data);
        $insert_data->execute($data);
        return $insert_data;

        // $insert_data = "INSERT INTO transaksi (customer_name, total, transaction_date) VALUES (?, ?, ?)";
        // $insert_data = $this->db->prepare($insert_data);
        // $insert_data->execute($data);
        // return $insert_data;
    }

    public function get_transaksi()
    {
        $tampil_data = "SELECT * FROM transaksi ORDER BY transaction_date DESC";
        $tampil_data = $this->db->prepare($tampil_data);
        $tampil_data->execute();
        return $tampil_data;
    }

    public function get_transaksi_by_id($id_transaksi) 
    {
        $query = "SELECT * FROM transaksi WHERE id='$id_transaksi'";
        $query = $this->db->prepare($query);
        $query->execute();
        return $query;
    }

    public function get_pelanggan_by_id($id_pelanggan)
    {
        $query = "SELECT * FROM pelanggan WHERE id='$id_pelanggan'";
        $query = $this->db->prepare($query);
        $query->execute();
        return $query;
    }

    public function get_pelanggan_by_name($nama_pelanggan) 
    {
        $query = "SELECT * FROM pelanggan WHERE nama_pelanggan='$nama_pelanggan'";
        $query = $this->db->prepare($query);
        $query->execute();
        return $query;
    }

}

