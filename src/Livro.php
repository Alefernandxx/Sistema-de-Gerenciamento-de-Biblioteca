<?php
declare(strict_types=1);

class Livro
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function pesquisar(string $termo = ''): array
    {
        $sql = "SELECT l.id, l.titulo, l.genero, l.ano_lançamento,
                       COALESCE(GROUP_CONCAT(a.nome SEPARATOR ', '), 'Sem Autor') AS autores,
                       COALESCE(r.status, 'DISPONÍVEL') AS reserva_status
                FROM livro l
                LEFT JOIN autor_livro al ON l.id = al.livro_id
                LEFT JOIN autor a ON al.autor_id = a.id
                LEFT JOIN reserva r ON l.reserva_id = r.id
                WHERE l.titulo LIKE :termo OR a.nome LIKE :termo
                GROUP BY l.id
                ORDER BY l.id DESC";
                
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':termo' => "%$termo%"]);
        return $stmt->fetchAll();
    }

    public function salvar(int $id, array $dados): void
    {
        $this->pdo->beginTransaction();
        
        try {
            if ($id > 0) {
                $sql = 'UPDATE livro SET titulo=:titulo, genero=:genero, ano_lançamento=:ano, reserva_id=:reserva_id WHERE id=:id';
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                    ':titulo' => $dados['titulo'], 
                    ':genero' => $dados['genero'], 
                    ':ano' => $dados['ano_lancamento'], 
                    ':reserva_id' => $dados['reserva_id'], 
                    ':id' => $id
                ]);
                
                $this->pdo->prepare('DELETE FROM autor_livro WHERE livro_id = ?')->execute([$id]);
                $livro_id = $id;
            } else {
                $sql = 'INSERT INTO livro (titulo, genero, ano_lançamento, reserva_id) VALUES (:titulo, :genero, :ano, :reserva_id)';
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                    ':titulo' => $dados['titulo'], 
                    ':genero' => $dados['genero'], 
                    ':ano' => $dados['ano_lancamento'], 
                    ':reserva_id' => $dados['reserva_id']
                ]);
                
                $livro_id = (int) $this->pdo->lastInsertId(); 
            }

            $this->pdo->prepare('INSERT INTO autor_livro (livro_id, autor_id) VALUES (?, ?)')
                      ->execute([$livro_id, $dados['autor_id']]);

            $this->pdo->commit();
        } catch (Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function excluir(int $id): void
    {
        $this->pdo->prepare('DELETE FROM autor_livro WHERE livro_id = ?')->execute([$id]);
        $this->pdo->prepare('DELETE FROM livro WHERE id = ?')->execute([$id]);
    }
}