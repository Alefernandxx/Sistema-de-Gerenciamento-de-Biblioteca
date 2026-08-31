<?php
declare(strict_types=1);

class Reserva
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function listarTodos(): array
    {
        return $this->pdo->query(
            'SELECT id, status, data_hora_inicio, data_hora_final, aluno_matricula FROM reserva ORDER BY id DESC'
        )->fetchAll();
    }

    public function buscarPorId(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT id, status, data_hora_inicio, data_hora_final, aluno_matricula FROM reserva WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function salvar(int $id, array $dados): void
    {
        $parametros = [
            ':status' => $dados['status'],
            ':inicio' => $dados['data_hora_inicio'],
            ':final' => empty($dados['data_hora_final']) ? null : $dados['data_hora_final'], // Trata data nula
            ':matricula' => $dados['aluno_matricula']
        ];

        if ($id > 0) {
            $parametros[':id'] = $id;
            $sql = 'UPDATE reserva SET status=:status, data_hora_inicio=:inicio, data_hora_final=:final, aluno_matricula=:matricula WHERE id=:id';
        } else {
            $sql = 'INSERT INTO reserva (status, data_hora_inicio, data_hora_final, aluno_matricula) VALUES (:status, :inicio, :final, :matricula)';
        }

        $this->pdo->prepare($sql)->execute($parametros);
    }

    public function excluir(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM reserva WHERE id = ?');
        $stmt->execute([$id]);
    }
}