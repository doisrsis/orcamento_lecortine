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
        <h2><i class="ti ti-help-circle"></i> Como deseja prosseguir?</h2>
        <p class="text-muted mb-4">Escolha a melhor opção para você</p>

        <?php if(isset($erro)): ?>
            <div class="alert alert-danger"><?= $erro ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="row g-4">
                <!-- Opção 1: Fazer Orçamento -->
                <div class="col-md-6">
                    <div class="card h-100 option-card" data-option="orcamento" style="cursor: pointer; border: 3px solid #e0e0e0; border-radius: 15px; transition: all 0.3s;">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="ti ti-calculator" style="font-size: 64px; color: var(--primary-color);"></i>
                            </div>
                            <h4 class="mb-3">Fazer Meu Próprio Orçamento</h4>
                            <p class="text-muted">
                                Escolha seu produto, tecido, cor e dimensões. 
                                Receba o orçamento instantaneamente!
                            </p>
                            <div class="mt-4">
                                <span class="badge bg-success">Rápido e Prático</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Opção 2: Consultoria -->
                <div class="col-md-6">
                    <div class="card h-100 option-card" data-option="consultoria" style="cursor: pointer; border: 3px solid #e0e0e0; border-radius: 15px; transition: all 0.3s;">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="ti ti-users" style="font-size: 64px; color: var(--secondary-color);"></i>
                            </div>
                            <h4 class="mb-3">Consultoria Personalizada</h4>
                            <p class="text-muted">
                                Atendimento especializado com nossa equipe. 
                                Ideal para projetos complexos.
                            </p>
                            <div class="mt-4">
                                <span class="badge bg-primary">Atendimento VIP</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" name="tipo_atendimento" id="tipo_atendimento" value="">

            <div class="d-flex justify-content-between mt-4">
                <a href="<?= base_url('orcamento/etapa1') ?>" class="btn btn-secondary btn-lg">
                    <i class="ti ti-arrow-left me-2"></i> Voltar
                </a>
                <button type="submit" class="btn btn-primary btn-lg" id="btn-continuar" disabled>
                    Continuar <i class="ti ti-arrow-right ms-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.option-card:hover {
    border-color: var(--primary-color) !important;
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.option-card.selected {
    border-color: var(--primary-color) !important;
    background: linear-gradient(135deg, rgba(139, 69, 19, 0.05), rgba(210, 105, 30, 0.05));
}
</style>

<script>
// Usar JavaScript puro para garantir funcionamento
document.addEventListener('DOMContentLoaded', function() {
    console.log('Script etapa2 carregado');
    
    const optionCards = document.querySelectorAll('.option-card');
    const tipoInput = document.getElementById('tipo_atendimento');
    const btnContinuar = document.getElementById('btn-continuar');
    
    console.log('Cards encontrados:', optionCards.length);
    console.log('Input encontrado:', tipoInput);
    console.log('Botão encontrado:', btnContinuar);
    
    optionCards.forEach(function(card) {
        card.addEventListener('click', function() {
            console.log('Card clicado:', this.getAttribute('data-option'));
            
            // Remover seleção de todos
            optionCards.forEach(function(c) {
                c.classList.remove('selected');
            });
            
            // Adicionar seleção no clicado
            this.classList.add('selected');
            
            // Pegar valor e habilitar botão
            const option = this.getAttribute('data-option');
            tipoInput.value = option;
            btnContinuar.disabled = false;
            
            console.log('Valor definido:', option);
            console.log('Botão habilitado');
        });
    });
});
</script>
