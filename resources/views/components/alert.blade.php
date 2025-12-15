{{-- SUCESSO MANUAL APÓS UMA AÇÃO (ex: cadastro, edição, exclusão) --}}
@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                title: "Pronto!",
                html: "{!! session('success') !!}",
                icon: "success"
            });
        });
    </script>
@endif

{{-- ERRO MANUAL PARA UM ERRO ESPECÍFICO (ex: e-mails duplicados) --}}
@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                title: "Erro!",
                html: `{!! session('error') !!}`,
                icon: "error"
            });
        });
    </script>
@endif

{{-- ERRO DE VALIDAÇÃO AUTOMÁTICA PARA VARIOS ERROS --}}
@if ($errors->any())
    @php
        $message = '';
        foreach ($errors->all() as $error) {
            $message .= $error . '<br>';
        }
    @endphp

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                title: "Erro!",
                html: `{!! $message !!}`,
                icon: "error"
            });
        });
    </script>
@endif

