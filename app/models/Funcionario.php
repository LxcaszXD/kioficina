<?php

class Funcionario extends Model
{

    public function buscarFunc($email)
    {
        $sql = "SELECT * FROM tbl_funcionario WHERE email_funcionario = :email AND status_funcionario = 'Ativo'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    ////////////////////////DASHBOARD/////////////////////


    // Médoto para o DASHBOARD - Listar todos os serviços com galeria e especialidade
    public function getListarFuncionarios()
    {
        $sql = "SELECT f.*, e.nome_uf, es.nome_especialidade 
            FROM tbl_funcionario f 
            INNER JOIN tbl_estado e ON f.id_uf = e.id_uf
            LEFT JOIN tbl_especialidade es ON f.id_especialidade = es.id_especialidade 
            WHERE f.status_funcionario = 'Ativo'
            ORDER BY f.nome_funcionario;";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    // 5 METODO DASHBOARD ADICONAR SERVICO

    public function addFuncionario($dados)
    {
        // Garantir que 'alt_foto_funcionario' nunca seja NULL
        if (empty($dados['alt_foto_funcionario'])) {
            $dados['alt_foto_funcionario'] = 'Foto não disponível'; // Definir um valor padrão
        }

        $sql = "INSERT INTO tbl_funcionario (
        nome_funcionario,
        tipo_funcionario,
        cpf_cnpj_funcionario,
        data_adm_funcionario,
        email_funcionario,
        senha_funcionario,
        foto_funcionario,
        alt_foto_funcionario,
        telefone_funcionario,
        endereco_funcionario,
        bairro_funcionario,
        cidade_funcionario,
        id_uf,
        id_especialidade,
        cargo_funcionario,
        salario_funcionario,
        facebook_funcionario,
        instagram_funcionario,
        linkedin_funcionario,
        status_funcionario) VALUES (
        :nome_funcionario,
        :tipo_funcionario,
        :cpf_cnpj_funcionario,
        :data_adm_funcionario,
        :email_funcionario,
        :senha_funcionario,
        :foto_funcionario,
        :alt_foto_funcionario,
        :telefone_funcionario,
        :endereco_funcionario,
        :bairro_funcionario,
        :cidade_funcionario,
        :id_uf,
        :id_especialidade,
        :cargo_funcionario,
        :salario_funcionario,
        :facebook_funcionario,
        :instagram_funcionario,
        :linkedin_funcionario,
        :status_funcionario
         )";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome_funcionario', $dados['nome_funcionario']);
        $stmt->bindValue(':tipo_funcionario', $dados['tipo_funcionario']);
        $stmt->bindValue(':cpf_cnpj_funcionario', $dados['cpf_cnpj_funcionario']);
        $stmt->bindValue(':data_adm_funcionario', $dados['data_adm_funcionario']);
        $stmt->bindValue(':email_funcionario', $dados['email_funcionario']);
        $stmt->bindValue(':senha_funcionario', $dados['senha_funcionario']); // Agora com a senha
        $stmt->bindValue(':foto_funcionario', $dados['foto_funcionario']);
        $stmt->bindValue(':alt_foto_funcionario', $dados['alt_foto_funcionario']);
        $stmt->bindValue(':telefone_funcionario', $dados['telefone_funcionario']);
        $stmt->bindValue(':endereco_funcionario', $dados['endereco_funcionario']);
        $stmt->bindValue(':bairro_funcionario', $dados['bairro_funcionario']);
        $stmt->bindValue(':cidade_funcionario', $dados['cidade_funcionario']);
        $stmt->bindValue(':id_uf', $dados['id_uf']);
        $stmt->bindValue(':id_especialidade', $dados['id_especialidade']);
        $stmt->bindValue(':cargo_funcionario', $dados['cargo_funcionario']);
        $stmt->bindValue(':salario_funcionario', $dados['salario_funcionario']);
        $stmt->bindValue(':facebook_funcionario', $dados['facebook_funcionario']);
        $stmt->bindValue(':instagram_funcionario', $dados['instagram_funcionario']);
        $stmt->bindValue(':linkedin_funcionario', $dados['linkedin_funcionario']);
        $stmt->bindValue(':status_funcionario', $dados['status_funcionario']);

        $stmt->execute();

        return $this->db->lastInsertId();
    }

    // Atualizar Funcionario
    public function atualizarFuncionario($id, $dados)
    {
        $sql = "UPDATE tbl_funcionario SET
        nome_funcionario = :nome_funcionario,
        tipo_funcionario = :tipo_funcionario,
        cpf_cnpj_funcionario = :cpf_cnpj_funcionario,
        data_adm_funcionario = :data_adm_funcionario,
        email_funcionario = :email_funcionario,
        senha_funcionario = :senha_funcionario,
        foto_funcionario = :foto_funcionario,
        alt_foto_funcionario = :alt_foto_funcionario,
        telefone_funcionario = :telefone_funcionario,
        endereco_funcionario = :endereco_funcionario,
        bairro_funcionario = :bairro_funcionario,
        cidade_funcionario = :cidade_funcionario,
        id_uf = :id_uf,
        status_funcionario = :status_funcionario
         WHERE id_funcionario = :id_funcionario";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':nome_funcionario', $dados['nome_funcionario']);
        $stmt->bindValue(':tipo_funcionario', $dados['tipo_funcionario']);
        $stmt->bindValue(':cpf_cnpj_funcionario', $dados['cpf_cnpj_funcionario']);
        $stmt->bindValue(':data_adm_funcionario', $dados['data_adm_funcionario']);
        $stmt->bindValue(':email_funcionario', $dados['email_funcionario']);
        $stmt->bindValue(':senha_funcionario', $dados['senha_funcionario']);
        $stmt->bindValue(':foto_funcionario', $dados['foto_funcionario']);
        $stmt->bindValue(':alt_foto_funcionario', $dados['alt_foto_funcionario']);
        $stmt->bindValue(':telefone_funcionario', $dados['telefone_funcionario']);
        $stmt->bindValue(':endereco_funcionario', $dados['endereco_funcionario']);
        $stmt->bindValue(':bairro_funcionario', $dados['bairro_funcionario']);
        $stmt->bindValue(':cidade_funcionario', $dados['cidade_funcionario']);
        $stmt->bindValue(':id_uf', $dados['id_uf']);
        $stmt->bindValue(':status_funcionario', $dados['status_funcionario']);
        $stmt->bindValue(':id_funcionario', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Método para buscar os dados de Funcionário de acordo com o ID
    public function getFuncionarioById($id)
    {
        $sql = "SELECT f.*, e.nome_uf, e.sigla_uf 
            FROM tbl_funcionario f
            INNER JOIN tbl_estado e ON f.id_uf = e.id_uf
            WHERE f.id_funcionario = :id_funcionario
            LIMIT 1;";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_funcionario', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Criar ou Obter especialidade
    public function obterOuCriarEspecialidade($nome)
    {
        $sql = "INSERT INTO tbl_especialidade (nome_especialidade) VALUES (:nome)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome', $nome);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    // Método para desativar o funcionário
    public function desativarFuncionario($id)
    {
        $sql = "UPDATE tbl_funcionario SET status_funcionario = 'Inativo' WHERE id_funcionario = :id_funcionario";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('id_funcionario', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
