<!-- Page header -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Gerenciar</div>
                <h2 class="page-title">Coleções de Tecidos</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="<?= base_url('admin/colecoes/criar') ?>" class="btn btn-primary d-none d-sm-inline-block">
                        <i class="ti ti-plus"></i> Nova Coleção
                    </a>
                    <a href="<?= base_url('admin/colecoes/criar') ?>" class="btn btn-primary d-sm-none btn-icon">
                        <i class="ti ti-plus"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <?php if (!empty($colecoes)): ?>
                <?php foreach ($colecoes as $colecao): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <?php if ($colecao->imagem): ?>
                        <div class="card-img-top img-responsive img-responsive-16x9" 
                             style="background-image: url(<?= base_url('uploads/colecoes/' . $colecao->imagem) ?>)">
                        </div>
                        <?php endif; ?>
                        
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-fill">
                                    <h3 class="card-title mb-1">
                                        <a href="<?= base_url('admin/colecoes/editar/' . $colecao->id) ?>" class="text-reset">
                                            <?= $colecao->nome ?>
                                        </a>
                                    </h3>
                                    <div class="text-secondary">
                                        <small>
                                            <i class="ti ti-texture"></i> 
                                            <?= $colecao->total_tecidos ?> <?= $colecao->total_tecidos == 1 ? 'tecido' : 'tecidos' ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="ms-auto">
                                    <label class="form-check form-switch m-0">
                                        <input class="form-check-input toggle-status" 
                                               type="checkbox" 
                                               data-id="<?= $colecao->id ?>"
                                               <?= $colecao->status === 'ativo' ? 'checked' : '' ?>>
                                    </label>
                                </div>
                            </div>
                            
                            <?php if ($colecao->descricao): ?>
                            <p class="text-secondary mb-3">
                                <?= character_limiter($colecao->descricao, 100) ?>
                            </p>
                            <?php endif; ?>
                            
                            <div class="d-flex gap-2">
                                <a href="<?= base_url('admin/tecidos?colecao=' . $colecao->id) ?>" 
                                   class="btn btn-ghost-primary w-100">
                                    <i class="ti ti-texture"></i> Ver Tecidos
                                </a>
                                <a href="<?= base_url('admin/colecoes/editar/' . $colecao->id) ?>" 
                                   class="btn btn-icon btn-ghost-primary">
                                    <i class="ti ti-edit"></i>
                                </a>
                                <a href="<?= base_url('admin/colecoes/deletar/' . $colecao->id) ?>" 
                                   class="btn btn-icon btn-ghost-danger btn-delete"
                                   data-title="Deletar Coleção?"
                                   data-text="Esta ação não poderá ser desfeita.">
                                    <i class="ti ti-trash"></i>
                                </a>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <div class="row align-items-center">
                                <div class="col">
                                    <small class="text-secondary">
                                        Criado em <?= date('d/m/Y', strtotime($colecao->criado_em)) ?>
                                    </small>
                                </div>
                                <div class="col-auto">
                                    <span class="badge <?= $colecao->status === 'ativo' ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= ucfirst($colecao->status) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
            <div class="col-12">
                <div class="card">
                    <div class="empty">
                        <div class="empty-icon">
                            <i class="ti ti-palette"></i>
                        </div>
                        <p class="empty-title">Nenhuma coleção cadastrada</p>
                        <p class="empty-subtitle text-secondary">
                            Comece criando sua primeira coleção de tecidos
                        </p>
                        <div class="empty-action">
                            <a href="<?= base_url('admin/colecoes/criar') ?>" class="btn btn-primary">
                                <i class="ti ti-plus"></i> Nova Coleção
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
$(document).ready(function() {
    // Toggle status
    $('.toggle-status').on('change', function() {
        const id = $(this).data('id');
        const checkbox = $(this);
        
        $.ajax({
            url: '<?= base_url('admin/colecoes/toggle_status/') ?>' + id,
            method: 'POST',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            },
            error: function() {
                checkbox.prop('checked', !checkbox.prop('checked'));
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: 'Erro ao alterar status',
                    timer: 2000
                });
            }
        });
    });
});
</script>
