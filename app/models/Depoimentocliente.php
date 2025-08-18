<?php

class Depoimentocliente extends Model
{
    public function getDepoimentoCliente()
    {
        $sql = "SELECT id_cliente, nome_cliente FROM tbl_cliente ORDER BY nome_cliente ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
