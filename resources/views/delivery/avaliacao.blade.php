@extends('layouts.tubarao-delivery')

@section('content')

<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

<style>
    .estrelas input[type=radio] {
    display: none;
    }
    .estrelas label i.fa:before {
    content:'\f005';
    color: #FC0;
    }
    .estrelas input[type=radio]:checked ~ label i.fa:before {
    color: #CCC;
    }
</style>
@if(!$ava->isEmpty())
    @if($ava->First()->avaliation_status == '0' || $ava->First()->avaliation_status == null)

    <section class="user-avaliacao">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 content-pesquisa">
                    <div>

                    <h2>Pesquisa de satisfação do cliente</h2>
                    <p>O que você achou dos serviços do Tubarão da Praia? Conte-nos abaixo :)</p>

                    </div>
                    <form action="/avaliacao/enviar" method="POST" id="form-avaliar" style="margin-top: 30px;">
                    <textarea name="avaliation_desc" id="" rows="5" required></textarea>
                    <div class="estrelas">
                    {{ csrf_field() }}
                        <input type="radio" id="cm_star-empty" name="avaliation_note" value="" checked/>
                        <label for="cm_star-1"><i class="fa"></i></label>
                        <input type="radio" id="cm_star-1" name="avaliation_note" value="1"/>
                        <label for="cm_star-2"><i class="fa"></i></label>
                        <input type="radio" id="cm_star-2" name="avaliation_note" value="2"/>
                        <label for="cm_star-3"><i class="fa"></i></label>
                        <input type="radio" id="cm_star-3" name="avaliation_note" value="3"/>
                        <label for="cm_star-4"><i class="fa"></i></label>
                        <input type="radio" id="cm_star-4" name="avaliation_note" value="4"/>
                        <label for="cm_star-5"><i class="fa"></i></label>
                        <input type="radio" id="cm_star-5" name="avaliation_note" value="5"/>
                    </div>
                    <input type="hidden" name="data_id" value="{{ $ava->First()->id }}">
                    <input type="button" class="btn-avaliacao" value="Avaliar">
        </form>

        @else
        <p class="avaliacao-sucesso">Avaliação realizada com sucesso, agradecemos seu contato ;)</p>
            <a href="/delivery">Fazer um pedido</a>
    @endif

    @else
    <p class="avaliacao-erro">Token de avaliação incorreto.</p>
@endif
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function(){
        $(document).on('click', '.btn-avaliacao', function(){

            if($('input[name="avaliation_note"]').is('selected') && $('textarea').val().length > 0) {
                
                $('#form-avaliar').submit();
                
                return;
            
            }

            alert('Preencha todos os campos antes de nos avaliar ;)');
        
        });
    });
</script>
@endsection