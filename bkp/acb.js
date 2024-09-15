document.addEventListener('DOMContentLoaded', function () {
    const accessibilityBar = document.getElementById('accessibility-bar');
    const toggleButton = document.getElementById('accessibility-toggle');
    const icon = document.getElementById('toggle-icon');
    const shortcutKeys = {
        '1': 'btn-high-contrast',
        '2': 'btn-dark-mode',
        '3': 'btn-marker',
        '4': 'btn-line-guide',
        '5': 'btn-increase-font',
        '6': 'btn-decrease-font',
        '7': 'btn-reset',
        '8': 'btn-vlibras'
    };

    // Função para alternar a visibilidade da barra de acessibilidade
    toggleButton.addEventListener('click', function () {
        accessibilityBar.classList.toggle('active');
        const isActive = accessibilityBar.classList.contains('active');

        icon.classList.toggle('bi-chevron-left', isActive);
        icon.classList.toggle('bi bi-universal-access-circle', !isActive);
        this.setAttribute('aria-expanded', isActive);
    });

    // Função para adicionar a classe alt-pressed ao body ao pressionar Alt
    document.addEventListener('keydown', function (event) {
        if (event.altKey) {
            document.body.classList.add('alt-pressed');
        }
    });

    // Função para remover a classe alt-pressed do body ao soltar Alt
    document.addEventListener('keyup', function (event) {
        if (!event.altKey) {
            document.body.classList.remove('alt-pressed');
        }
    });

    // Função para executar o atalho correspondente ao pressionar Alt + número
    document.addEventListener('keydown', function (event) {
        if (event.altKey && shortcutKeys[event.key]) {
            event.preventDefault(); // Previne ações padrão
            document.getElementById(shortcutKeys[event.key]).click();
        }
    });

    // Funções de controle de acessibilidade
    document.getElementById('btn-high-contrast').addEventListener('click', function () {
        toggleButtonState('btn-high-contrast', 'high-contrast');
    });

    document.getElementById('btn-dark-mode').addEventListener('click', function () {
        toggleButtonState('btn-dark-mode', 'dark-mode');
    });

    document.getElementById('btn-marker').addEventListener('click', function () {
        toggleMarker();
    });

    document.getElementById('btn-line-guide').addEventListener('click', function () {
        toggleLineGuide();
    });

    document.getElementById('btn-increase-font').addEventListener('click', function () {
        adjustFontSize(1);
        highlightFontButtons();
    });

    document.getElementById('btn-decrease-font').addEventListener('click', function () {
        adjustFontSize(-1);
        highlightFontButtons();
    });

    document.getElementById('btn-reset').addEventListener('click', function () {
        document.body.classList.remove('high-contrast', 'dark-mode', 'marker-active', 'line-guide-active');
        resetFontSize();
        resetButtonStates();
        clearMarker();
        clearLineGuide();
    });

    // Função para iniciar o VLibras dentro da barra lateral
    document.getElementById('btn-vlibras').addEventListener('click', function () {
        const vlibrasContainer = document.getElementById('vlibras-container');

        if (!vlibrasContainer.hasChildNodes()) {
            const script = document.createElement('script');
            script.src = "https://vlibras.gov.br/app/vlibras-plugin.js";
            script.onload = function() {
                new window.VLibras.Widget('https://vlibras.gov.br/app', vlibrasContainer);
            };
            vlibrasContainer.appendChild(script);
            vlibrasContainer.style.display = 'block';
        } else {
            vlibrasContainer.classList.toggle('hidden');
        }
    });

    function adjustFontSize(step) {
        const elements = document.querySelectorAll('body, body *:not(script):not(style)');
        elements.forEach(function (el) {
            const currentSize = window.getComputedStyle(el).getPropertyValue('font-size');
            const newSize = parseFloat(currentSize) + step;
            el.style.fontSize = newSize + 'px';
        });
    }

    function resetFontSize() {
        const elements = document.querySelectorAll('body, body *:not(script):not(style)');
        elements.forEach(function (el) {
            el.style.fontSize = '';
        });
    }

    function highlightFontButtons() {
        const fontSize = parseFloat(window.getComputedStyle(document.body).getPropertyValue('font-size'));
        const defaultSize = 16;

        if (fontSize > defaultSize) {
            document.getElementById('btn-increase-font').classList.add('active');
            document.getElementById('btn-decrease-font').classList.remove('active');
        } else if (fontSize < defaultSize) {
            document.getElementById('btn-decrease-font').classList.add('active');
            document.getElementById('btn-increase-font').classList.remove('active');
        } else {
            document.getElementById('btn-increase-font').classList.remove('active');
            document.getElementById('btn-decrease-font').classList.remove('active');
        }
    }

    function resetButtonStates() {
        document.querySelectorAll('.accessibility-btn').forEach(function (button) {
            button.classList.remove('active');
        });
    }

    function toggleMarker() {
        const button = document.getElementById('btn-marker');
        const isActive = button.classList.toggle('active');
        
        if (isActive) {
            document.body.addEventListener('mouseover', applyMarker);
        } else {
            document.body.removeEventListener('mouseover', applyMarker);
            clearMarker();
        }
    }

    function applyMarker(event) {
        clearMarker();
        const element = event.target;

        if (element.nodeType === Node.ELEMENT_NODE && element.tagName.match(/^(P|SPAN|LI|H[1-6])$/i)) {
            element.classList.add('marker-active');
        }
    }

    function clearMarker() {
        document.querySelectorAll('.marker-active').forEach(function (el) {
            el.classList.remove('marker-active');
        });
    }

    function toggleLineGuide() {
        const button = document.getElementById('btn-line-guide');
        const isActive = button.classList.toggle('active');

        if (isActive) {
            document.body.addEventListener('mousemove', applyLineGuide);
            createLineGuide();
        } else {
            document.body.removeEventListener('mousemove', applyLineGuide);
            clearLineGuide();
        }
    }

    function createLineGuide() {
        const line = document.createElement('div');
        line.id = 'line-guide';
        line.style.position = 'fixed';
        line.style.left = '0';
        line.style.right = '0';
        line.style.height = '5px';
        line.style.backgroundColor = 'red';
        line.style.zIndex = '10000';
        document.body.appendChild(line);
    }

    function applyLineGuide(event) {
        const line = document.getElementById('line-guide');
        line.style.top = `${event.clientY}px`;
    }

    function clearLineGuide() {
        const line = document.getElementById('line-guide');
        if (line) line.remove();
    }

    function toggleButtonState(buttonId, className) {
        const button = document.getElementById(buttonId);
        button.classList.toggle('active');
        document.body.classList.toggle(className);
    }
});
// Atualizações

document.getElementById('btn-blind').addEventListener('click', function () {
    toggleScreenReader();
});

document.getElementById('btn-eye-low-vision').addEventListener('click', function () {
    toggleLowVisionMode();
});

document.getElementById('btn-daltonismo').addEventListener('click', function () {
    toggleDaltonismoMode();
});

document.getElementById('btn-epilepsia').addEventListener('click', function () {
    toggleEpilepsyMode();
});

document.getElementById('btn-tdah').addEventListener('click', function() {
    alert('Perfil TDAH ativado.');
    toggleReadingMask(true);
    toggleReadingGuide(true);
  });

document.getElementById('btn-dislexia').addEventListener('click', function () {
    toggleDyslexiaMode();
});
// Atualizações recentes daqui para baixo

// Função para ativar o perfil de Cego com leitura de tela
function toggleScreenReader() {
    alert('Leitor de tela ativado.');
    // Código para ativar leitor de tela
}

// Função para Baixa Visão
function toggleLowVisionMode() {
    document.body.classList.toggle('underline-links');
    document.body.classList.toggle('zoomed');
    document.body.classList.toggle('high-saturation');
}

// Função para Daltonismo
function toggleDaltonismoMode() {
    document.body.classList.toggle('high-contrast-light');
    document.body.classList.toggle('high-saturation');
}

// Função para Epilepsia
function toggleEpilepsyMode() {
    document.body.classList.toggle('low-saturation');
    document.body.classList.toggle('no-animation');
    muteAllSounds(); // função para desativar sons
}

// Função para TDAH
function toggleTDAHMode() {
    document.body.classList.toggle('no-animation');
    document.body.classList.toggle('reader-mask');
    document.body.classList.toggle('focus-links'); // Adiciona sublinhado a links
}

// Função para Dislexia
function toggleDyslexiaMode() {
    document.body.classList.toggle('dyslexia-font');
    document.body.classList.toggle('underline-links');
}
// Funções auxiliares
function toggleZoom(enable) {
    document.body.classList.toggle('zoomed', enable);
  }
  
  function toggleContrast(type) {
    document.body.classList.remove('high-contrast-dark', 'high-contrast-light');
    document.body.classList.add(type === 'dark' ? 'high-contrast-dark' : 'high-contrast-light');
  }
  
  function toggleSaturation(level) {
    document.body.classList.remove('high-saturation', 'low-saturation');
    document.body.classList.add(level === 'high' ? 'high-saturation' : 'low-saturation');
  }
  
  function toggleReadingMask(enable) {
    document.getElementById('reader-mask').classList.toggle('hidden', !enable);
  }
  
  function toggleReadingGuide(enable) {
    document.getElementById('reading-guide').classList.toggle('hidden', !enable);
  }
  
  function toggleKeyboardNav(enable) {
    if (enable) {
        document.querySelectorAll('button, a, input').forEach(el => el.classList.add('keyboard-nav'));
    } else {
        document.querySelectorAll('.keyboard-nav').forEach(el => el.classList.remove('keyboard-nav'));
    }
  }
  
  function toggleUnderline(enable) {
    document.body.classList.toggle('underline-links', enable);
    document.body.classList.toggle('underline-titles', enable);
  }
  
  function blockAnimations(enable) {
    if (enable) {
        document.querySelectorAll('*').forEach(el => {
            const style = getComputedStyle(el);
            if (style.animation) {
                el.style.animation = 'none';
            }
        });
    }
  }