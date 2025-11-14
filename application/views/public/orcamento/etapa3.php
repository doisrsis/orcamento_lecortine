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
        <h2><i class="ti ti-package"></i> Escolha o Produto</h2>
        <p class="text-muted mb-4">Selecione o tipo de cortina desejado</p>

        <?php if(isset($erro)): ?>
            <div class="alert alert-danger"><?= $erro ?></div>
        <?php endif; ?>

        <form method="post" id="form-produto">
            <input type="hidden" name="produto_id" id="produto_id" value="<?= isset($dados['produto_id']) ? $dados['produto_id'] : '' ?>">
            
            <div class="row">
                <?php foreach($produtos as $produto): ?>
                    <div class="col-md-4 mb-4">
                        <div class="product-card <?= (isset($dados['produto_id']) && $dados['produto_id'] == $produto->id) ? 'selected' : '' ?>" 
                             data-produto-id="<?= $produto->id ?>">
                            <?php if($produto->imagem_principal): ?>
                                <img src="<?= base_url('uploads/produtos/' . $produto->imagem_principal) ?>" alt="<?= $produto->nome ?>">
                            <?php else: ?>
                                <div style="width:100%;height:200px;background:linear-gradient(135deg, #f0f0f0, #e0e0e0);border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
                                    <i class="ti ti-photo" style="font-size:48px;color:#ccc;"></i>
                                </div>
                            <?php endif; ?>
                            
                            <h5 class="mb-2"><?= $produto->nome ?></h5>
                            
                            <?php if($produto->descricao_curta): ?>
                                <p class="text-muted small mb-2"><?= $produto->descricao_curta ?></p>
                            <?php endif; ?>
                            
                            <?php if($produto->preco_base > 0): ?>
                                <div class="mt-3">
                                    <span class="badge bg-success">A partir de R$ <?= number_format($produto->preco_base, 2, ',', '.') ?></span>
                                </div>
                            <?php else: ?>
                                <div class="mt-3">
                                    <span class="badge bg-warning text-dark">Sob Consulta</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="<?= base_url('orcamento/etapa2') ?>" class="btn btn-secondary btn-lg">
                    <i class="ti ti-arrow-left me-2"></i> Voltar
                </a>
                <button type="submit" class="btn btn-primary btn-lg">
                    Próximo <i class="ti ti-arrow-right ms-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.product-card {
    border: 3px solid #e0e0e0;
    border-radius: 15px;
    padding: 1.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    height: 100%;
}

.product-card:hover {
    border-color: var(--primary-color);
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.product-card.selected {
    border-color: var(--primary-color) !important;
    background: linear-gradient(135deg, rgba(139, 69, 19, 0.05), rgba(210, 105, 30, 0.05));
    box-shadow: 0 10px 30px rgba(139, 69, 19, 0.2);
}

.product-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 1rem;
}
</style>

<script>
// Usar JavaScript puro
document.addEventListener('DOMContentLoaded', function() {
    console.log('Script etapa3 carregado');
    
    const productCards = document.querySelectorAll('.product-card');
    const produtoInput = document.getElementById('produto_id');
    
    console.log('Cards encontrados:', productCards.length);
    
    productCards.forEach(function(card) {
        card.addEventListener('click', function() {
            console.log('Produto clicado:', this.getAttribute('data-produto-id'));
            
            // Remover seleção de todos
            productCards.forEach(function(c) {
                c.classList.remove('selected');
            });
            
            // Adicionar seleção no clicado
            this.classList.add('selected');
            
            // Definir valor
            const produtoId = this.getAttribute('data-produto-id');
            produtoInput.value = produtoId;
            
            console.log('Produto selecionado:', produtoId);
        });
    });
});
</script>
