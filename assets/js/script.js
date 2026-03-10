document.addEventListener('DOMContentLoaded', function() {
    const countrySelect = document.getElementById('country-select');
    const loadingDiv = document.getElementById('loading');
    const resultsDiv = document.getElementById('results');
    const errorDiv = document.getElementById('error');
    const citiesTbody = document.getElementById('cities-tbody');
    const selectedCountrySpan = document.getElementById('selected-country');
    const totalCitiesSpan = document.getElementById('total-cities');
    const maxCitySpan = document.getElementById('max-city');
    const maxPopulationSpan = document.getElementById('max-population');

    countrySelect.addEventListener('change', function() {
        const countryCode = this.value;
        const countryName = this.options[this.selectedIndex].text;
        
        if (!countryCode) {
            resultsDiv.style.display = 'none';
            return;
        }
        
        // Mostrar loading
        loadingDiv.style.display = 'flex';
        resultsDiv.style.display = 'none';
        errorDiv.style.display = 'none';
        selectedCountrySpan.textContent = countryName;
        
        // Petición AJAX
        fetch(`index.php?action=getCities&country_code=${countryCode}`)
            .then(response => {
                if (!response.ok) throw new Error('Error en la respuesta');
                return response.json();
            })
            .then(data => {
                loadingDiv.style.display = 'none';
                
                if (data.success && data.data.length > 0) {
                    // Actualizar estadísticas
                    totalCitiesSpan.textContent = data.total;
                    maxCitySpan.textContent = data.max_city;
                    maxPopulationSpan.textContent = data.max_population;
                    
                    // Construir tabla
                    let html = '';
                    data.data.forEach((city, index) => {
                        html += `<tr>
                            <td>${index + 1}</td>
                            <td>${city.name}</td>
                            <td class="population">${city.population}</td>
                            <td class="scale scale-${city.scale_class}">${city.scale}</td>
                        </tr>`;
                    });
                    
                    citiesTbody.innerHTML = html;
                    resultsDiv.style.display = 'block';
                } else {
                    citiesTbody.innerHTML = '<tr><td colspan="4" class="text-center">No hay ciudades para mostrar</td></tr>';
                    resultsDiv.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                loadingDiv.style.display = 'none';
                errorDiv.style.display = 'block';
            });
    });
});