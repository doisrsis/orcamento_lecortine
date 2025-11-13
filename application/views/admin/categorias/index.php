<!-- Page header -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Gerenciar</div>
                <h2 class="page-title">Categorias</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="<?= base_url('admin/categorias/criar') ?>" class="btn btn-primary d-none d-sm-inline-block">
                        <i class="ti ti-plus"></i> Nova Categoria
                    </a>
                    <a href="<?= base_url('admin/categorias/criar') ?>" class="btn btn-primary d-sm-none btn-icon">
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Categorias</h3>
                        <div class="card-actions">
                            <span class="text-secondary">Total: <?= count($categorias) ?></span>
                        </div>
                    </div>
                    
                    <?php if (!empty($categorias)): ?>
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table table-striped" id="table-categorias">
                            <thead>
                                <tr>
                                    <th class="w-1"><i class="ti ti-grip-vertical"></i></th>
                                    <th>Ícone</th>
                                    <th>Nome</th>
                                    <th>Slug</th>
                                    <th>Ordem</th>
                                    <th>Status</th>
                                    <th>Data</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody id="sortable-categorias">
                                <?php foreach ($categorias as $categoria): ?>
                                <tr data-id="<?= $categoria->id ?>">
                                    <td class="sortable-handle" style="cursor: move;">
                                        <i class="ti ti-grip-vertical text-secondary"></i>
                                    </td>
                                    <td>
                                        <?php if ($categoria->icone): ?>
                                            <img src="<?= base_url('uploads/categorias/' . $categoria->icone) ?>" 
                                                 alt="<?= $categoria->nome ?>" 
                                                 class="avatar avatar-sm">
                                        <?php else: ?>
                                            <span class="avatar avatar-sm">
                                                <i class="ti ti-category"></i>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex py-1 align-items-center">
                                            <div class="flex-fill">
                                                <div class="font-weight-medium"><?= $categoria->nome ?></div>
                                                <?php if ($categoria->descricao): ?>
                                                    <div class="text-secondary">
                                                        <small><?= character_limiter($categoria->descricao, 50) ?></small>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <code><?= $categoria->slug ?></code>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary"><?= $categoria->ordem ?></span>
                                    </td>
                                    <td>
                                        <label class="form-check form-switch">
                                            <input class="form-check-input toggle-status" 
                                                   type="checkbox" 
                                                   data-id="<?= $categoria->id ?>"
                                                   <?= $categoria->status === 'ativo' ? 'checked' : '' ?>>
                                            <span class="form-check-label">
                                                <?= $categoria->status === 'ativo' ? 'Ativo' : 'Inativo' ?>
                                            </span>
                                        </label>
                                    </td>
                                    <td>
                                        <small><?= date('d/m/Y', strtotime($categoria->criado_em)) ?></small>
                                    </td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            <a href="<?= base_url('admin/categorias/editar/' . $categoria->id) ?>" 
                                               class="btn btn-sm btn-icon btn-ghost-primary" 
                                               title="Editar">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <a href="<?= base_url('admin/categorias/deletar/' . $categoria->id) ?>" 
                                               class="btn btn-sm btn-icon btn-ghost-danger btn-delete" 
                                               title="Deletar"
                                               data-title="Deletar Categoria?"
                                               data-text="Esta ação não poderá ser desfeita.">
                                                <i class="ti ti-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="empty">
                        <div class="empty-icon">
                            <i class="ti ti-category"></i>
                        </div>
                        <p class="empty-title">Nenhuma categoria cadastrada</p>
                        <p class="empty-subtitle text-secondary">
                            Comece criando sua primeira categoria de produtos
                        </p>
                        <div class="empty-action">
                            <a href="<?= base_url('admin/categorias/criar') ?>" class="btn btn-primary">
                                <i class="ti ti-plus"></i> Nova Categoria
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
$(document).ready(function() {
    // Sortable para reordenar
    <?php if (!empty($categorias)): ?>
    const sortable = new Sortable(document.getElementById('sortable-categorias'), {
        handle: '.sortable-handle',
        animation: 150,
        onEnd: function(evt) {
            const ordem = [];
            $('#sortable-categorias tr').each(function(index) {
                ordem.push($(this).data('id'));
            });
            
            // Salvar ordem via AJAX
            $.ajax({
                url: '<?= base_url('admin/categorias/reordenar') ?>',
                method: 'POST',
                data: { ordem: ordem },
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
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: 'Erro ao atualizar ordem',
                        timer: 2000
                    });
                }
            });
        }
    });
    <?php endif; ?>
    
    // Toggle status
    $('.toggle-status').on('change', function() {
        const id = $(this).data('id');
        const checkbox = $(this);
        
        $.ajax({
            url: '<?= base_url('admin/categorias/toggle_status/') ?>' + id,
            method: 'POST',
            success: function(response) {
                if (response.success) {
                    const label = checkbox.next('.form-check-label');
                    label.text(response.data.status === 'ativo' ? 'Ativo' : 'Inativo');
                    
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
