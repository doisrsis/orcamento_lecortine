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
        <h2><i class="ti ti-ruler-2"></i> Qual a Altura?</h2>
        <p class="text-muted mb-4">Largura selecionada: <strong><?= number_format($dados['largura'], 2, ',', '.') ?>m</strong></p>

        <form method="post">
            <!-- Seleção de Altura -->
            <div class="mb-4">
                <label class="form-label">Escolha a opção de altura *</label>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card altura-card" data-altura="ate_280" style="cursor: pointer; border: 2px solid #e0e0e0;">
                            <div class="card-body text-center p-4">
                                <i class="ti ti-check-circle" style="font-size: 48px; color: var(--primary-color);"></i>
                                <h4 class="mt-3">Até 2,80m</h4>
                                <p class="text-muted mb-0">Altura padrão</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card altura-card" data-altura="maior_280" style="cursor: pointer; border: 2px solid #e0e0e0;">
                            <div class="card-body text-center p-4">
                                <i class="ti ti-alert-circle" style="font-size: 48px; color: var(--secondary-color);"></i>
                                <h4 class="mt-3">Maior que 2,80m</h4>
                                <p class="text-warning mb-0"><strong>Consultoria Personalizada</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="altura_opcao" id="altura_opcao" required>
            </div>

            <!-- Altura Exata -->
            <div id="altura-exata-container" style="display: none;">
                <div class="mb-4">
                    <label class="form-label">Informe a altura exata (em metros) *</label>
                    <div class="input-group input-group-lg">
                        <input type="number" name="altura_exata" id="altura_exata" class="form-control" 
                               step="0.01" min="0.1" max="2.80" placeholder="Ex: 2.50">
                        <span class="input-group-text">metros</span>
                    </div>
                    <small class="text-muted">Máximo: 2,80m</small>
                </div>
            </div>

            <div class="alert alert-info">
                <i class="ti ti-info-circle"></i>
                <strong>Dica:</strong> Meça do teto até o chão ou conforme sua preferência de altura da cortina.
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="<?= base_url('orcamento/etapa5') ?>" class="btn btn-secondary btn-lg">
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
.altura-card:hover {
    border-color: var(--primary-color) !important;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: all 0.3s;
}

.altura-card.selected {
    border-color: var(--primary-color) !important;
    background: linear-gradient(135deg, rgba(139, 69, 19, 0.05), rgba(210, 105, 30, 0.05));
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const alturaCards = document.querySelectorAll('.altura-card');
    const alturaInput = document.getElementById('altura_opcao');
    const alturaExataContainer = document.getElementById('altura-exata-container');
    const alturaExataInput = document.getElementById('altura_exata');
    const btnProximo = document.getElementById('btn-proximo');
    const form = document.querySelector('form');
    
    alturaCards.forEach(function(card) {
        card.addEventListener('click', function() {
            // Remover seleção
            alturaCards.forEach(function(c) {
                c.classList.remove('selected');
            });
            
            // Adicionar seleção
            this.classList.add('selected');
            
            const altura = this.getAttribute('data-altura');
            alturaInput.value = altura;
            
            if (altura === 'maior_280') {
                // Submeter direto para consultoria
                form.submit();
            } else {
                alturaExataContainer.style.display = 'block';
                alturaExataInput.required = true;
                alturaExataInput.focus();
            }
        });
    });
    
    alturaExataInput.addEventListener('input', function() {
        const valor = parseFloat(this.value);
        
        if (valor > 2.80) {
            Swal.fire('Atenção', 'Para alturas acima de 2,80m, selecione a opção "Maior que 2,80m"', 'warning');
            this.value = '2.80';
        }
        
        if (this.value) {
            btnProximo.disabled = false;
        } else {
            btnProximo.disabled = true;
        }
    });
});
</script>
