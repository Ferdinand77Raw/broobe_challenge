<head>
    <title>Metrics</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<div id="metrics-search" class="container py-4 px-3 mx-auto">
    <h2>Run metrics</h2>
    <a href="{{ route('metricshistory') }}">Metric history</a>
            <form method="POST" action="{{ route('request-google') }}" id="formulario">
                @csrf <!-- Directiva Blade para protección CSRF -->
            
                <!-- Input para la URL -->
                <div class="mb-3">
                    <label for="url" class="form-label">URL:</label>
                    <input type="text" id="url" name="url" class="form-control" required>
                </div>
            
                <!-- Grupo de checkboxes para las categorías -->
                <div class="mb-3">
                    <label class="form-label">Categories:</label><br>
                    @foreach($categories as $categoria)
                        <input type="checkbox" id="categoria_{{ $categoria->id }}" name="category[]" value="{{ $categoria->id }}" class="form-check-input">
                        <label for="categoria_{{ $categoria->id }}" class="form-check-label">{{ $categoria->name }}</label><br>
                    @endforeach
                </div>
            
                <!-- Select para la estrategia -->
                <div class="mb-3">
                    <label for="estrategia" class="form-label">Strategies:</label>
                    <select id="strategies" name="strategy" class="form-select" required>
                        @foreach($strategies as $estrategia)
                            <option value="{{ $estrategia->id }}">{{ $estrategia->name }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Botón de envío -->
                <div>
                    <button class="btn btn-primary" id="getMetricsBtn" type="submit" disabled>Get metrics</button>
                </div>
                           
    <!-- Contenedor de resultados -->
    <div id="resultados-container" class="d-flex justify-content-between mt-5">
        <!-- URL -->
        <div class="metric-box" id="url-box">
            <h5>URL</h5>
            <p class="metric-score"></p>
            <div class="sk-chase" style="display: none;">
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
            </div>
        </div>
        <!-- ACCESSIBILITY -->
        <div class="metric-box" id="accessibility-box">
            <h5>ACCESSIBILITY</h5>
            <p class="metric-score"></p>
            <div class="sk-chase" style="display: none;">
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
            </div>
        </div>
        <!-- BEST PRACTICES -->
        <div class="metric-box" id="best-practices-box">
            <h5>BEST PRACTICES</h5>
            <p class="metric-score"></p>
            <div class="sk-chase" style="display: none;">
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
            </div>
        </div>
        <!-- PERFORMANCE -->
        <div class="metric-box" id="performance-box">
            <h5>PERFORMANCE</h5>
            <p class="metric-score"></p>
            <div class="sk-chase" style="display: none;">
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
            </div>
        </div>
        <!-- PWA -->
        <div class="metric-box" id="pwa-box">
            <h5>PWA</h5>
            <p class="metric-score"></p>
            <div class="sk-chase" style="display: none;">
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
            </div>
        </div>
        <!-- SEO -->
        <div class="metric-box" id="seo-box">
            <h5>SEO</h5>
            <p class="metric-score"></p>
            <div class="sk-chase" style="display: none;">
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
            </div>
        </div>
    </div>
    <!--Guardado de las búsquedas-->
                <div class="mb-3">
                    <button class="btn btn-primary" id="saveMetricRunBtn">Save Metrics Run</button>
                </div>

                <div id="mensajeGuardado" style="display: none;"><p>Metrics saved!</p></div>
                <div id="errorMsg" style="display: none;"><p>Error !</p></div>
            </form>
        </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#url').val(''); // Limpiar campo de URL
        $('input[name="category[]"]').prop('checked', false); // Desmarcar todos los checkboxes
        
        function checkFormCompletion() {
            var url = $('#url').val();
            var checkboxesChecked = $('input[name="category[]"]:checked').length > 0;

            if (url && checkboxesChecked) {
                $('#getMetricsBtn').prop('disabled', false); // Habilitar el botón
            } else {
                $('#getMetricsBtn').prop('disabled', true); // Deshabilitar el botón
            }
        }

        // Evento de cambio para el campo de URL
        $('#url').on('input', function() {
            checkFormCompletion();
        });

        // Evento de cambio para los checkboxes
        $('input[name="category[]"]').on('change', function() {
            checkFormCompletion();
        });


        $('#formulario').submit(function(event) {
            event.preventDefault();
            var url = $('#url').val();
            var categories = []; // Inicializar un array para almacenar las categorías seleccionadas
    
            $('input[name="category[]"]:checked').each(function() {
                categories.push($(this).val()); // Agregar cada categoría seleccionada al array
            });
            var strategy = $('#strategies').val(); // Obtener la estrategia seleccionada
    
            if (!url || categories === 0 || !strategy) {
            alert('Por favor, completa todos los campos antes de enviar.');
                return;
            }

            $('.sk-chase').show();

            $.ajax({
                type: 'POST',
                url: '{{ route('request-google') }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'url': url,
                    'category': categories,
                    'strategy': strategy
                },
                success: function(response) {
                    console.log(response);
                    $('.sk-chase').hide();
                    var categories = response['lighthouseResult']['categories'];
                    var resultadosContainer = $('#resultados-container');
    
                    //resultadosContainer.empty();

                    if(url != '')
                    {
                        $('#url-box .metric-score').text(url);
                    }else{
                        $('#url-box .metric-score').text("No data found");
                    }
                    if (categories['accessibility'])
                    {
                        $('#accessibility-box .metric-score').text(categories['accessibility'].score);                           
                    }else{
                        $('#accessibility-box .metric-score').text("No data found");
                    }
                    if (categories['performance'])
                    {
                        $('#performance-box .metric-score').text(categories['performance'].score);
                    }else{
                        $('#performance-box .metric-score').text("No data found")
                    }
                    if (categories['best-practices'])
                    {                           
                        $('#best-practices-box .metric-score').text(categories['best-practices'].score);
                    }else{
                        $('#best-practices-box .metric-score').text("No data found");
                    }
                    if (categories['pwa'])
                    {   
                        $('#pwa-box .metric-score').text(categories['pwa'].score);
                    }else{
                        $('#pwa-box .metric-score').text("No data found");
                    }
                    if (categories['seo'])
                    {   
                        $('#seo-box .metric-score').text(categories['seo'].score);
                    }else{
                        $('#seo-box .metric-score').text("No data found");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    
        $('#saveMetricRunBtn').click(function() {
        var url = $('#url-box .metric-score').text();
        var strategy_id = $('#strategies').val();

        // Obtener los puntajes de las categorías
        var accessibility = $('#accessibility-box .metric-score').text();
        var bestPractices = $('#best-practices-box .metric-score').text();
        var performance = $('#performance-box .metric-score').text();
        var pwa = $('#pwa-box .metric-score').text();
        var seo = $('#seo-box .metric-score').text();

        // Crear un objeto con los puntajes de las categorías
        var categories = {
            'Accessibility': accessibility,
            'Best Practices': bestPractices,
            'Performance': performance,
            'PWA': pwa,
            'SEO': seo
        };
        // Realizar la solicitud AJAX para guardar los datos en la base de datos
        $.ajax({
            type: 'POST',
            url: '{{ route('store-metrics') }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'url': url,
                'strategy_id': strategy_id,
                'categories': categories // Pasar el objeto de categorías actualizado
            },
            success: function(response) {
                $('#mensajeGuardado').show();

                setTimeout(function() {
                        $('#mensajeGuardado').hide();
                    }, 2000);
                },
                error: function(xhr, status, error) {
                    $('#errorMsg').show();

                        setTimeout(function() {
                        $('#errorMsg').hide();
                    }, 2000);
                }
            });
        });
    });
    </script>
</html>
        

