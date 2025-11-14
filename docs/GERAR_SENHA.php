<?php
/**
 * Script para Gerar Hash de Senha
 * Autor: Rafael Dias - doisr.com.br
 * Data: 14/11/2024
 * 
 * USO:
 * 1. Acesse: http://localhost/orcamento/docs/GERAR_SENHA.php?senha=SUA_SENHA_AQUI
 * 2. Copie o hash gerado
 * 3. Execute o UPDATE no banco de dados
 */

// Verificar se a senha foi passada
if (!isset($_GET['senha']) || empty($_GET['senha'])) {
    die('
    <h1>Gerador de Hash de Senha</h1>
    <p>Use: <code>GERAR_SENHA.php?senha=SUA_SENHA</code></p>
    <p>Exemplo: <code>GERAR_SENHA.php?senha=admin123</code></p>
    ');
}

$senha = $_GET['senha'];
$hash = password_hash($senha, PASSWORD_DEFAULT);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hash de Senha Gerado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #8B4513;
        }
        .hash-box {
            background: #f9f9f9;
            padding: 15px;
            border: 2px solid #8B4513;
            border-radius: 5px;
            word-break: break-all;
            font-family: monospace;
            margin: 20px 0;
        }
        .sql-box {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 15px;
            border-radius: 5px;
            font-family: monospace;
            margin: 20px 0;
            overflow-x: auto;
        }
        .info {
            background: #e3f2fd;
            padding: 15px;
            border-left: 4px solid #2196F3;
            margin: 20px 0;
        }
        .success {
            background: #e8f5e9;
            padding: 15px;
            border-left: 4px solid #4CAF50;
            margin: 20px 0;
        }
        button {
            background: #8B4513;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #6d3410;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>✅ Hash de Senha Gerado com Sucesso!</h1>
        
        <div class="success">
            <strong>Senha Original:</strong> <?= htmlspecialchars($senha) ?>
        </div>
        
        <h2>Hash Gerado (bcrypt):</h2>
        <div class="hash-box" id="hash">
            <?= $hash ?>
        </div>
        
        <button onclick="copiarHash()">📋 Copiar Hash</button>
        
        <h2>SQL para Atualizar no Banco:</h2>
        <div class="sql-box" id="sql">
-- Atualizar senha do usuário admin
UPDATE usuarios 
SET senha = '<?= $hash ?>', 
    atualizado_em = NOW() 
WHERE email = 'admin@lecortine.com.br';

-- OU atualizar por ID
UPDATE usuarios 
SET senha = '<?= $hash ?>', 
    atualizado_em = NOW() 
WHERE id = 1;
        </div>
        
        <button onclick="copiarSQL()">📋 Copiar SQL</button>
        
        <div class="info">
            <h3>ℹ️ Informações:</h3>
            <ul>
                <li><strong>Algoritmo:</strong> bcrypt (PASSWORD_DEFAULT)</li>
                <li><strong>Segurança:</strong> Alta (muito mais seguro que MD5)</li>
                <li><strong>Tamanho:</strong> 60 caracteres</li>
                <li><strong>Salt:</strong> Gerado automaticamente</li>
            </ul>
        </div>
        
        <div class="info">
            <h3>📝 Como Usar:</h3>
            <ol>
                <li>Copie o SQL acima</li>
                <li>Abra o phpMyAdmin</li>
                <li>Selecione o banco: <code>cecriativocom_lecortine_orc</code></li>
                <li>Vá na aba "SQL"</li>
                <li>Cole e execute o comando</li>
                <li>Pronto! Senha alterada com sucesso</li>
            </ol>
        </div>
        
        <hr style="margin: 30px 0;">
        
        <p><a href="?senha=">← Gerar outra senha</a></p>
    </div>
    
    <script>
        function copiarHash() {
            const hash = document.getElementById('hash').textContent.trim();
            navigator.clipboard.writeText(hash).then(function() {
                alert('✅ Hash copiado para a área de transferência!');
            });
        }
        
        function copiarSQL() {
            const sql = document.getElementById('sql').textContent.trim();
            navigator.clipboard.writeText(sql).then(function() {
                alert('✅ SQL copiado para a área de transferência!');
            });
        }
    </script>
</body>
</html>
