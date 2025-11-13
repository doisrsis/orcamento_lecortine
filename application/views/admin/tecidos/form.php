<!-- Page header -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/tecidos') ?>">Tecidos</a></li>
                        <li class="breadcrumb-item active"><?= isset($tecido) ? 'Editar' : 'Novo' ?></li>
                    </ol>
                </nav>
                <h2 class="page-title"><?= isset($tecido) ? 'Editar Tecido' : 'Novo Tecido' ?></h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <a href="<?= base_url('admin/tecidos') ?>" class="btn btn-ghost-secondary">
                    <i class="ti ti-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <?= form_open_multipart('', ['class' => 'needs-validation', 'novalidate' => '']) ?>
        
        <div class="row row-cards">
            <!-- Informações Principais -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informações do Tecido</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label required">Nome do Tecido</label>
                                    <input type="text" 
                                           name="nome" 
                                           class="form-control <?= form_error('nome') ? 'is-invalid' : '' ?>" 
                                           value="<?= set_value('nome', $tecido->nome ?? '') ?>"
                                           placeholder="Ex: Linho Rústico, Voil Transparente"
                                           required>
                                    <?php if (form_error('nome')): ?>
                                        <div class="invalid-feedback"><?= form_error('nome') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Código</label>
                                    <input type="text" 
                                           name="codigo" 
                                           class="form-control <?= form_error('codigo') ? 'is-invalid' : '' ?>" 
                                           value="<?= set_value('codigo', $tecido->codigo ?? '') ?>"
                                           placeholder="Ex: LR-001">
                                    <?php if (form_error('codigo')): ?>
                                        <div class="invalid-feedback"><?= form_error('codigo') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label required">Coleção</label>
                            <select name="colecao_id" class="form-select <?= form_error('colecao_id') ? 'is-invalid' : '' ?>" required>
                                <option value="">Selecione...</option>
                                <?php foreach ($colecoes as $col): ?>
                                    <option value="<?= $col->id ?>" <?= set_select('colecao_id', $col->id, isset($tecido) && $tecido->colecao_id == $col->id) ?>>
                                        <?= $col->nome ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (form_error('colecao_id')): ?>
                                <div class="invalid-feedback"><?= form_error('colecao_id') ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <textarea name="descricao" 
                                      class="form-control" 
                                      rows="3"
                                      placeholder="Descrição do tecido (opcional)"><?= set_value('descricao', $tecido->descricao ?? '') ?></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Composição</label>
                                    <input type="text" 
                                           name="composicao" 
                                           class="form-control" 
                                           value="<?= set_value('composicao', $tecido->composicao ?? '') ?>"
                                           placeholder="Ex: 100% Poliéster">
                                    <small class="form-hint">Material do tecido.</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Largura (cm)</label>
                                    <input type="number" 
                                           name="largura" 
                                           class="form-control" 
                                           value="<?= set_value('largura', $tecido->largura ?? '') ?>"
                                           placeholder="280"
                                           step="0.01">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Gramatura (g/m²)</label>
                                    <input type="number" 
                                           name="gramatura" 
                                           class="form-control" 
                                           value="<?= set_value('gramatura', $tecido->gramatura ?? '') ?>"
                                           placeholder="150"
                                           step="0.01">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-0">
                            <label class="form-label">Características</label>
                            <textarea name="caracteristicas" 
                                      class="form-control" 
                                      rows="4"
                                      placeholder="• Característica 1&#10;• Característica 2&#10;• Característica 3"><?= set_value('caracteristicas', $tecido->caracteristicas ?? '') ?></textarea>
                            <small class="form-hint">Uma característica por linha.</small>
                        </div>
                    </div>
                </div>
                
                <!-- Cores do Tecido -->
                <?php if (isset($tecido)): ?>
                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Cores Disponíveis</h3>
                        <div class="card-actions">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-add-cor">
                                <i class="ti ti-plus"></i> Adicionar Cor
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($cores)): ?>
                        <div class="row row-cards" id="sortable-cores">
                            <?php foreach ($cores as $cor): ?>
                            <div class="col-md-4" data-id="<?= $cor->id ?>">
                                <div class="card card-sm">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="me-2" style="cursor: move;">
                                                <i class="ti ti-grip-vertical text-secondary"></i>
                                            </div>
                                            <?php if ($cor->imagem): ?>
                                            <div class="avatar me-2" style="background-image: url(<?= base_url('uploads/tecidos/' . $cor->imagem) ?>)"></div>
                                            <?php else: ?>
                                            <div class="avatar me-2" style="background-color: <?= $cor->codigo_hex ?? '#cccccc' ?>"></div>
                                            <?php endif; ?>
                                            <div class="flex-fill">
                                                <strong><?= $cor->nome ?></strong>
                                                <?php if ($cor->codigo_hex): ?>
                                                <div><small class="text-secondary"><?= $cor->codigo_hex ?></small></div>
                                                <?php endif; ?>
                                            </div>
                                            <button type="button" 
                                                    class="btn btn-sm btn-icon btn-ghost-danger delete-cor" 
                                                    data-id="<?= $cor->id ?>">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php else: ?>
                        <div class="empty">
                            <div class="empty-icon">
                                <i class="ti ti-color-swatch"></i>
                            </div>
                            <p class="empty-title">Nenhuma cor cadastrada</p>
                            <p class="empty-subtitle text-secondary">
                                Adicione as cores disponíveis para este tecido
                            </p>
                            <div class="empty-action">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-cor">
                                    <i class="ti ti-plus"></i> Adicionar Cor
                                </button>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Imagem -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Imagem do Tecido</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <input type="file" 
                                   name="imagem" 
                                   class="form-control" 
                                   accept="image/*"
                                   onchange="previewImage(this, 'preview-imagem')">
                            <small class="form-hint">Recomendado: 800x600px</small>
                        </div>
                        
                        <div id="preview-imagem">
                            <?php if (isset($tecido) && $tecido->imagem): ?>
                                <img src="<?= base_url('uploads/tecidos/' . $tecido->imagem) ?>" 
                                     alt="<?= $tecido->nome ?>" 
                                     class="img-fluid rounded">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Configurações -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Configurações</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label required">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="ativo" <?= set_select('status', 'ativo', (isset($tecido) && $tecido->status === 'ativo') || !isset($tecido)) ?>>Ativo</option>
                                <option value="inativo" <?= set_select('status', 'inativo', isset($tecido) && $tecido->status === 'inativo') ?>>Inativo</option>
                            </select>
                        </div>
                        
                        <?php if (isset($tecido)): ?>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">Slug (URL)</label>
                            <input type="text" 
                                   class="form-control" 
                                   value="<?= $tecido->slug ?>" 
                                   readonly>
                            <small class="form-hint">Gerado automaticamente.</small>
                        </div>
                        
                        <div class="mb-0">
                            <small class="text-secondary">
                                <strong>Criado em:</strong><br>
                                <?= date('d/m/Y H:i', strtotime($tecido->criado_em)) ?>
                            </small>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="card-footer">
                        <div class="d-flex">
                            <a href="<?= base_url('admin/tecidos') ?>" class="btn btn-link">Cancelar</a>
                            <button type="submit" class="btn btn-primary ms-auto">
                                <i class="ti ti-device-floppy"></i>
                                <?= isset($tecido) ? 'Atualizar' : 'Salvar' ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?= form_close() ?>
    </div>
</div>

<!-- Modal Adicionar Cor -->
<?php if (isset($tecido)): ?>
<div class="modal modal-blur fade" id="modal-add-cor" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Cor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-add-cor" enctype="multipart/form-data">
                <input type="hidden" name="tecido_id" value="<?= $tecido->id ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Nome da Cor</label>
                        <input type="text" name="nome" class="form-control" placeholder="Ex: Branco, Bege, Cinza" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Código Hexadecimal</label>
                        <input type="color" name="codigo_hex" class="form-control form-control-color" value="#cccccc">
                        <small class="form-hint">Cor para visualização (opcional).</small>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Imagem da Cor</label>
                        <input type="file" name="imagem" class="form-control" accept="image/*">
                        <small class="form-hint">Foto da cor do tecido (opcional).</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-plus"></i> Adicionar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" class="img-fluid rounded">';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$(document).ready(function() {
    <?php if (isset($tecido) && !empty($cores)): ?>
    // Sortable cores
    const sortable = new Sortable(document.getElementById('sortable-cores'), {
        animation: 150,
        onEnd: function(evt) {
            const ordem = [];
            $('#sortable-cores > div').each(function() {
                ordem.push($(this).data('id'));
            });
            
            $.ajax({
                url: '<?= base_url('admin/tecidos/reordenar_cores') ?>',
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
                }
            });
        }
    });
    <?php endif; ?>
    
    // Adicionar cor
    $('#form-add-cor').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        $.ajax({
            url: '<?= base_url('admin/tecidos/adicionar_cor') ?>',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: 'Erro ao adicionar cor',
                    timer: 2000
                });
            }
        });
    });
    
    // Deletar cor
    $(document).on('click', '.delete-cor', function() {
        const id = $(this).data('id');
        const card = $(this).closest('.col-md-4');
        
        Swal.fire({
            title: 'Deletar Cor?',
            text: 'Esta ação não poderá ser desfeita!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, deletar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('admin/tecidos/deletar_cor/') ?>' + id,
                    method: 'POST',
                    success: function(response) {
                        if (response.success) {
                            card.fadeOut(300, function() {
                                $(this).remove();
                            });
                            Swal.fire('Deletado!', response.message, 'success');
                        }
                    },
                    error: function() {
                        Swal.fire('Erro!', 'Erro ao deletar cor', 'error');
                    }
                });
            }
        });
    });
});
</script>
