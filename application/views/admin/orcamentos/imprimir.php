<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orçamento #<?= $orcamento->numero ?> - Le Cortine</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #8B4513;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #8B4513;
            font-size: 28px;
            margin-bottom: 5px;
        }
        
        .header p {
            color: #666;
            font-size: 14px;
        }
        
        .info-section {
            margin-bottom: 20px;
        }
        
        .info-section h2 {
            background: #8B4513;
            color: white;
            padding: 8px 10px;
            font-size: 16px;
            margin-bottom: 10px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .info-item {
            padding: 5px 0;
        }
        
        .info-item strong {
            color: #333;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table th {
            background: #f5f5f5;
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
            font-weight: bold;
        }
        
        table td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        
        .text-right {
            text-align: right;
        }
        
        .total-row {
            background: #f9f9f9;
            font-weight: bold;
            font-size: 16px;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
            text-align: center;
            color: #666;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: bold;
        }
        
        .badge-warning { background: #ffc107; color: #000; }
        .badge-success { background: #28a745; color: #fff; }
        .badge-info { background: #17a2b8; color: #fff; }
        .badge-danger { background: #dc3545; color: #fff; }
        
        @media print {
            body {
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    
    <div class="header">
        <h1>Le Cortine</h1>
        <p>Cortinas Sob Medida</p>
        <p>www.lecortine.com.br | contato@lecortine.com.br</p>
    </div>
    
    <div class="info-section">
        <h2>Orçamento #<?= $orcamento->numero ?></h2>
        <div class="info-grid">
            <div class="info-item">
                <strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($orcamento->criado_em)) ?>
            </div>
            <div class="info-item">
                <strong>Status:</strong>
                <?php
                $badge_class = 'badge-secondary';
                switch($orcamento->status) {
                    case 'pendente': $badge_class = 'badge-warning'; break;
                    case 'em_analise': $badge_class = 'badge-info'; break;
                    case 'aprovado': $badge_class = 'badge-success'; break;
                    case 'recusado': $badge_class = 'badge-danger'; break;
                }
                ?>
                <span class="badge <?= $badge_class ?>">
                    <?= ucfirst(str_replace('_', ' ', $orcamento->status)) ?>
                </span>
            </div>
        </div>
    </div>
    
    <div class="info-section">
        <h2>Dados do Cliente</h2>
        <div class="info-grid">
            <div class="info-item">
                <strong>Nome:</strong> <?= $cliente->nome ?>
            </div>
            <div class="info-item">
                <strong>Email:</strong> <?= $cliente->email ?>
            </div>
            <div class="info-item">
                <strong>Telefone:</strong> <?= $cliente->telefone ?>
            </div>
            <div class="info-item">
                <strong>WhatsApp:</strong> <?= $cliente->whatsapp ?>
            </div>
        </div>
        
        <?php if($cliente->endereco): ?>
            <div class="info-item">
                <strong>Endereço:</strong><br>
                <?= $cliente->endereco ?><br>
                <?= $cliente->cidade ?> - <?= $cliente->estado ?>
                <?php if($cliente->cep): ?>
                    <br>CEP: <?= $cliente->cep ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="info-section">
        <h2>Itens do Orçamento</h2>
        <table>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Detalhes</th>
                    <th>Dimensões</th>
                    <th class="text-right">Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($itens as $item): ?>
                    <tr>
                        <td><?= $item->produto->nome ?></td>
                        <td>
                            <?php if(isset($item->tecido)): ?>
                                Tecido: <?= $item->tecido->nome ?><br>
                            <?php endif; ?>
                            <?php if(isset($item->cor)): ?>
                                Cor: <?= $item->cor->nome ?><br>
                            <?php endif; ?>
                            <?php if(!empty($item->extras)): ?>
                                Extras:
                                <?php foreach($item->extras as $extra): ?>
                                    <?= $extra->extra_nome ?>;
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= $item->largura ?>m × <?= $item->altura ?>m
                            <?php if($item->quantidade > 1): ?>
                                <br>Qtd: <?= $item->quantidade ?>
                            <?php endif; ?>
                        </td>
                        <td class="text-right">
                            R$ <?= number_format($item->valor_total, 2, ',', '.') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="3" class="text-right">TOTAL:</td>
                    <td class="text-right">R$ <?= number_format($orcamento->valor_final, 2, ',', '.') ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    
    <?php if($orcamento->observacoes_cliente): ?>
        <div class="info-section">
            <h2>Observações do Cliente</h2>
            <p><?= nl2br($orcamento->observacoes_cliente) ?></p>
        </div>
    <?php endif; ?>
    
    <div class="footer">
        <p><strong>Le Cortine - Cortinas Sob Medida</strong></p>
        <p>www.lecortine.com.br | contato@lecortine.com.br</p>
        <p>Desenvolvido por Rafael Dias - doisr.com.br</p>
    </div>
    
    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" style="padding: 10px 30px; background: #8B4513; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
            Imprimir
        </button>
        <button onclick="window.close()" style="padding: 10px 30px; background: #666; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; margin-left: 10px;">
            Fechar
        </button>
    </div>
    
    <script>
        // Auto-print ao carregar (opcional)
        // window.onload = function() { window.print(); }
    </script>
    
</body>
</html>
