<!-- Page header -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/categorias') ?>">Categorias</a></li>
                        <li class="breadcrumb-item active"><?= isset($categoria) ? 'Editar' : 'Nova' ?></li>
                    </ol>
                </nav>
                <h2 class="page-title"><?= isset($categoria) ? 'Editar Categoria' : 'Nova Categoria' ?></h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <a href="<?= base_url('admin/categorias') ?>" class="btn btn-ghost-secondary">
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
            <!-- Informações Básicas -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informações Básicas</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label required">Nome da Categoria</label>
                            <input type="text" 
                                   name="nome" 
                                   class="form-control <?= form_error('nome') ? 'is-invalid' : '' ?>" 
                                   value="<?= set_value('nome', $categoria->nome ?? '') ?>"
                                   placeholder="Ex: Cortinas, Persianas, Toldos"
                                   required>
                            <?php if (form_error('nome')): ?>
                                <div class="invalid-feedback"><?= form_error('nome') ?></div>
                            <?php endif; ?>
                            <small class="form-hint">Nome que será exibido no site e sistema.</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <textarea name="descricao" 
                                      class="form-control <?= form_error('descricao') ? 'is-invalid' : '' ?>" 
                                      rows="4"
                                      placeholder="Descrição da categoria (opcional)"><?= set_value('descricao', $categoria->descricao ?? '') ?></textarea>
                            <?php if (form_error('descricao')): ?>
                                <div class="invalid-feedback"><?= form_error('descricao') ?></div>
                            <?php endif; ?>
                            <small class="form-hint">Breve descrição sobre esta categoria.</small>
                        </div>
                    </div>
                </div>
                
                <!-- Imagens -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Imagens</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Ícone</label>
                                    <input type="file" 
                                           name="icone" 
                                           class="form-control" 
                                           accept="image/*"
                                           onchange="previewImage(this, 'preview-icone')">
                                    <small class="form-hint">Ícone pequeno (recomendado: 64x64px). Formatos: JPG, PNG, SVG, WebP</small>
                                    
                                    <?php if (isset($categoria) && $categoria->icone): ?>
                                    <div class="mt-2" id="preview-icone">
                                        <img src="<?= base_url('uploads/categorias/' . $categoria->icone) ?>" 
                                             alt="Ícone atual" 
                                             class="img-thumbnail" 
                                             style="max-width: 100px;">
                                        <div class="mt-1">
                                            <small class="text-secondary">Ícone atual</small>
                                        </div>
                                    </div>
                                    <?php else: ?>
                                    <div class="mt-2" id="preview-icone"></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Imagem</label>
                                    <input type="file" 
                                           name="imagem" 
                                           class="form-control" 
                                           accept="image/*"
                                           onchange="previewImage(this, 'preview-imagem')">
                                    <small class="form-hint">Imagem de destaque (recomendado: 800x600px)</small>
                                    
                                    <?php if (isset($categoria) && $categoria->imagem): ?>
                                    <div class="mt-2" id="preview-imagem">
                                        <img src="<?= base_url('uploads/categorias/' . $categoria->imagem) ?>" 
                                             alt="Imagem atual" 
                                             class="img-thumbnail" 
                                             style="max-width: 200px;">
                                        <div class="mt-1">
                                            <small class="text-secondary">Imagem atual</small>
                                        </div>
                                    </div>
                                    <?php else: ?>
                                    <div class="mt-2" id="preview-imagem"></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Configurações -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Configurações</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label required">Status</label>
                            <select name="status" class="form-select <?= form_error('status') ? 'is-invalid' : '' ?>" required>
                                <option value="ativo" <?= set_select('status', 'ativo', (isset($categoria) && $categoria->status === 'ativo') || !isset($categoria)) ?>>Ativo</option>
                                <option value="inativo" <?= set_select('status', 'inativo', isset($categoria) && $categoria->status === 'inativo') ?>>Inativo</option>
                            </select>
                            <?php if (form_error('status')): ?>
                                <div class="invalid-feedback"><?= form_error('status') ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Ordem de Exibição</label>
                            <input type="number" 
                                   name="ordem" 
                                   class="form-control <?= form_error('ordem') ? 'is-invalid' : '' ?>" 
                                   value="<?= set_value('ordem', $categoria->ordem ?? 0) ?>"
                                   min="0">
                            <?php if (form_error('ordem')): ?>
                                <div class="invalid-feedback"><?= form_error('ordem') ?></div>
                            <?php endif; ?>
                            <small class="form-hint">Menor número aparece primeiro.</small>
                        </div>
                        
                        <?php if (isset($categoria)): ?>
                        <div class="mb-3">
                            <label class="form-label">Slug (URL)</label>
                            <input type="text" 
                                   class="form-control" 
                                   value="<?= $categoria->slug ?>" 
                                   readonly>
                            <small class="form-hint">Gerado automaticamente a partir do nome.</small>
                        </div>
                        
                        <div class="mb-0">
                            <label class="form-label">Criado em</label>
                            <input type="text" 
                                   class="form-control" 
                                   value="<?= date('d/m/Y H:i', strtotime($categoria->criado_em)) ?>" 
                                   readonly>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="card-footer">
                        <div class="d-flex">
                            <a href="<?= base_url('admin/categorias') ?>" class="btn btn-link">Cancelar</a>
                            <button type="submit" class="btn btn-primary ms-auto">
                                <i class="ti ti-device-floppy"></i>
                                <?= isset($categoria) ? 'Atualizar' : 'Salvar' ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?= form_close() ?>
    </div>
</div>

<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" class="img-thumbnail" style="max-width: 200px;">';
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
