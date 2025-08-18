<?php

class Fornecedor extends Model
{

    public function getListarFornecedor()
    {
        // Método para listar todos os fornecedores ativos por ordem alfabética
        $sql = "SELECT f.* FROM tbl_fornecedor f
                WHERE f.status_fornecedor = 'Ativo' 
                ORDER BY f.nome_fornecedor";
    
        $stmt = $this->db->query($sql); // Prepara e executa
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para adicionar fornecedor
    public function addFornecedor($dados)
    {
        $sql = "INSERT INTO tbl_fornecedor (
            nome_fornecedor,
            tipo_fornecedor,
            cpf_cnpj_fornecedor,
            data_cad_fornecedor,
            email_fornecedor,
            site_fornecedor,
            telefone_fornecedor,
            endereco_fornecedor,
            bairro_fornecedor,
            cidade_fornecedor,
            id_uf,
            status_fornecedor
        ) VALUES (
            :nome_fornecedor,
            :tipo_fornecedor,
            :cpf_cnpj_fornecedor,
            :data_cad_fornecedor,
            :email_fornecedor,
            :site_fornecedor,
            :telefone_fornecedor,
            :endereco_fornecedor,
            :bairro_fornecedor,
            :cidade_fornecedor,
            :id_uf,
            :status_fornecedor
        );";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':nome_fornecedor', $dados['nome_fornecedor']);
        $stmt->bindValue(':tipo_fornecedor', $dados['tipo_fornecedor']);
        $stmt->bindValue(':cpf_cnpj_fornecedor', $dados['cpf_cnpj_fornecedor']);
        $stmt->bindValue(':data_cad_fornecedor', $dados['data_cad_fornecedor']);
        $stmt->bindValue(':email_fornecedor', $dados['email_fornecedor']);
        $stmt->bindValue(':site_fornecedor', $dados['site_fornecedor']);
        $stmt->bindValue(':telefone_fornecedor', $dados['telefone_fornecedor']);
        $stmt->bindValue(':endereco_fornecedor', $dados['endereco_fornecedor']);
        $stmt->bindValue(':bairro_fornecedor', $dados['bairro_fornecedor']);
        $stmt->bindValue(':cidade_fornecedor', $dados['cidade_fornecedor']);
        $stmt->bindValue(':id_uf', $dados['id_uf']);
        $stmt->bindValue(':status_fornecedor', $dados['status_fornecedor']);

        $stmt->execute();
        return $this->db->lastInsertId();
    }

    // Método para atualizar fornecedor
    public function atualizarFornecedor($id, $dados)
    {
        $sql = "UPDATE tbl_fornecedor SET
        nome_fornecedor = :nome_fornecedor,
        tipo_fornecedor = :tipo_fornecedor,
        cpf_cnpj_fornecedor = :cpf_cnpj_fornecedor,
        data_cad_fornecedor = :data_cad_fornecedor,
        email_fornecedor = :email_fornecedor,
        site_fornecedor = :site_fornecedor,
        telefone_fornecedor = :telefone_fornecedor,
        endereco_fornecedor = :endereco_fornecedor,
        bairro_fornecedor = :bairro_fornecedor,
        cidade_fornecedor = :cidade_fornecedor,
        id_uf = :id_uf,
        status_fornecedor = :status_fornecedor
     WHERE id_fornecedor = :id_fornecedor";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':nome_fornecedor', $dados['nome_fornecedor']);
        $stmt->bindValue(':tipo_fornecedor', $dados['tipo_fornecedor']);
        $stmt->bindValue(':cpf_cnpj_fornecedor', $dados['cpf_cnpj_fornecedor']);
        $stmt->bindValue(':data_cad_fornecedor', $dados['data_cad_fornecedor']);
        $stmt->bindValue(':email_fornecedor', $dados['email_fornecedor']);
        $stmt->bindValue(':site_fornecedor', $dados['site_fornecedor']);
        $stmt->bindValue(':telefone_fornecedor', $dados['telefone_fornecedor']);
        $stmt->bindValue(':endereco_fornecedor', $dados['endereco_fornecedor']);
        $stmt->bindValue(':bairro_fornecedor', $dados['bairro_fornecedor']);
        $stmt->bindValue(':cidade_fornecedor', $dados['cidade_fornecedor']);
        $stmt->bindValue(':id_uf', $dados['id_uf']);
        $stmt->bindValue(':status_fornecedor', $dados['status_fornecedor']);
        $stmt->bindValue(':id_fornecedor', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Método para buscar fornecedor por ID
    public function getFornecedorById($id)
    {
        $sql = "SELECT f.*, e.nome_uf, e.sigla_uf 
            FROM tbl_fornecedor f
            INNER JOIN tbl_estado e ON f.id_uf = e.id_uf
            WHERE f.id_fornecedor = :id_fornecedor
            LIMIT 1;";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_fornecedor', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para adicionar um novo estado
    public function obterUf($nome)
    {
        $sql = "INSERT INTO tbl_estado (nome_estado) VALUES (:nome)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome', $nome);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    // Desativar Fornecedor
    public function desativarFornecedor($id)
    {
        $sql = "UPDATE tbl_fornecedor SET status_fornecedor = 'Inativo' WHERE id_fornecedor = :id_fornecedor";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('id_fornecedor', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
