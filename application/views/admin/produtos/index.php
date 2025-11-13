<!-- Page header -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Gerenciar</div>
                <h2 class="page-title">Produtos</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="<?= base_url('admin/produtos/criar') ?>" class="btn btn-primary d-none d-sm-inline-block">
                        <i class="ti ti-plus"></i> Novo Produto
                    </a>
                    <a href="<?= base_url('admin/produtos/criar') ?>" class="btn btn-primary d-sm-none btn-icon">
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
                        <?= form_open('admin/produtos', ['method' => 'get', 'class' => 'row g-3']) ?>
                            <div class="col-md-4">
                                <label class="form-label">Buscar</label>
                                <input type="text" name="busca" class="form-control" placeholder="Nome do produto..." value="<?= $this->input->get('busca') ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Categoria</label>
                                <select name="categoria" class="form-select">
                                    <option value="">Todas</option>
                                    <?php foreach ($categorias as $cat): ?>
                                        <option value="<?= $cat->id ?>" <?= $this->input->get('categoria') == $cat->id ? 'selected' : '' ?>>
                                            <?= $cat->nome ?>
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
                                    <a href="<?= base_url('admin/produtos') ?>" class="btn btn-ghost-secondary">
                                        <i class="ti ti-x"></i>
                                    </a>
                                </div>
                            </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Lista de Produtos -->
        <div class="row row-cards">
            <?php if (!empty($produtos)): ?>
                <?php foreach ($produtos as $produto): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-img-top img-responsive img-responsive-16x9" style="background-image: url(<?= $produto->imagem_principal ? base_url('uploads/produtos/' . $produto->imagem_principal) : base_url('assets/img/placeholder.jpg') ?>)">
                            <div class="card-img-overlay card-img-overlay-dark d-flex flex-column">
                                <div class="mt-auto">
                                    <?php if ($produto->destaque): ?>
                                        <span class="badge bg-yellow">
                                            <i class="ti ti-star"></i> Destaque
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-fill">
                                    <h3 class="card-title mb-1">
                                        <a href="<?= base_url('admin/produtos/editar/' . $produto->id) ?>" class="text-reset">
                                            <?= $produto->nome ?>
                                        </a>
                                    </h3>
                                    <div class="text-secondary">
                                        <small><?= $produto->categoria_nome ?></small>
                                    </div>
                                </div>
                                <div class="ms-auto">
                                    <label class="form-check form-switch m-0">
                                        <input class="form-check-input toggle-status" 
                                               type="checkbox" 
                                               data-id="<?= $produto->id ?>"
                                               <?= $produto->status === 'ativo' ? 'checked' : '' ?>>
                                    </label>
                                </div>
                            </div>
                            
                            <?php if ($produto->descricao_curta): ?>
                            <p class="text-secondary mb-2">
                                <?= character_limiter($produto->descricao_curta, 80) ?>
                            </p>
                            <?php endif; ?>
                            
                            <?php if ($produto->preco_base): ?>
                            <div class="mb-2">
                                <strong class="text-primary">R$ <?= number_format($produto->preco_base, 2, ',', '.') ?></strong>
                            </div>
                            <?php endif; ?>
                            
                            <div class="d-flex gap-2 mt-3">
                                <a href="<?= base_url('admin/produtos/editar/' . $produto->id) ?>" class="btn btn-primary w-100">
                                    <i class="ti ti-edit"></i> Editar
                                </a>
                                <button type="button" 
                                        class="btn btn-icon btn-ghost-warning toggle-destaque" 
                                        data-id="<?= $produto->id ?>"
                                        title="<?= $produto->destaque ? 'Remover destaque' : 'Adicionar destaque' ?>">
                                    <i class="ti ti-star<?= $produto->destaque ? '-filled' : '' ?>"></i>
                                </button>
                                <a href="<?= base_url('admin/produtos/deletar/' . $produto->id) ?>" 
                                   class="btn btn-icon btn-ghost-danger btn-delete"
                                   data-title="Deletar Produto?"
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
                            <i class="ti ti-package"></i>
                        </div>
                        <p class="empty-title">Nenhum produto encontrado</p>
                        <p class="empty-subtitle text-secondary">
                            <?= $this->input->get('busca') || $this->input->get('categoria') || $this->input->get('status') 
                                ? 'Tente ajustar os filtros de busca' 
                                : 'Comece criando seu primeiro produto' ?>
                        </p>
                        <div class="empty-action">
                            <?php if ($this->input->get('busca') || $this->input->get('categoria') || $this->input->get('status')): ?>
                                <a href="<?= base_url('admin/produtos') ?>" class="btn btn-primary">
                                    <i class="ti ti-x"></i> Limpar Filtros
                                </a>
                            <?php else: ?>
                                <a href="<?= base_url('admin/produtos/criar') ?>" class="btn btn-primary">
                                    <i class="ti ti-plus"></i> Novo Produto
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
            url: '<?= base_url('admin/produtos/toggle_status/') ?>' + id,
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
    
    // Toggle destaque
    $('.toggle-destaque').on('click', function() {
        const id = $(this).data('id');
        const btn = $(this);
        const icon = btn.find('i');
        
        $.ajax({
            url: '<?= base_url('admin/produtos/toggle_destaque/') ?>' + id,
            method: 'POST',
            success: function(response) {
                if (response.success) {
                    if (response.data.destaque) {
                        icon.removeClass('ti-star').addClass('ti-star-filled');
                        btn.attr('title', 'Remover destaque');
                    } else {
                        icon.removeClass('ti-star-filled').addClass('ti-star');
                        btn.attr('title', 'Adicionar destaque');
                    }
                    
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
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: 'Erro ao alterar destaque',
                    timer: 2000
                });
            }
        });
    });
});
</script>
