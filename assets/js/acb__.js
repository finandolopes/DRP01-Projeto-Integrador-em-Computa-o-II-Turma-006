document.addEventListener('DOMContentLoaded', function () {
    let markerActive = false;
    let lineGuideActive = false;

    // Função para alternar a visibilidade da barra de acessibilidade
    document.getElementById('accessibility-toggle').addEventListener('click', function () {
        const bar = document.getElementById('accessibility-bar');
        const icon = document.getElementById('toggle-icon');

        bar.classList.toggle('hidden');
        const isHidden = bar.classList.contains('hidden');
        icon.classList.toggle('bi-chevron-left', !isHidden);
        icon.classList.toggle('bi-universal-access', isHidden);
        this.setAttribute('aria-expanded', !isHidden);
    });

    // Funções para os modos de acessibilidade
    const toggleContrast = createToggleState('contrast', 'high-contrast');
    const toggleDarkMode = createToggleState('dark', 'dark-mode');

    document.getElementById('btn-high-contrast').addEventListener('click', toggleContrast);
    document.getElementById('btn-dark-mode').addEventListener('click', toggleDarkMode);

    // Função para ajustar o tamanho da fonte
    const FontSize = createFontSizeManager();
    document.getElementById('btn-increase-font').addEventListener('click', () => FontSize.toggle('incFont'));
    document.getElementById('btn-decrease-font').addEventListener('click', () => FontSize.toggle('decFont'));
    document.getElementById('btn-reset').addEventListener('click', () => {
        FontSize.reset();
        toggleContrast(false);
        toggleDarkMode(false);
        resetMarkers();
    });

    // Função para ativar/desativar o marcador
    document.getElementById('btn-marker').addEventListener('click', function () {
        markerActive = !markerActive;
    });

    // Função para ativar/desativar a linha guia
    document.getElementById('btn-line-guide').addEventListener('click', function () {
        lineGuideActive = !lineGuideActive;
    });

    document.body.addEventListener('mousemove', function (event) {
        const element = event.target;
        if (markerActive) {
            clearMarkers();
            element.classList.add('marker-active');
        }
        if (lineGuideActive) {
            clearLineGuides();
            element.classList.add('line-guide-active');
        }
    });

    // Funções para limpar o marcador e a linha guia
    function clearMarkers() {
        document.querySelectorAll('.marker-active').forEach(el => el.classList.remove('marker-active'));
    }

    function clearLineGuides() {
        document.querySelectorAll('.line-guide-active').forEach(el => el.classList.remove('line-guide-active'));
    }

    function resetMarkers() {
        clearMarkers();
        clearLineGuides();
    }

    // Função para iniciar o Vlibras dentro da barra lateral
    document.getElementById('btn-vlibras').addEventListener('click', function () {
        const vlibrasContainer = document.getElementById('vlibras-container');
        if (!vlibrasContainer.hasChildNodes()) {
            const script = document.createElement('script');
            script.src = "https://vlibras.gov.br/app/vlibras-plugin.js";
            script.onload = function() {
                new window.VLibras.Widget('https://vlibras.gov.br/app', vlibrasContainer);
            };
            vlibrasContainer.appendChild(script);
        } else {
            vlibrasContainer.classList.toggle('hidden');
        }
    });

    // Funções Auxiliares

    function createToggleState(storageKey, cssClass) {
        const currentState = sessionStorage.getItem(storageKey) === 'true';
        if (currentState) {
            document.body.classList.add(cssClass);
        }
        return function toggleState() {
            const newState = !document.body.classList.toggle(cssClass);
            sessionStorage.setItem(storageKey, newState);
        };
    }

    function createFontSizeManager() {
        const storageKey = 'fontSizeState';
        const defaultSize = 100;
        let currentState = parseFloat(sessionStorage.getItem(storageKey)) || defaultSize;
        updateFontSize();

        function updateFontSize() {
            document.documentElement.style.fontSize = (currentState / 100) + 'em';
        }

        function setFontSize(newSize) {
            currentState = newSize;
            sessionStorage.setItem(storageKey, currentState);
            updateFontSize();
        }

        return {
            toggle(action) {
                switch (action) {
                    case 'incFont':
                        setFontSize(Math.min(currentState + 20, 200));
                        break;
                    case 'decFont':
                        setFontSize(Math.max(currentState - 20, 40));
                        break;
                    default:
                        setFontSize(defaultSize);
                        break;
                }
            },
            reset() {
                setFontSize(defaultSize);
            }
        };
    }
});
