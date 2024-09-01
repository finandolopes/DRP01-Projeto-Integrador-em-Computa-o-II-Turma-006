document.addEventListener('DOMContentLoaded', function () {
    // Variáveis para armazenar o estado atual
    let markerActive = false;
    let lineGuideActive = false;

    // Função para alternar a visibilidade da barra de acessibilidade
    document.getElementById('accessibility-toggle').addEventListener('click', function () {
        const bar = document.getElementById('accessibility-bar');
        const icon = document.getElementById('toggle-icon');

        bar.classList.toggle('hidden');  // Alterna a classe 'hidden'

        if (bar.classList.contains('hidden')) {
            icon.classList.remove('bi-chevron-left');
            icon.classList.add('bi-universal-access');
        } else {
            icon.classList.remove('bi-universal-access');
            icon.classList.add('bi-chevron-left');
        }
    });

    // Função para alternar o alto contraste
    document.getElementById('btn-high-contrast').addEventListener('click', function () {
        document.body.classList.toggle('high-contrast');
    });

    // Função para alternar o modo escuro
    document.getElementById('btn-dark-mode').addEventListener('click', function () {
        document.body.classList.toggle('dark-mode');
    });

    // Função para aumentar a fonte
    document.getElementById('btn-increase-font').addEventListener('click', function () {
        adjustFontSize(1);
    });

    // Função para diminuir a fonte
    document.getElementById('btn-decrease-font').addEventListener('click', function () {
        adjustFontSize(-1);
    });

    // Função para ativar/desativar o marcador
    document.getElementById('btn-marker').addEventListener('click', function () {
        markerActive = !markerActive;
    });

    // Função para ativar/desativar a linha guia
    document.getElementById('btn-line-guide').addEventListener('click', function () {
        lineGuideActive = !lineGuideActive;
    });

    // Event listener para aplicar marcador e linha guia
    document.body.addEventListener('mousemove', function (event) {
        const element = event.target;

        if (markerActive) {
            clearMarker();
            element.classList.add('marker-active');
        }

        if (lineGuideActive) {
            clearLineGuide();
            element.classList.add('line-guide-active');
        }
    });

    // Função para limpar o marcador
    function clearMarker() {
        const markedElements = document.querySelectorAll('.marker-active');
        markedElements.forEach(function (el) {
            el.classList.remove('marker-active');
        });
    }

    // Função para limpar a linha guia
    function clearLineGuide() {
        const guidedElements = document.querySelectorAll('.line-guide-active');
        guidedElements.forEach(function (el) {
            el.classList.remove('line-guide-active');
        });
    }

    // Função para redefinir todas as alterações
    document.getElementById('btn-reset').addEventListener('click', function () {
        document.body.classList.remove('high-contrast', 'dark-mode');
        markerActive = false;
        lineGuideActive = false;
        clearMarker();
        clearLineGuide();
        resetFontSize();
    });

    // Função para ajustar o tamanho da fonte
    function adjustFontSize(step) {
        const elements = document.querySelectorAll('body, body *');
        elements.forEach(function (el) {
            const currentSize = window.getComputedStyle(el, null).getPropertyValue('font-size');
            const newSize = parseFloat(currentSize) + step;
            el.style.fontSize = newSize + 'px';
        });
    }

    // Função para redefinir o tamanho da fonte
    function resetFontSize() {
        const elements = document.querySelectorAll('body, body *');
        elements.forEach(function (el) {
            el.style.fontSize = '';
        });
    }

    /* Função para iniciar o Vlibras dentro da barra lateral
    document.getElementById('btn-vlibras').addEventListener('click', function () {
        const vlibrasContainer = document.getElementById('vlibras-container');
    
        // Verifica se o VLibras já foi carregado
        if (!vlibrasContainer.hasChildNodes()) {
            const script = document.createElement('script');
            script.src = "https://vlibras.gov.br/app/vlibras-plugin.js";
            script.onload = function() {
                new window.VLibras.Widget('https://vlibras.gov.br/app', vlibrasContainer);
            };
            vlibrasContainer.appendChild(script);
        } else {
            // Alterna a visibilidade do VLibras
            vlibrasContainer.classList.toggle('hidden');
        }
    });
