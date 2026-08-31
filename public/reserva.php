<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require_once '../config/Conexao.php';
require_once '../src/Reserva.php';

$reserva = new Reserva($pdo);

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $acao = $_POST['acao'] ?? '';

        if ($acao === 'excluir') {
            $reserva->excluir((int) ($_POST['id'] ?? 0));
            echo json_encode(['mensagem' => 'Reserva excluída com sucesso.']);
            exit;
        }

        if ($acao === 'salvar') {
            $id = (int) ($_POST['id'] ?? 0);
            $dados = [
                'status' => trim((string) ($_POST['status'] ?? '')),
                'data_hora_inicio' => trim((string) ($_POST['data_hora_inicio'] ?? '')),
                'data_hora_final' => trim((string) ($_POST['data_hora_final'] ?? '')),
                'aluno_matricula' => (int) ($_POST['aluno_matricula'] ?? 0),
            ];

            $reserva->salvar($id, $dados);

            $mensagem = $id > 0 ? 'Reserva atualizada com sucesso.' : 'Reserva cadastrada com sucesso.';
            echo json_encode(['mensagem' => $mensagem]);
            exit;
        }

        http_response_code(400);
        echo json_encode(['erro' => 'Ação inválida.']);
        exit;
    }

    if (isset($_GET['editar'])) {
        $registro = $reserva->buscarPorId((int) $_GET['editar']);
        echo json_encode(['reserva' => $registro]);
        exit;
    }

    echo json_encode(['reservas' => $reserva->listarTodos()]);
} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode(['erro' => $e->getMessage()]);
}