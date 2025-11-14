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
        <h2><i class="ti ti-ruler"></i> Qual a Largura?</h2>
        <p class="text-muted mb-4">Produto: <strong><?= $produto->nome ?></strong></p>

        <form method="post">
            <!-- Seleção de Faixa -->
            <div class="mb-4">
                <label class="form-label">Escolha a faixa de largura *</label>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card faixa-card" data-faixa="ate_2m" style="cursor: pointer; border: 2px solid #e0e0e0;">
                            <div class="card-body text-center">
                                <h4>Até 2,00m</h4>
                                <?php if($produto->id == 1): ?>
                                    <p class="text-success mb-0"><strong>R$ 442,00</strong></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card faixa-card" data-faixa="ate_3m" style="cursor: pointer; border: 2px solid #e0e0e0;">
                            <div class="card-body text-center">
                                <h4>Até 3,00m</h4>
                                <?php if($produto->id == 1): ?>
                                    <p class="text-success mb-0"><strong>R$ 585,00</strong></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card faixa-card" data-faixa="ate_4m" style="cursor: pointer; border: 2px solid #e0e0e0;">
                            <div class="card-body text-center">
                                <h4>Até 4,00m</h4>
                                <?php if($produto->id == 1): ?>
                                    <p class="text-success mb-0"><strong>R$ 824,00</strong></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card faixa-card" data-faixa="ate_5m" style="cursor: pointer; border: 2px solid #e0e0e0;">
                            <div class="card-body text-center">
                                <h4>Até 5,00m</h4>
                                <?php if($produto->id == 1): ?>
                                    <p class="text-success mb-0"><strong>R$ 1.192,00</strong></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card faixa-card" data-faixa="maior_5m" style="cursor: pointer; border: 2px solid #e0e0e0;">
                            <div class="card-body text-center">
                                <h4>Maior que 5,00m</h4>
                                <p class="text-warning mb-0"><strong>Consultoria Personalizada</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="faixa_largura" id="faixa_largura" required>
            </div>

            <!-- Largura Exata -->
            <div id="largura-exata-container" style="display: none;">
                <div class="mb-4">
                    <label class="form-label">Informe a largura exata (em metros) *</label>
                    <div class="input-group input-group-lg">
                        <input type="number" name="largura_exata" id="largura_exata" class="form-control" 
                               step="0.01" min="0.1" placeholder="Ex: 2.50">
                        <span class="input-group-text">metros</span>
                    </div>
                    <small class="text-muted">Informe a medida exata da sua janela/ambiente</small>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="<?= base_url('orcamento/etapa4') ?>" class="btn btn-secondary btn-lg">
                    <i class="ti ti-arrow-left me-2"></i> Voltar
                </a>
                <button type="submit" class="btn btn-primary btn-lg" id="btn-proximo" disabled>
                    Próximo <i class="ti ti-arrow-right ms-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.faixa-card:hover {
    border-color: var(--primary-color) !important;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: all 0.3s;
}

.faixa-card.selected {
    border-color: var(--primary-color) !important;
    background: linear-gradient(135deg, rgba(139, 69, 19, 0.05), rgba(210, 105, 30, 0.05));
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const faixaCards = document.querySelectorAll('.faixa-card');
    const faixaInput = document.getElementById('faixa_largura');
    const larguraExataContainer = document.getElementById('largura-exata-container');
    const larguraExataInput = document.getElementById('largura_exata');
    const btnProximo = document.getElementById('btn-proximo');
    const form = document.querySelector('form');
    
    faixaCards.forEach(function(card) {
        card.addEventListener('click', function() {
            // Remover seleção
            faixaCards.forEach(function(c) {
                c.classList.remove('selected');
            });
            
            // Adicionar seleção
            this.classList.add('selected');
            
            const faixa = this.getAttribute('data-faixa');
            faixaInput.value = faixa;
            
            if (faixa === 'maior_5m') {
                // Submeter direto para consultoria
                form.submit();
            } else {
                larguraExataContainer.style.display = 'block';
                larguraExataInput.required = true;
                larguraExataInput.focus();
            }
        });
    });
    
    larguraExataInput.addEventListener('input', function() {
        if (this.value) {
            btnProximo.disabled = false;
        } else {
            btnProximo.disabled = true;
        }
    });
});
</script>
