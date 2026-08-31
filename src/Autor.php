<?php
declare(strict_types=1);

class Autor
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function listarTodos(): array
    {
        return $this->pdo->query(
            'SELECT id, nome, cpf, email FROM autor ORDER BY id DESC'
        )->fetchAll();
    }

    public function buscarPorId(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT id, nome, cpf, email FROM autor WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function salvar(int $id, array $dados): void
    {
        if (in_array('', $dados, true)) {
            throw new InvalidArgumentException('Preencha todos os campos.');
        }

        $parametros = [
            ':nome' => $dados['nome'],
            ':cpf' => $dados['cpf'],
            ':email' => $dados['email']
        ];

        if ($id > 0) {
            $parametros[':id'] = $id;
            $sql = 'UPDATE autor SET nome=:nome, cpf=:cpf, email=:email WHERE id=:id';
        } else {
            $sql = 'INSERT INTO autor (nome, cpf, email) VALUES (:nome, :cpf, :email)';
        }

        $this->pdo->prepare($sql)->execute($parametros);
    }

    public function excluir(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM autor WHERE id = ?');
        $stmt->execute([$id]);
    }
}