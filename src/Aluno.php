<?php
declare(strict_types=1);

class Aluno
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function listarTodos(): array
    {
        return $this->pdo->query(
            'SELECT matricula, nome, email, cpf, telefone, `endereço` AS endereco
             FROM aluno ORDER BY matricula DESC'
        )->fetchAll();
    }

    public function buscarPorId(int $matricula): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT matricula, nome, email, cpf, telefone, `endereço` AS endereco
             FROM aluno WHERE matricula = ?'
        );
        $stmt->execute([$matricula]);
        return $stmt->fetch() ?: null;
    }

    public function salvar(int $matricula, array $dados): void
    {
        if (in_array('', $dados, true)) {
            throw new InvalidArgumentException('Preencha todos os campos.');
        }

        $parametros = [
            ':nome' => $dados['nome'],
            ':email' => $dados['email'],
            ':cpf' => $dados['cpf'],
            ':telefone' => $dados['telefone'],
            ':endereco' => $dados['endereco'],
        ];

        if ($matricula > 0) {
            $parametros[':matricula'] = $matricula;
            $sql = 'UPDATE aluno SET nome=:nome, email=:email, cpf=:cpf,
                    telefone=:telefone, `endereço`=:endereco WHERE matricula=:matricula';
        } else {
            $sql = 'INSERT INTO aluno (nome, email, cpf, telefone, `endereço`)
                    VALUES (:nome, :email, :cpf, :telefone, :endereco)';
        }

        $this->pdo->prepare($sql)->execute($parametros);
    }

    public function excluir(int $matricula): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM aluno WHERE matricula = ?');
        $stmt->execute([$matricula]);
    }
}