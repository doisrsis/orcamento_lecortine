<div class="progress-container">
    <div class="step-progress">
        <div class="step-progress-bar"></div>
        <div class="step"><div class="step-circle">1</div><div class="step-label">Dados</div></div>
        <div class="step"><div class="step-circle">2</div><div class="step-label">Atendimento</div></div>
        <div class="step"><div class="step-circle">3</div><div class="step-label">Produto</div></div>
        <div class="step"><div class="step-circle">4</div><div class="step-label">Tecido</div></div>
        <div class="step"><div class="step-circle">5</div><div class="step-label">Largura</div></div>
        <div class="step"><div class="step-circle">6</div><div class="step-label">Altura</div></div>
        <div class="step"><div class="step-circle">7</div><div class="step-label">Extras</div></div>
        <div class="step"><div class="step-circle">8</div><div class="step-label">Endereço</div></div>
    </div>

    <div class="card-form">
        <h2><i class="ti ti-map-pin"></i> Endereço para Frete</h2>
        <p class="text-muted mb-4">Informe seu endereço para calcularmos o frete</p>

        <?php if(validation_errors()): ?>
            <div class="alert alert-danger"><?= validation_errors() ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">CEP *</label>
                    <input type="text" name="cep" id="cep" class="form-control mask-cep" 
                           value="<?= isset($dados['cep']) ? $dados['cep'] : set_value('cep') ?>" 
                           placeholder="00000-000" required>
                </div>
                <div class="col-md-8 mb-3">
                    <label class="form-label">Endereço *</label>
                    <input type="text" name="endereco" id="endereco" class="form-control" 
                           value="<?= isset($dados['endereco']) ? $dados['endereco'] : set_value('endereco') ?>" 
                           placeholder="Rua, Avenida..." required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Número *</label>
                    <input type="text" name="numero" class="form-control" 
                           value="<?= isset($dados['numero']) ? $dados['numero'] : set_value('numero') ?>" 
                           placeholder="123" required>
                </div>
                <div class="col-md-5 mb-3">
                    <label class="form-label">Complemento</label>
                    <input type="text" name="complemento" class="form-control" 
                           value="<?= isset($dados['complemento']) ? $dados['complemento'] : set_value('complemento') ?>" 
                           placeholder="Apto, Bloco...">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Bairro *</label>
                    <input type="text" name="bairro" id="bairro" class="form-control" 
                           value="<?= isset($dados['bairro']) ? $dados['bairro'] : set_value('bairro') ?>" 
                           placeholder="Bairro" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-9 mb-3">
                    <label class="form-label">Cidade *</label>
                    <input type="text" name="cidade" id="cidade" class="form-control" 
                           value="<?= isset($dados['cidade']) ? $dados['cidade'] : set_value('cidade') ?>" 
                           placeholder="Cidade" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Estado *</label>
                    <select name="estado" id="estado" class="form-select" required>
                        <option value="">UF</option>
                        <option value="SP" <?= (isset($dados['estado']) && $dados['estado'] == 'SP') ? 'selected' : '' ?>>SP</option>
                        <option value="RJ" <?= (isset($dados['estado']) && $dados['estado'] == 'RJ') ? 'selected' : '' ?>>RJ</option>
                        <option value="MG" <?= (isset($dados['estado']) && $dados['estado'] == 'MG') ? 'selected' : '' ?>>MG</option>
                        <option value="ES" <?= (isset($dados['estado']) && $dados['estado'] == 'ES') ? 'selected' : '' ?>>ES</option>
                        <option value="PR" <?= (isset($dados['estado']) && $dados['estado'] == 'PR') ? 'selected' : '' ?>>PR</option>
                        <option value="SC" <?= (isset($dados['estado']) && $dados['estado'] == 'SC') ? 'selected' : '' ?>>SC</option>
                        <option value="RS" <?= (isset($dados['estado']) && $dados['estado'] == 'RS') ? 'selected' : '' ?>>RS</option>
                    </select>
                </div>
            </div>

            <div class="alert alert-info">
                <i class="ti ti-info-circle"></i>
                <strong>Importante:</strong> O valor do frete será calculado e informado por nossa equipe via WhatsApp.
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="<?= base_url('orcamento/etapa7') ?>" class="btn btn-secondary btn-lg">
                    <i class="ti ti-arrow-left me-2"></i> Voltar
                </a>
                <button type="submit" class="btn btn-primary btn-lg">
                    Ver Resumo <i class="ti ti-arrow-right ms-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    // Máscara CEP
    $('.mask-cep').mask('00000-000');
    
    // Buscar CEP
    $('#cep').on('blur', function() {
        const cep = $(this).val().replace(/\D/g, '');
        
        if (cep.length === 8) {
            $.ajax({
                url: `https://viacep.com.br/ws/${cep}/json/`,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (!data.erro) {
                        $('#endereco').val(data.logradouro);
                        $('#bairro').val(data.bairro);
                        $('#cidade').val(data.localidade);
                        $('#estado').val(data.uf);
                        $('#numero').focus();
                    }
                }
            });
        }
    });
});
</script>
