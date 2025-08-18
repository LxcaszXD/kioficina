<?php

class Estado extends Model{
public function getTodosEstados(){

    $sql = "SELECT * FROM tbl_estado ORDER BY nome_uf ASC";
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}