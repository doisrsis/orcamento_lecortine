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
        <h2><i class="ti ti-moon"></i> Deseja Blackout?</h2>
        <p class="text-muted mb-4">Forro blackout com 80% de vedação de luz</p>

        <form method="post">
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card blackout-card" data-blackout="sim" style="cursor: pointer; border: 3px solid #e0e0e0; border-radius: 15px;">
                        <div class="card-body text-center p-4">
                            <i class="ti ti-moon-stars" style="font-size: 64px; color: var(--primary-color);"></i>
                            <h4 class="mt-3 mb-3">Sim, quero Blackout</h4>
                            <p class="text-muted">Bloqueio de 80% da luz para melhor conforto</p>
                            <div class="mt-3">
                                <?php
                                $valor_blackout = match($dados['faixa_largura']) {
                                    'ate_2m' => 250.00,
                                    'ate_3m' => 300.00,
                                    'ate_4m' => 360.00,
                                    'ate_5m' => 395.00,
                                    default => 0
                                };
                                ?>
                                <span class="badge bg-primary">+ R$ <?= number_format($valor_blackout, 2, ',', '.') ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card blackout-card" data-blackout="nao" style="cursor: pointer; border: 3px solid #e0e0e0; border-radius: 15px;">
                        <div class="card-body text-center p-4">
                            <i class="ti ti-sun" style="font-size: 64px; color: var(--secondary-color);"></i>
                            <h4 class="mt-3 mb-3">Não, obrigado</h4>
                            <p class="text-muted">Continuar sem o forro blackout</p>
                            <div class="mt-3">
                                <span class="badge bg-secondary">Sem custo adicional</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" name="blackout" id="blackout" required>

            <div class="alert alert-info">
                <i class="ti ti-info-circle"></i>
                <strong>Sobre o Blackout:</strong> O forro blackout é ideal para quartos, home theaters e ambientes que necessitam de maior controle de luminosidade.
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="<?= base_url('orcamento/etapa6') ?>" class="btn btn-secondary btn-lg">
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
.blackout-card:hover {
    border-color: var(--primary-color) !important;
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    transition: all 0.3s;
}

.blackout-card.selected {
    border-color: var(--primary-color) !important;
    background: linear-gradient(135deg, rgba(139, 69, 19, 0.05), rgba(210, 105, 30, 0.05));
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const blackoutCards = document.querySelectorAll('.blackout-card');
    const blackoutInput = document.getElementById('blackout');
    const btnProximo = document.getElementById('btn-proximo');
    
    blackoutCards.forEach(function(card) {
        card.addEventListener('click', function() {
            // Remover seleção
            blackoutCards.forEach(function(c) {
                c.classList.remove('selected');
            });
            
            // Adicionar seleção
            this.classList.add('selected');
            
            const blackout = this.getAttribute('data-blackout');
            blackoutInput.value = blackout;
            btnProximo.disabled = false;
        });
    });
});
</script>
