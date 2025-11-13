<!-- Page header -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Visão Geral</div>
                <h2 class="page-title">Dashboard</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="<?= base_url('orcamento/criar') ?>" class="btn btn-primary d-none d-sm-inline-block" target="_blank">
                        <i class="ti ti-plus"></i> Novo Orçamento
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <!-- Cards de Estatísticas -->
        <div class="row row-deck row-cards">
            <!-- Orçamentos Hoje -->
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Orçamentos Hoje</div>
                            <div class="ms-auto lh-1">
                                <div class="dropdown">
                                    <a class="dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Últimas 24h
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="h1 mb-3"><?= $stats['orcamentos_hoje'] ?></div>
                        <div class="d-flex mb-2">
                            <div>Orçamentos recebidos hoje</div>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: <?= $stats['orcamentos_hoje'] > 0 ? '100' : '0' ?>%" role="progressbar" aria-valuenow="<?= $stats['orcamentos_hoje'] ?>" aria-valuemin="0" aria-valuemax="100">
                                <span class="visually-hidden"><?= $stats['orcamentos_hoje'] ?> orçamentos</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Orçamentos Este Mês -->
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Orçamentos Este Mês</div>
                        </div>
                        <div class="h1 mb-3"><?= $stats['orcamentos_mes'] ?></div>
                        <div class="d-flex mb-2">
                            <div>Total de <?= $stats['orcamentos_total'] ?> orçamentos</div>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: <?= $stats['taxa_conversao'] ?>%" role="progressbar" aria-valuenow="<?= $stats['taxa_conversao'] ?>" aria-valuemin="0" aria-valuemax="100">
                                <span class="visually-hidden"><?= $stats['taxa_conversao'] ?>%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Valor Total -->
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Valor Este Mês</div>
                        </div>
                        <div class="h1 mb-3">R$ <?= number_format($stats['valor_mes'], 2, ',', '.') ?></div>
                        <div class="d-flex mb-2">
                            <div>Valor total dos orçamentos</div>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-info" style="width: 75%" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                <span class="visually-hidden">75%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Orçamentos Pendentes -->
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Pendentes</div>
                        </div>
                        <div class="h1 mb-3"><?= $stats['orcamentos_pendentes'] ?></div>
                        <div class="d-flex mb-2">
                            <div>Aguardando análise</div>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning" style="width: <?= $stats['orcamentos_pendentes'] > 0 ? '100' : '0' ?>%" role="progressbar">
                                <span class="visually-hidden"><?= $stats['orcamentos_pendentes'] ?> pendentes</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Gráficos e Tabelas -->
        <div class="row row-deck row-cards mt-3">
            <!-- Gráfico de Orçamentos -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Orçamentos nos Últimos 12 Meses</h3>
                    </div>
                    <div class="card-body">
                        <div id="chart-orcamentos" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
            
            <!-- Produtos Mais Solicitados -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Produtos Mais Solicitados</h3>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($produtos_populares)): ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($produtos_populares as $produto): ?>
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="avatar" style="background-image: url(<?= base_url('uploads/produtos/' . $produto->imagem_principal) ?>)"></span>
                                        </div>
                                        <div class="col text-truncate">
                                            <a href="<?= base_url('admin/produtos/editar/' . $produto->id) ?>" class="text-reset d-block"><?= $produto->nome ?></a>
                                            <div class="text-secondary text-truncate mt-n1"><?= $produto->total_solicitacoes ?? 0 ?> solicitações</div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="empty">
                                <div class="empty-icon">
                                    <i class="ti ti-package"></i>
                                </div>
                                <p class="empty-title">Nenhum produto solicitado ainda</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Orçamentos Recentes -->
        <div class="row row-deck row-cards mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Orçamentos Recentes</h3>
                        <div class="card-actions">
                            <a href="<?= base_url('admin/orcamentos') ?>" class="btn btn-sm btn-primary">
                                Ver Todos
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <?php if (!empty($orcamentos_recentes)): ?>
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>Número</th>
                                        <th>Cliente</th>
                                        <th>Tipo</th>
                                        <th>Valor</th>
                                        <th>Status</th>
                                        <th>Data</th>
                                        <th class="w-1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orcamentos_recentes as $orcamento): ?>
                                    <tr>
                                        <td>
                                            <a href="<?= base_url('admin/orcamentos/visualizar/' . $orcamento->id) ?>" class="text-reset">
                                                <?= $orcamento->numero ?>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="d-flex py-1 align-items-center">
                                                <span class="avatar me-2"><?= strtoupper(substr($orcamento->cliente_nome, 0, 2)) ?></span>
                                                <div class="flex-fill">
                                                    <div class="font-weight-medium"><?= $orcamento->cliente_nome ?></div>
                                                    <div class="text-secondary"><a href="#" class="text-reset"><?= $orcamento->cliente_email ?></a></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if ($orcamento->tipo_atendimento == 'consultoria'): ?>
                                                <span class="badge bg-purple">Consultoria</span>
                                            <?php else: ?>
                                                <span class="badge bg-blue">Orçamento</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>R$ <?= number_format($orcamento->valor_final, 2, ',', '.') ?></td>
                                        <td>
                                            <?php
                                            $status_badges = [
                                                'pendente' => 'bg-warning',
                                                'em_analise' => 'bg-info',
                                                'aprovado' => 'bg-success',
                                                'recusado' => 'bg-danger',
                                                'cancelado' => 'bg-secondary'
                                            ];
                                            $badge_class = $status_badges[$orcamento->status] ?? 'bg-secondary';
                                            ?>
                                            <span class="badge <?= $badge_class ?>"><?= ucfirst(str_replace('_', ' ', $orcamento->status)) ?></span>
                                        </td>
                                        <td><?= date('d/m/Y H:i', strtotime($orcamento->criado_em)) ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/orcamentos/visualizar/' . $orcamento->id) ?>" class="btn btn-sm btn-ghost-primary">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <div class="empty">
                            <div class="empty-icon">
                                <i class="ti ti-file-invoice"></i>
                            </div>
                            <p class="empty-title">Nenhum orçamento encontrado</p>
                            <p class="empty-subtitle text-secondary">
                                Aguardando novos orçamentos dos clientes
                            </p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script do Gráfico -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const chartData = <?= json_encode($grafico_orcamentos) ?>;
    
    const options = {
        series: [{
            name: 'Orçamentos',
            data: chartData.map(item => item.total)
        }],
        chart: {
            type: 'area',
            height: 300,
            toolbar: {
                show: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth',
            width: 2
        },
        xaxis: {
            categories: chartData.map(item => item.mes)
        },
        colors: ['#206bc4'],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.3,
            }
        }
    };

    const chart = new ApexCharts(document.querySelector("#chart-orcamentos"), options);
    chart.render();
});
</script>
