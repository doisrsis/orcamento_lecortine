<!-- Page header -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/produtos') ?>">Produtos</a></li>
                        <li class="breadcrumb-item active"><?= isset($produto) ? 'Editar' : 'Novo' ?></li>
                    </ol>
                </nav>
                <h2 class="page-title"><?= isset($produto) ? 'Editar Produto' : 'Novo Produto' ?></h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <a href="<?= base_url('admin/produtos') ?>" class="btn btn-ghost-secondary">
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
            <!-- Conteúdo Principal -->
            <div class="col-lg-8">
                <!-- Informações Básicas -->
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
                            <li class="nav-item">
                                <a href="#tab-basico" class="nav-link active" data-bs-toggle="tab">
                                    <i class="ti ti-info-circle me-2"></i> Informações Básicas
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#tab-descricao" class="nav-link" data-bs-toggle="tab">
                                    <i class="ti ti-file-text me-2"></i> Descrição
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#tab-seo" class="nav-link" data-bs-toggle="tab">
                                    <i class="ti ti-seo me-2"></i> SEO
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Tab: Básico -->
                            <div class="tab-pane active show" id="tab-basico">
                                <div class="mb-3">
                                    <label class="form-label required">Nome do Produto</label>
                                    <input type="text" 
                                           name="nome" 
                                           class="form-control <?= form_error('nome') ? 'is-invalid' : '' ?>" 
                                           value="<?= set_value('nome', $produto->nome ?? '') ?>"
                                           placeholder="Ex: Cortina Rolô Blackout"
                                           required>
                                    <?php if (form_error('nome')): ?>
                                        <div class="invalid-feedback"><?= form_error('nome') ?></div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label required">Categoria</label>
                                    <select name="categoria_id" class="form-select <?= form_error('categoria_id') ? 'is-invalid' : '' ?>" required>
                                        <option value="">Selecione...</option>
                                        <?php foreach ($categorias as $cat): ?>
                                            <option value="<?= $cat->id ?>" <?= set_select('categoria_id', $cat->id, isset($produto) && $produto->categoria_id == $cat->id) ?>>
                                                <?= $cat->nome ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (form_error('categoria_id')): ?>
                                        <div class="invalid-feedback"><?= form_error('categoria_id') ?></div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Descrição Curta</label>
                                    <textarea name="descricao_curta" 
                                              class="form-control <?= form_error('descricao_curta') ? 'is-invalid' : '' ?>" 
                                              rows="3"
                                              placeholder="Breve descrição do produto (máx. 500 caracteres)"><?= set_value('descricao_curta', $produto->descricao_curta ?? '') ?></textarea>
                                    <?php if (form_error('descricao_curta')): ?>
                                        <div class="invalid-feedback"><?= form_error('descricao_curta') ?></div>
                                    <?php endif; ?>
                                    <small class="form-hint">Exibida na listagem de produtos.</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Preço Base</label>
                                    <div class="input-group">
                                        <span class="input-group-text">R$</span>
                                        <input type="text" 
                                               name="preco_base" 
                                               class="form-control mask-money <?= form_error('preco_base') ? 'is-invalid' : '' ?>" 
                                               value="<?= set_value('preco_base', $produto->preco_base ?? '') ?>"
                                               placeholder="0,00">
                                        <?php if (form_error('preco_base')): ?>
                                            <div class="invalid-feedback"><?= form_error('preco_base') ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <small class="form-hint">Preço de referência (opcional).</small>
                                </div>
                            </div>
                            
                            <!-- Tab: Descrição -->
                            <div class="tab-pane" id="tab-descricao">
                                <div class="mb-3">
                                    <label class="form-label">Descrição Completa</label>
                                    <textarea name="descricao_completa" 
                                              id="editor-descricao"
                                              class="form-control <?= form_error('descricao_completa') ? 'is-invalid' : '' ?>" 
                                              rows="10"><?= set_value('descricao_completa', $produto->descricao_completa ?? '') ?></textarea>
                                    <?php if (form_error('descricao_completa')): ?>
                                        <div class="invalid-feedback"><?= form_error('descricao_completa') ?></div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Características</label>
                                    <textarea name="caracteristicas" 
                                              class="form-control" 
                                              rows="6"
                                              placeholder="• Característica 1&#10;• Característica 2&#10;• Característica 3"><?= set_value('caracteristicas', $produto->caracteristicas ?? '') ?></textarea>
                                    <small class="form-hint">Uma característica por linha.</small>
                                </div>
                            </div>
                            
                            <!-- Tab: SEO -->
                            <div class="tab-pane" id="tab-seo">
                                <div class="mb-3">
                                    <label class="form-label">Meta Title</label>
                                    <input type="text" 
                                           name="meta_title" 
                                           class="form-control" 
                                           value="<?= set_value('meta_title', $produto->meta_title ?? '') ?>"
                                           placeholder="Título para SEO (deixe vazio para usar o nome do produto)">
                                    <small class="form-hint">Recomendado: 50-60 caracteres.</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Meta Description</label>
                                    <textarea name="meta_description" 
                                              class="form-control" 
                                              rows="3"
                                              placeholder="Descrição para mecanismos de busca"><?= set_value('meta_description', $produto->meta_description ?? '') ?></textarea>
                                    <small class="form-hint">Recomendado: 150-160 caracteres.</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Meta Keywords</label>
                                    <input type="text" 
                                           name="meta_keywords" 
                                           class="form-control" 
                                           value="<?= set_value('meta_keywords', $produto->meta_keywords ?? '') ?>"
                                           placeholder="palavra1, palavra2, palavra3">
                                    <small class="form-hint">Palavras-chave separadas por vírgula.</small>
                                </div>
                                
                                <?php if (isset($produto)): ?>
                                <div class="mb-0">
                                    <label class="form-label">Slug (URL)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><?= base_url('produto/') ?></span>
                                        <input type="text" class="form-control" value="<?= $produto->slug ?>" readonly>
                                    </div>
                                    <small class="form-hint">Gerado automaticamente.</small>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Galeria de Imagens -->
                <?php if (isset($produto)): ?>
                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Galeria de Imagens</h3>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($imagens)): ?>
                        <div class="row row-cards mb-3" id="sortable-galeria">
                            <?php foreach ($imagens as $img): ?>
                            <div class="col-md-3" data-id="<?= $img->id ?>">
                                <div class="card card-sm">
                                    <div class="card-img-top img-responsive img-responsive-1x1" 
                                         style="background-image: url(<?= base_url('uploads/produtos/' . $img->imagem) ?>); cursor: move;">
                                    </div>
                                    <div class="card-body p-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-secondary">Ordem: <?= $img->ordem ?></small>
                                            <button type="button" 
                                                    class="btn btn-sm btn-icon btn-ghost-danger delete-galeria-img" 
                                                    data-id="<?= $img->id ?>">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        
                        <div class="mb-0">
                            <label class="form-label">Adicionar Imagens</label>
                            <input type="file" 
                                   name="galeria[]" 
                                   class="form-control" 
                                   accept="image/*"
                                   multiple>
                            <small class="form-hint">Selecione múltiplas imagens. Arraste para reordenar.</small>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Imagem Principal -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Imagem Principal</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <input type="file" 
                                   name="imagem_principal" 
                                   class="form-control" 
                                   accept="image/*"
                                   onchange="previewImage(this, 'preview-principal')">
                            <small class="form-hint">Recomendado: 800x600px</small>
                        </div>
                        
                        <div id="preview-principal">
                            <?php if (isset($produto) && $produto->imagem_principal): ?>
                                <img src="<?= base_url('uploads/produtos/' . $produto->imagem_principal) ?>" 
                                     alt="<?= $produto->nome ?>" 
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
                                <option value="ativo" <?= set_select('status', 'ativo', (isset($produto) && $produto->status === 'ativo') || !isset($produto)) ?>>Ativo</option>
                                <option value="inativo" <?= set_select('status', 'inativo', isset($produto) && $produto->status === 'inativo') ?>>Inativo</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-check">
                                <input type="checkbox" 
                                       name="destaque" 
                                       class="form-check-input" 
                                       value="1"
                                       <?= set_checkbox('destaque', '1', isset($produto) && $produto->destaque) ?>>
                                <span class="form-check-label">Produto em Destaque</span>
                            </label>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Ordem</label>
                            <input type="number" 
                                   name="ordem" 
                                   class="form-control" 
                                   value="<?= set_value('ordem', $produto->ordem ?? 0) ?>"
                                   min="0">
                        </div>
                        
                        <?php if (isset($produto)): ?>
                        <hr>
                        <div class="mb-0">
                            <small class="text-secondary">
                                <strong>Criado em:</strong><br>
                                <?= date('d/m/Y H:i', strtotime($produto->criado_em)) ?>
                            </small>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="card-footer">
                        <div class="d-flex">
                            <a href="<?= base_url('admin/produtos') ?>" class="btn btn-link">Cancelar</a>
                            <button type="submit" class="btn btn-primary ms-auto">
                                <i class="ti ti-device-floppy"></i>
                                <?= isset($produto) ? 'Atualizar' : 'Salvar' ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?= form_close() ?>
    </div>
</div>

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
    // Sortable galeria
    <?php if (isset($produto) && !empty($imagens)): ?>
    const sortable = new Sortable(document.getElementById('sortable-galeria'), {
        animation: 150,
        onEnd: function(evt) {
            const ordem = [];
            $('#sortable-galeria > div').each(function() {
                ordem.push($(this).data('id'));
            });
            
            $.ajax({
                url: '<?= base_url('admin/produtos/reordenar_imagens') ?>',
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
    
    // Deletar imagem da galeria
    $('.delete-galeria-img').on('click', function() {
        const id = $(this).data('id');
        const card = $(this).closest('.col-md-3');
        
        Swal.fire({
            title: 'Deletar Imagem?',
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
                    url: '<?= base_url('admin/produtos/deletar_imagem/') ?>' + id,
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
                        Swal.fire('Erro!', 'Erro ao deletar imagem', 'error');
                    }
                });
            }
        });
    });
});
</script>
