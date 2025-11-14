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
        <h2><i class="ti ti-texture"></i> Escolha o Tecido e Cor</h2>
        <p class="text-muted mb-4">Produto selecionado: <strong><?= $produto->nome ?></strong></p>

        <?php if(isset($erro)): ?>
            <div class="alert alert-danger"><?= $erro ?></div>
        <?php endif; ?>

        <form method="post" id="form-tecido">
            <div class="mb-4">
                <label class="form-label">Tecido/Coleção *</label>
                <select name="tecido_id" id="tecido_id" class="form-select form-select-lg" required>
                    <option value="">Selecione o tecido...</option>
                    <?php foreach($tecidos as $tecido): ?>
                        <option value="<?= $tecido->id ?>" 
                                data-colecao="<?= $tecido->colecao_nome ?>"
                                <?= (isset($dados['tecido_id']) && $dados['tecido_id'] == $tecido->id) ? 'selected' : '' ?>>
                            <?= $tecido->nome ?> - <?= $tecido->colecao_nome ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <small class="text-muted">Escolha o tipo de tecido para sua cortina</small>
            </div>

            <div id="cores-container" style="display: none;">
                <label class="form-label">Cor *</label>
                <p class="text-muted small mb-3">Clique na cor desejada</p>
                <div class="row" id="cores-list">
                    <!-- Cores serão carregadas via AJAX -->
                </div>
                <input type="hidden" name="cor_id" id="cor_id" value="<?= isset($dados['cor_id']) ? $dados['cor_id'] : '' ?>">
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="<?= base_url('orcamento/etapa3') ?>" class="btn btn-secondary btn-lg">
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
.cor-card {
    border: 3px solid #e0e0e0;
    border-radius: 10px;
    padding: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
}

.cor-card:hover {
    border-color: var(--primary-color);
    transform: translateY(-3px);
}

.cor-card.selected {
    border-color: var(--primary-color);
    background: rgba(139, 69, 19, 0.05);
}

.cor-preview {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    margin: 0 auto 0.5rem;
    border: 3px solid #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tecidoSelect = document.getElementById('tecido_id');
    const coresContainer = document.getElementById('cores-container');
    const coresList = document.getElementById('cores-list');
    const corInput = document.getElementById('cor_id');
    const btnProximo = document.getElementById('btn-proximo');
    
    console.log('Etapa4 carregado');
    
    // Carregar cores ao selecionar tecido
    tecidoSelect.addEventListener('change', function() {
        const tecidoId = this.value;
        console.log('Tecido selecionado:', tecidoId);
        
        if (tecidoId) {
            // Fazer requisição AJAX
            fetch('<?= base_url('orcamento/ajax_cores/') ?>' + tecidoId)
                .then(response => response.json())
                .then(cores => {
                    console.log('Cores recebidas:', cores);
                    coresList.innerHTML = '';
                    
                    if (cores.length > 0) {
                        cores.forEach(function(cor) {
                            const corCard = document.createElement('div');
                            corCard.className = 'col-md-3 col-6 mb-3';
                            corCard.innerHTML = `
                                <div class="cor-card" data-cor-id="${cor.id}">
                                    <div class="cor-preview" style="background-color: ${cor.codigo_hex}"></div>
                                    <strong class="small">${cor.nome}</strong>
                                </div>
                            `;
                            coresList.appendChild(corCard);
                        });
                        
                        coresContainer.style.display = 'block';
                        
                        // Event handler para seleção de cor
                        document.querySelectorAll('.cor-card').forEach(function(card) {
                            card.addEventListener('click', function() {
                                console.log('Cor clicada:', this.getAttribute('data-cor-id'));
                                
                                // Remover seleção
                                document.querySelectorAll('.cor-card').forEach(function(c) {
                                    c.classList.remove('selected');
                                });
                                
                                // Adicionar seleção
                                this.classList.add('selected');
                                
                                // Definir valor e habilitar botão
                                const corId = this.getAttribute('data-cor-id');
                                corInput.value = corId;
                                btnProximo.disabled = false;
                                
                                console.log('Cor selecionada:', corId);
                                console.log('Botão habilitado');
                            });
                        });
                    } else {
                        coresContainer.style.display = 'none';
                        Swal.fire('Aviso', 'Este tecido não possui cores cadastradas.', 'warning');
                    }
                })
                .catch(error => {
                    console.error('Erro ao carregar cores:', error);
                });
        } else {
            coresContainer.style.display = 'none';
            btnProximo.disabled = true;
        }
    });
    
    // Trigger change se já tiver tecido selecionado
    <?php if(isset($dados['tecido_id'])): ?>
        tecidoSelect.value = '<?= $dados['tecido_id'] ?>';
        tecidoSelect.dispatchEvent(new Event('change'));
        setTimeout(function() {
            const corCard = document.querySelector('.cor-card[data-cor-id="<?= $dados['cor_id'] ?>"]');
            if (corCard) {
                corCard.click();
            }
        }, 500);
    <?php endif; ?>
});
</script>
