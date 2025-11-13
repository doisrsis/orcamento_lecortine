<!-- Page header -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/colecoes') ?>">Coleções</a></li>
                        <li class="breadcrumb-item active"><?= isset($colecao) ? 'Editar' : 'Nova' ?></li>
                    </ol>
                </nav>
                <h2 class="page-title"><?= isset($colecao) ? 'Editar Coleção' : 'Nova Coleção' ?></h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <a href="<?= base_url('admin/colecoes') ?>" class="btn btn-ghost-secondary">
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
            <!-- Informações -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informações da Coleção</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label required">Nome da Coleção</label>
                            <input type="text" 
                                   name="nome" 
                                   class="form-control <?= form_error('nome') ? 'is-invalid' : '' ?>" 
                                   value="<?= set_value('nome', $colecao->nome ?? '') ?>"
                                   placeholder="Ex: Coleção Premium, Coleção Verão 2024"
                                   required>
                            <?php if (form_error('nome')): ?>
                                <div class="invalid-feedback"><?= form_error('nome') ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <textarea name="descricao" 
                                      class="form-control <?= form_error('descricao') ? 'is-invalid' : '' ?>" 
                                      rows="4"
                                      placeholder="Descrição da coleção (opcional)"><?= set_value('descricao', $colecao->descricao ?? '') ?></textarea>
                            <?php if (form_error('descricao')): ?>
                                <div class="invalid-feedback"><?= form_error('descricao') ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Imagem da Coleção</label>
                            <input type="file" 
                                   name="imagem" 
                                   class="form-control" 
                                   accept="image/*"
                                   onchange="previewImage(this, 'preview-imagem')">
                            <small class="form-hint">Recomendado: 800x600px</small>
                            
                            <div class="mt-2" id="preview-imagem">
                                <?php if (isset($colecao) && $colecao->imagem): ?>
                                    <img src="<?= base_url('uploads/colecoes/' . $colecao->imagem) ?>" 
                                         alt="<?= $colecao->nome ?>" 
                                         class="img-fluid rounded"
                                         style="max-width: 300px;">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Configurações</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label required">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="ativo" <?= set_select('status', 'ativo', (isset($colecao) && $colecao->status === 'ativo') || !isset($colecao)) ?>>Ativo</option>
                                <option value="inativo" <?= set_select('status', 'inativo', isset($colecao) && $colecao->status === 'inativo') ?>>Inativo</option>
                            </select>
                        </div>
                        
                        <?php if (isset($colecao)): ?>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">Slug (URL)</label>
                            <input type="text" 
                                   class="form-control" 
                                   value="<?= $colecao->slug ?>" 
                                   readonly>
                            <small class="form-hint">Gerado automaticamente.</small>
                        </div>
                        
                        <div class="mb-0">
                            <small class="text-secondary">
                                <strong>Criado em:</strong><br>
                                <?= date('d/m/Y H:i', strtotime($colecao->criado_em)) ?>
                            </small>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="card-footer">
                        <div class="d-flex">
                            <a href="<?= base_url('admin/colecoes') ?>" class="btn btn-link">Cancelar</a>
                            <button type="submit" class="btn btn-primary ms-auto">
                                <i class="ti ti-device-floppy"></i>
                                <?= isset($colecao) ? 'Atualizar' : 'Salvar' ?>
                            </button>
                        </div>
                    </div>
                </div>
                
                <?php if (isset($colecao)): ?>
                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Tecidos desta Coleção</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-secondary mb-2">
                            Esta coleção possui <strong><?= $colecao->total_tecidos ?? 0 ?></strong> tecido(s) cadastrado(s).
                        </p>
                        <a href="<?= base_url('admin/tecidos?colecao=' . $colecao->id) ?>" class="btn btn-primary w-100">
                            <i class="ti ti-texture"></i> Gerenciar Tecidos
                        </a>
                    </div>
                </div>
                <?php endif; ?>
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
            preview.innerHTML = '<img src="' + e.target.result + '" class="img-fluid rounded" style="max-width: 300px;">';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
