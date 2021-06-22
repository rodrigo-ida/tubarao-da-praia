
    <header class="clearfix">
    
        <div class="container header-content">
            <h1>
                <a href="/" style="background-image: url({{ asset('/img/logo-beta.png') }});">
                    <span>Tubarão da Praia</span>
                </a>
            </h1>


        <div class="pesquisa-produtos clearfix">
            <form action="https://pedidos.tubaraodapraia.com.br/delivery" method="get" class="form-pesquisar">

                    <input placeholder="Pesquisar..." class="form-pesquisar-input-pesquisar" type="text" id="produtos" name="pesquisa-input" />
                    <input value="Pesquisar" type="submit" 
                        id="submit-pesquisar-produto" name="submit-pesquisar-produto" 
                        class="pesquisa-produto-submit-button">
                    <input type="button" value="Limpar" class="form-pesquisar-limpar" name="form-pesquisar-limpar">

            </form>
                {{-- <input class="enviar" type="button" value="Pesquisar" id='botaoPesquisarIndex' style="background-image: url({{ asset('/img/search.png') }});"> --}}
                {{-- <ul class="pesquisa-resultado" style="display: none;" onclick="kitetsu()"></ul> --}}
            </div>



            

            <div class="pesquisa-pedido clearfix">
                @if(!preg_match('/loja-/', $_SERVER['REQUEST_URI']))
                @if(Session::get('client_id') && Session::get('login_client_token') && $_SERVER['REQUEST_URI'] != '/client/area-do-cliente')
                <!-- <form action="/delivery/pedido/pesquisa" method="POST">
                <label for="pesquisa">Já fez um pedido? Consulte-o aqui!</label>
                <div class="clearfix">
                
                    {{ csrf_field() }}
                    <input placeholder="Digite seu email.." name="email" id="email" type="text"/>
                    <input class="enviar" id="pesquisar-pedido" type="submit" value="Pesquisar">
                    <a href="#" id="recu-email-show"><span class="recuperar-email">Esqueceu seu e-mail?</span></a>
                    
                </div>
                </form> -->
                <span class="profile">
                    <span class="profile-img">
                        <?php
                        $useragent = $_SERVER['HTTP_USER_AGENT'];

                        ?>

                        @if(!empty(Session::get('client_name')))
                        <span class="profile-msg">Olá, {{ Session::get('client_name') }}!</span>
                        @endif
                        <img src="{{ asset('/img/sem-foto.png') }}" height="46" width="46" alt="Foto Perfil" title="Foto Perfil">
                    </span>
                    <ul class="profile-dropdown">
                        <li>
                            <a href="{{ route('clientes.address') }}" title="Meu Perfil">
                                Alterar Endereço
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('clientes.userdata') }}" title="Meus Endereços">
                                Meus Dados
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('clientes.order') }}" title="Meu Perfil">
                                Acompanhar Pedido
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('clientes.orders') }}" title="Meu Perfil">
                                Histórico de Pedidos
                            </a>
                        </li> <br>
                        <li>
                            <a href="{{ route('clientes.logout') }}" title="Sair"><img src="{{ asset('/img/sign-out.svg') }}" alt="">
                                Sair
                            </a>
                        </li>
                    </ul>
                </span>
            </div>

            @elseif($_SERVER['REQUEST_URI'] != '/client/area-do-cliente')

            <a href="/client/area-do-cliente" class="login-link"><button class="nav-login">Faça <strong>login</strong> ou <strong>cadastre-se!</strong> </button></a>

            {{-- <i class="fa fa-search" aria-hidden="true"></i> --}}
        {{--<button class="nav-login-mobile"><i class="fa fa-sign-in" aria-hidden="true"></i></button> --}}


            @endif
            @endif
        </div>
    </header>
