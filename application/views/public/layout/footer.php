    </div>

    <!-- Footer -->
    <footer class="mt-5 py-4" style="background: linear-gradient(135deg, #2C1810 0%, #8B4513 100%); color: #fff;">
        <div class="container text-center">
            <p class="mb-2">&copy; <?= date('Y') ?> Le Cortine - Todos os direitos reservados</p>
            <p class="mb-0">
                <small>Desenvolvido por <a href="https://doisr.com.br" target="_blank" class="text-white text-decoration-none">Rafael Dias - doisr.com.br</a></small>
            </p>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Máscaras -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Máscaras
            $('.mask-phone').mask('(00) 0000-0000');
            $('.mask-cel').mask('(00) 00000-0000');
            $('.mask-cep').mask('00000-000');
            
            // Animação de progresso
            <?php if(isset($etapa_atual) && isset($total_etapas)): ?>
                const progresso = (<?= $etapa_atual ?> / <?= $total_etapas ?>) * 100;
                $('.step-progress-bar').css('width', progresso + '%');
                
                // Marcar etapas
                $('.step').each(function(index) {
                    if (index + 1 < <?= $etapa_atual ?>) {
                        $(this).addClass('completed');
                    } else if (index + 1 === <?= $etapa_atual ?>) {
                        $(this).addClass('active');
                    }
                });
            <?php endif; ?>
        });
    </script>

</body>
</html>
