
    @include('layouts.head')

    @include('layouts.header')


    
    <div style="display:none;" id="div-loading" class="loading"><span>
            <div class="loader"></div>
        </span></div>
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P6QLJZP" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

    @yield("content")

</body>
@yield("footer-scripts")

</div>

<footer>
    Desenvolvido pela <a href="https://www.otimaideia.com.br">Ótima Ideia</a>
</footer>

<?php   if(isset($_GET['pesquisa-input'])){  ?>

    
    <script>

        function geraSlug(string){

            return  string.toString().toLowerCase()
            .replace(/[àÀáÁâÂãäÄÅåª]+/g, 'a')       // Special Characters #1
            .replace(/[èÈéÉêÊëË]+/g, 'e')       	// Special Characters #2
            .replace(/[ìÌíÍîÎïÏ]+/g, 'i')       	// Special Characters #3
            .replace(/[òÒóÓôÔõÕöÖº]+/g, 'o')       	// Special Characters #4
            .replace(/[ùÙúÚûÛüÜ]+/g, 'u')       	// Special Characters #5
            .replace(/[ýÝÿŸ]+/g, 'y')       		// Special Characters #6
            .replace(/[ñÑ]+/g, 'n')       			// Special Characters #7
            .replace(/[çÇ]+/g, 'c')       			// Special Characters #8
            .replace(/[ß]+/g, 'ss')       			// Special Characters #9
            .replace(/[Ææ]+/g, 'ae')       			// Special Characters #10
            .replace(/[Øøœ]+/g, 'oe')       		// Special Characters #11
            .replace(/[%]+/g, 'pct')       			// Special Characters #12
            .replace(/\s+/g, '-')           		// Replace spaces with -
            .replace(/[^\w\-]+/g, '')       		// Remove all non-word chars
            .replace(/\-\-+/g, '-')         		// Replace multiple - with single -
            .replace(/^-+/, '')             		// Trim - from start of text
            .replace(/-+$/, '');            		// Trim - from end of text
            
	};

        
    function limparParametros (){

        
        let botaoLimpar = document.querySelector('.form-pesquisar-limpar');

        botaoLimpar.addEventListener('click', ()=>{

            window.location.href = 'https://pedidos.tubaraodapraia.com.br/delivery'

        })
    }

    limparParametros()

    function pesquisa(){

        let formulario = document.querySelector('#produtos');
        window.$_GET = new URLSearchParams(location.search);
        let value = $_GET.get('pesquisa-input');
        let value1 = geraSlug(value);


        formulario.value = value1

        let produtos = document.querySelectorAll('.item-p')
        let subtitle = document.querySelectorAll('h2')
        

        if(formulario.value.length > 0){

        subtitle.forEach( e => e.style.display = 'none')

        produtos.forEach((el, i)=>{
            
            el.style.display = 'none'

            if(el.getAttribute('pesquisa').includes(formulario.value))
                el.style.display = 'flex'

        })

        }
        else{

            subtitle.forEach( e => e.style.display = 'block')
            produtos.forEach((el, i)=>{

                el.style.display = 'flex'
            })



        }


    }

    pesquisa();



    </script>


<?php } ?>

</body>

</html>