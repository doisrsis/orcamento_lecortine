<div class="progress-container">
    <!-- Barra de Progresso -->
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

    <!-- Formulário -->
    <div class="card-form">
        <h2><i class="ti ti-user"></i> Seus Dados</h2>
        <p class="text-muted mb-4">Preencha seus dados para iniciar o orçamento</p>

        <?php if(validation_errors()): ?>
            <div class="alert alert-danger">
                <?= validation_errors() ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nome Completo *</label>
                    <input type="text" name="nome" class="form-control" 
                           value="<?= isset($dados['nome']) ? $dados['nome'] : set_value('nome') ?>" 
                           placeholder="Digite seu nome completo" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">E-mail *</label>
                    <input type="email" name="email" class="form-control" 
                           value="<?= isset($dados['email']) ? $dados['email'] : set_value('email') ?>" 
                           placeholder="seu@email.com" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Telefone *</label>
                    <input type="text" name="telefone" class="form-control mask-phone" 
                           value="<?= isset($dados['telefone']) ? $dados['telefone'] : set_value('telefone') ?>" 
                           placeholder="(00) 0000-0000" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">WhatsApp *</label>
                    <input type="text" name="whatsapp" class="form-control mask-cel" 
                           value="<?= isset($dados['whatsapp']) ? $dados['whatsapp'] : set_value('whatsapp') ?>" 
                           placeholder="(00) 00000-0000" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-9 mb-3">
                    <label class="form-label">Cidade *</label>
                    <input type="text" name="cidade" class="form-control" 
                           value="<?= isset($dados['cidade']) ? $dados['cidade'] : set_value('cidade') ?>" 
                           placeholder="Sua cidade" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Estado *</label>
                    <select name="estado" class="form-select" required>
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

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    Próximo <i class="ti ti-arrow-right ms-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>
