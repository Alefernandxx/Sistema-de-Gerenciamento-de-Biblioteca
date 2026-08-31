<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require_once '../config/conexao.php';
require_once '../src/Aluno.php';

/** @var PDO $pdo Defined by config/conexao.php. */
$aluno = new Aluno($pdo);

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $acao = $_POST['acao'] ?? '';

        if ($acao === 'excluir') {
            $aluno->excluir((int) ($_POST['matricula'] ?? 0));
            echo json_encode(['mensagem' => 'Aluno excluído com sucesso.']);
            exit;
        }

        if ($acao === 'salvar') {
            $matricula = (int) ($_POST['matricula'] ?? 0);
            $dados = [
                'nome' => trim((string) ($_POST['nome'] ?? '')),
                'email' => trim((string) ($_POST['email'] ?? '')),
                'cpf' => trim((string) ($_POST['cpf'] ?? '')),
                'telefone' => trim((string) ($_POST['telefone'] ?? '')),
                'endereco' => trim((string) ($_POST['endereco'] ?? '')),
            ];

            $aluno->salvar($matricula, $dados);

            $mensagem = $matricula > 0
                ? 'Aluno atualizado com sucesso.'
                : 'Aluno cadastrado com sucesso.';
            echo json_encode(['mensagem' => $mensagem]);
            exit;
        }

        http_response_code(400);
        echo json_encode(['erro' => 'Ação inválida.']);
        exit;
    }

    if (isset($_GET['editar'])) {
        $registro = $aluno->buscarPorId((int) $_GET['editar']);
        echo json_encode(['aluno' => $registro]);
        exit;
    }

    echo json_encode(['alunos' => $aluno->listarTodos()]);
} catch (Throwable $e) {
    http_response_code(400);
    $mensagemErro = $e instanceof PDOException && ($e->errorInfo[1] ?? null) === 1062
        ? 'E-mail, CPF ou telefone já cadastrado.'
        : $e->getMessage();
    echo json_encode(['erro' => $mensagemErro]);
}