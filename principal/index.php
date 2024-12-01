<?php
session_start();
require('../login/config.php');

// Se tiver uma sessão salva, significa que o login deu certo
if (isset($_SESSION['banco']) && !empty($_SESSION['banco'])) {
    $id = $_SESSION['banco']; // Obtenha o ID do usuário da sessão

    $sql = $pdo->prepare("SELECT * FROM cadastros WHERE id = :id");
    $sql->bindValue(":id", $id, PDO::PARAM_INT);
    $sql->execute();

    if ($sql->rowCount() > 0) {
        $info = $sql->fetch(PDO::FETCH_ASSOC);
    } else {
        echo 'Nenhum ID encontrado...';
    }
} else {
    header('Location: ../login/login.php');
    exit();
}

// Movimentações
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco</title>
</head>
<body>
    <div style="text-align: center;">
        <h1>🪙Faria Limers🪙</h1>
        <p>👩‍🦰 Nome: 
        <?php echo $info['nome']; ?>
        </p>
        <p> Agência: 
        <?php echo $info['agencia']; ?>
        </p>
        <p> Conta: 
        <?php echo $info['conta']; ?>
        </p>
        <a href="../login/sair.php">Sair↩️</a>
    </div>
    <hr>
    <h3>📋 Movimentações</h3>

    <table width="300px" border="1">
        <tr>
            <th>Data</th>
            <th>Valor</th>
        </tr>
        <?php  
        $sql = $pdo->prepare("SELECT * FROM historico WHERE id_conta = :id_conta");
        $sql->bindValue(":id_conta", $id, PDO::PARAM_INT);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            foreach ($sql->fetchAll(PDO::FETCH_ASSOC) as $item) { ?>
                <tr>



                    <td><?php echo date('d/m/y H:i', strtotime($item['data_op'])); ?></td>
                    <td>
                        <?php if ($item['tipo'] == "0"): ?>
                            <span style="color: green;">R$ <?php echo "+".$item['valor']; ?></span>
                        <?php else: ?>
                            <span style="color: red;">R$ <?php echo "-".$item['valor']; ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php }
        }
        ?>
    </table>
    <a href="transacao.php">Add transação➕</a>
    <br>
</body>
</html>
