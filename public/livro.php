<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require_once '../config/Conexao.php';
require_once '../src/Livro.php';

$livro = new Livro($pdo);

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $acao = $_POST['acao'] ?? '';

        if ($acao === 'excluir') {
            $livro->excluir((int) ($_POST['id'] ?? 0));
            echo json_encode(['mensagem' => 'Livro excluído com sucesso.']);
            exit;
        }

        if ($acao === 'salvar') {
            $id = (int) ($_POST['id'] ?? 0);
            $dados = [
                'titulo' => trim((string) ($_POST['titulo'] ?? '')),
                'genero' => trim((string) ($_POST['genero'] ?? '')),
                'ano_lancamento' => (int) ($_POST['ano_lancamento'] ?? 0),
                'reserva_id' => (int) ($_POST['reserva_id'] ?? 0),
                'autor_id' => (int) ($_POST['autor_id'] ?? 0)
            ];

            $livro->salvar($id, $dados);
            $mensagem = $id > 0 ? 'Livro atualizado com sucesso.' : 'Livro cadastrado com sucesso.';
            echo json_encode(['mensagem' => $mensagem]);
            exit;
        }

        http_response_code(400);
        echo json_encode(['erro' => 'Ação inválida.']);
        exit;
    }

    $termo = $_GET['busca'] ?? '';
    echo json_encode(['livros' => $livro->pesquisar($termo)]);

} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode(['erro' => $e->getMessage()]);
}