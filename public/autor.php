<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require_once '../config/Conexao.php';
require_once '../src/Autor.php';

$autor = new Autor($pdo);

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $acao = $_POST['acao'] ?? '';

        if ($acao === 'excluir') {
            $autor->excluir((int) ($_POST['id'] ?? 0));
            echo json_encode(['mensagem' => 'Autor excluído com sucesso.']);
            exit;
        }

        if ($acao === 'salvar') {
            $id = (int) ($_POST['id'] ?? 0);
            $dados = [
                'nome' => trim((string) ($_POST['nome'] ?? '')),
                'cpf' => trim((string) ($_POST['cpf'] ?? '')),
                'email' => trim((string) ($_POST['email'] ?? '')),
            ];

            $autor->salvar($id, $dados);

            $mensagem = $id > 0 ? 'Autor atualizado com sucesso.' : 'Autor cadastrado com sucesso.';
            echo json_encode(['mensagem' => $mensagem]);
            exit;
        }

        http_response_code(400);
        echo json_encode(['erro' => 'Ação inválida.']);
        exit;
    }

    if (isset($_GET['editar'])) {
        $registro = $autor->buscarPorId((int) $_GET['editar']);
        echo json_encode(['autor' => $registro]);
        exit;
    }

    echo json_encode(['autores' => $autor->listarTodos()]);
} catch (Throwable $e) {
    http_response_code(400);
    $mensagemErro = $e instanceof PDOException && ($e->errorInfo[1] ?? null) === 1062
        ? 'E-mail ou CPF já cadastrado.'
        : $e->getMessage();
    echo json_encode(['erro' => $mensagemErro]);
}