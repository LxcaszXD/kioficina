<?php

class Cliente extends Model
{


    public function buscarCliente($email)
    {

        $sql = "SELECT * FROM tbl_cliente WHERE email_cliente = :email AND status_cliente = 'Ativo'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getContarCliente()
    {

        $sql = "SELECT COUNT(*) AS total_clientes FROM tbl_cliente";
        $stmt = $this->db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTodosClientes()
    {
        $sql = "SELECT * FROM tbl_cliente WHERE status_cliente = 'Ativo'";
        $stmt = $this->db->query($sql);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    ////////////////////////DASHBOARD/////////////////////


    // Médoto para o DASHBOARD - Listar todos os serviços com galeria e especialidade
    public function getListarCliente()
    {
        $sql = "SELECT c.*, e.nome_uf 
            FROM tbl_cliente c 
            INNER JOIN tbl_estado e ON c.id_uf = e.id_uf 
            WHERE c.status_cliente = 'Ativo'
            ORDER BY c.nome_cliente;";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    // METODO DASHBOARD ADICONAR CLIENTE
    public function addCliente($dados)
    {
        $sql = "INSERT INTO tbl_cliente (
                nome_cliente,
                tipo_cliente,
                cpf_cnpj_cliente,
                data_nasc_cliente,
                email_cliente,
                senha_cliente,
                foto_cliente,
                alt_foto_cliente,
                telefone_cliente,
                endereco_cliente,
                bairro_cliente,
                cidade_cliente,
                id_uf,
                status_cliente
            ) VALUES (
                :nome_cliente,
                :tipo_cliente,
                :cpf_cnpj_cliente,
                :data_nasc_cliente,
                :email_cliente,
                :senha_cliente,
                :foto_cliente,
                :alt_foto_cliente,
                :telefone_cliente,
                :endereco_cliente,
                :bairro_cliente,
                :cidade_cliente,
                :id_uf,
                :status_cliente
            );";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':nome_cliente', $dados['nome_cliente']);
        $stmt->bindValue(':tipo_cliente', $dados['tipo_cliente']);
        $stmt->bindValue(':cpf_cnpj_cliente', $dados['cpf_cnpj_cliente']);
        $stmt->bindValue(':data_nasc_cliente', $dados['data_nasc_cliente']);
        $stmt->bindValue(':email_cliente', $dados['email_cliente']);
        $stmt->bindValue(':senha_cliente', $dados['senha_cliente']);
        $stmt->bindValue(':foto_cliente', $dados['foto_cliente']);
        $stmt->bindValue(':alt_foto_cliente', $dados['alt_foto_cliente']);
        $stmt->bindValue(':telefone_cliente', $dados['telefone_cliente']);
        $stmt->bindValue(':endereco_cliente', $dados['endereco_cliente']);
        $stmt->bindValue(':bairro_cliente', $dados['bairro_cliente']);
        $stmt->bindValue(':cidade_cliente', $dados['cidade_cliente']);
        $stmt->bindValue(':id_uf', $dados['id_uf']);
        $stmt->bindValue(':status_cliente', $dados['status_cliente']);

        $stmt->execute();

        return $this->db->lastInsertId();
    }

    //** Atualizar Cliente */
    public function atualizarCliente($id, $dados)
    {
        $sql = "UPDATE tbl_cliente SET
                      nome_cliente        = :nome_cliente,
                      tipo_cliente        = :tipo_cliente,
                      cpf_cnpj_cliente    = :cpf_cnpj_cliente,
                      data_nasc_cliente   = :data_nasc_cliente,
                      email_cliente       = :email_cliente,
                      telefone_cliente    = :telefone_cliente,
                      endereco_cliente    = :endereco_cliente,
                      bairro_cliente      = :bairro_cliente,
                      cidade_cliente      = :cidade_cliente,
                      id_uf               = :id_uf,
                      status_cliente      = :status_cliente,
                      foto_cliente        = :foto_cliente,
                      alt_foto_cliente    = :alt_foto_cliente";

        // Atualiza a senha apenas se estiver no array
        if (!empty($dados['senha_cliente'])) {
            $sql .= ", senha_cliente = :senha_cliente";
        }

        $sql .= " WHERE id_cliente = :id_cliente";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome_cliente', $dados['nome_cliente']);
        $stmt->bindValue(':tipo_cliente', $dados['tipo_cliente']);
        $stmt->bindValue(':cpf_cnpj_cliente', $dados['cpf_cnpj_cliente']);
        $stmt->bindValue(':data_nasc_cliente', $dados['data_nasc_cliente']);
        $stmt->bindValue(':email_cliente', $dados['email_cliente']);
        $stmt->bindValue(':telefone_cliente', $dados['telefone_cliente']);
        $stmt->bindValue(':endereco_cliente', $dados['endereco_cliente']);
        $stmt->bindValue(':bairro_cliente', $dados['bairro_cliente']);
        $stmt->bindValue(':cidade_cliente', $dados['cidade_cliente']);
        $stmt->bindValue(':id_uf', $dados['id_uf'], PDO::PARAM_INT);
        $stmt->bindValue(':status_cliente', $dados['status_cliente']);
        $stmt->bindValue(':foto_cliente', $dados['foto_cliente']);
        $stmt->bindValue(':alt_foto_cliente', $dados['alt_foto_cliente']);
        $stmt->bindValue(':id_cliente', $id, PDO::PARAM_INT);

        if (!empty($dados['senha_cliente'])) {
            $stmt->bindValue(':senha_cliente', $dados['senha_cliente']);
        }

        return $stmt->execute();
    }

    // Método para buscar os dados de Cliente de acordo com o ID
    public function getClienteById($id)
    {
        $sql = "SELECT c.*, e.nome_uf, e.sigla_uf 
                FROM tbl_cliente c
                INNER JOIN tbl_estado e ON c.id_uf = e.id_uf
                WHERE c.id_cliente = :id_cliente
                LIMIT 1;";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_cliente', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obter estado
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

    // Método para desativar o cliente
    public function desativarCliente($id)
    {
        $sql = "UPDATE tbl_cliente SET status_cliente = 'Inativo' WHERE id_cliente = :id_cliente";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('id_cliente', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
