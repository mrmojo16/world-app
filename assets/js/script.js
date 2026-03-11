document.addEventListener('DOMContentLoaded', function() {
    console.log("✅ Script cargado con Bootstrap");
    
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
        loadingDiv.style.display = 'block';
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
                
                if (data.success && data.data && data.data.length > 0) {
                    // Actualizar estadísticas
                    totalCitiesSpan.textContent = data.total;
                    maxCitySpan.textContent = data.max_city;
                    maxPopulationSpan.textContent = data.max_population;
                    
                    // Construir tabla con Bootstrap
                    let html = '';
                    data.data.forEach((city, index) => {
                        let scaleClass = 'scale-low';
                        if (city.scale_class === 'high') scaleClass = 'scale-high';
                        else if (city.scale_class === 'medium') scaleClass = 'scale-medium';
                        
                        html += `<tr>
                            <td class="fw-bold">${index + 1}</td>
                            <td>${city.name}</td>
                            <td class="fw-semibold">${city.population}</td>
                            <td><span class="badge ${scaleClass} p-2 w-100">${city.scale}</span></td>
                        </tr>`;
                    });
                    
                    citiesTbody.innerHTML = html;
                    resultsDiv.style.display = 'block';
                } else {
                    citiesTbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-4"><i class="bi bi-inbox"></i> No hay ciudades para mostrar</td></tr>';
                    resultsDiv.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                loadingDiv.style.display = 'none';
                errorDiv.style.display = 'block';
                errorDiv.innerHTML = `<i class="bi bi-exclamation-triangle"></i> Error: ${error.message}`;
            });
    });
});