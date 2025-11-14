<!-- Page header -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Gerenciar</div>
                <h2 class="page-title">Tecidos</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="<?= base_url('admin/tecidos/criar') ?>" class="btn btn-primary d-none d-sm-inline-block">
                        <i class="ti ti-plus"></i> Novo Tecido
                    </a>
                    <a href="<?= base_url('admin/tecidos/criar') ?>" class="btn btn-primary d-sm-none btn-icon">
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
        <!-- Filtros -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <?= form_open('admin/tecidos', ['method' => 'get', 'class' => 'row g-3']) ?>
                            <div class="col-md-4">
                                <label class="form-label">Buscar</label>
                                <input type="text" name="busca" class="form-control" placeholder="Nome ou código..." value="<?= $this->input->get('busca') ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Coleção</label>
                                <select name="colecao" class="form-select">
                                    <option value="">Todas</option>
                                    <?php foreach ($colecoes as $col): ?>
                                        <option value="<?= $col->id ?>" <?= $this->input->get('colecao') == $col->id ? 'selected' : '' ?>>
                                            <?= $col->nome ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">Todos</option>
                                    <option value="ativo" <?= $this->input->get('status') === 'ativo' ? 'selected' : '' ?>>Ativo</option>
                                    <option value="inativo" <?= $this->input->get('status') === 'inativo' ? 'selected' : '' ?>>Inativo</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="ti ti-search"></i> Filtrar
                                    </button>
                                    <a href="<?= base_url('admin/tecidos') ?>" class="btn btn-ghost-secondary">
                                        <i class="ti ti-x"></i>
                                    </a>
                                </div>
                            </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Lista de Tecidos -->
        <div class="row row-cards">
            <?php if (!empty($tecidos)): ?>
                <?php foreach ($tecidos as $tecido): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <?php if ($tecido->imagem): ?>
                        <div class="card-img-top img-responsive img-responsive-16x9" 
                             style="background-image: url(<?= base_url('uploads/tecidos/' . $tecido->imagem) ?>)">
                        </div>
                        <?php endif; ?>
                        
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-fill">
                                    <h3 class="card-title mb-1">
                                        <a href="<?= base_url('admin/tecidos/editar/' . $tecido->id) ?>" class="text-reset">
                                            <?= $tecido->nome ?>
                                        </a>
                                    </h3>
                                    <div class="text-secondary">
                                        <small>
                                            <i class="ti ti-palette"></i> <?= $tecido->colecao_nome ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="ms-auto">
                                    <label class="form-check form-switch m-0">
                                        <input class="form-check-input toggle-status" 
                                               type="checkbox" 
                                               data-id="<?= $tecido->id ?>"
                                               <?= $tecido->status === 'ativo' ? 'checked' : '' ?>>
                                    </label>
                                </div>
                            </div>
                            
                            <?php if ($tecido->codigo): ?>
                            <div class="mb-2">
                                <span class="badge bg-secondary">Cód: <?= $tecido->codigo ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($tecido->composicao): ?>
                            <p class="text-secondary mb-2">
                                <small><?= character_limiter($tecido->composicao, 60) ?></small>
                            </p>
                            <?php endif; ?>
                            
                            <div class="mb-3">
                                <div class="row g-2">
                                    <?php if (isset($tecido->largura_padrao) && $tecido->largura_padrao): ?>
                                    <div class="col-6">
                                        <small class="text-secondary">
                                            <i class="ti ti-ruler"></i> <?= $tecido->largura_padrao ?>cm
                                        </small>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($tecido->total_cores): ?>
                                    <div class="col-6">
                                        <small class="text-secondary">
                                            <i class="ti ti-color-swatch"></i> <?= $tecido->total_cores ?> <?= $tecido->total_cores == 1 ? 'cor' : 'cores' ?>
                                        </small>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <a href="<?= base_url('admin/tecidos/editar/' . $tecido->id) ?>" 
                                   class="btn btn-primary w-100">
                                    <i class="ti ti-edit"></i> Editar
                                </a>
                                <a href="<?= base_url('admin/tecidos/deletar/' . $tecido->id) ?>" 
                                   class="btn btn-icon btn-ghost-danger btn-delete"
                                   data-title="Deletar Tecido?"
                                   data-text="Esta ação não poderá ser desfeita.">
                                    <i class="ti ti-trash"></i>
                                </a>
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
                            <i class="ti ti-texture"></i>
                        </div>
                        <p class="empty-title">Nenhum tecido encontrado</p>
                        <p class="empty-subtitle text-secondary">
                            <?= $this->input->get('busca') || $this->input->get('colecao') || $this->input->get('status') 
                                ? 'Tente ajustar os filtros de busca' 
                                : 'Comece criando seu primeiro tecido' ?>
                        </p>
                        <div class="empty-action">
                            <?php if ($this->input->get('busca') || $this->input->get('colecao') || $this->input->get('status')): ?>
                                <a href="<?= base_url('admin/tecidos') ?>" class="btn btn-primary">
                                    <i class="ti ti-x"></i> Limpar Filtros
                                </a>
                            <?php else: ?>
                                <a href="<?= base_url('admin/tecidos/criar') ?>" class="btn btn-primary">
                                    <i class="ti ti-plus"></i> Novo Tecido
                                </a>
                            <?php endif; ?>
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
            url: '<?= base_url('admin/tecidos/toggle_status/') ?>' + id,
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
