document.addEventListener('DOMContentLoaded', function () {
    const accessibilityBar = document.getElementById('accessibility-bar');
    const toggleButton = document.getElementById('accessibility-toggle');
    const toggleIcon = document.getElementById('toggle-icon');

    toggleButton.addEventListener('click', function () {
        accessibilityBar.classList.toggle('active');
        toggleIcon.classList.toggle('bi-universal-access-circle');
        toggleIcon.classList.toggle('bi-x-circle');
    });

    document.getElementById('btn-high-contrast').addEventListener('click', function () {
        document.body.classList.toggle('high-contrast');
    });

    document.getElementById('btn-dark-mode').addEventListener('click', function () {
        document.body.classList.toggle('darkmode');
    });

    document.getElementById('btn-increase-font').addEventListener('click', function () {
        document.body.style.fontSize = 'larger';
    });

    document.getElementById('btn-decrease-font').addEventListener('click', function () {
        document.body.style.fontSize = 'smaller';
    });

    document.getElementById('btn-marker').addEventListener('click', function () {
        document.body.classList.toggle('marker-active');
    });

    document.getElementById('btn-line-guide').addEventListener('click', function () {
        document.body.classList.toggle('line-guide-active');
    });

    document.getElementById('btn-reset').addEventListener('click', function () {
        document.body.className = '';
        document.body.style.fontSize = '';
    });

    document.getElementById('btn-blind').addEventListener('click', function () {
        const textToRead = document.body.innerText;
        const speechSynthesis = window.speechSynthesis;
        const utterance = new SpeechSynthesisUtterance(textToRead);
        utterance.lang = 'pt-BR';
        speechSynthesis.speak(utterance);
    });

    document.getElementById('btn-eye-low-vision').addEventListener('click', function () {
        document.body.classList.toggle('low-vision');
    });

    document.getElementById('btn-daltonismo').addEventListener('click', function () {
        document.body.classList.toggle('high-saturation');
    });

    document.getElementById('btn-epilepsia').addEventListener('click', function () {
        document.body.classList.toggle('low-saturation');
    });

    document.getElementById('btn-tdah').addEventListener('click', function () {
        document.body.classList.toggle('no-animation');
    });

    document.getElementById('btn-dislexia').addEventListener('click', function () {
        document.body.classList.toggle('dyslexia-font');
    });

    document.getElementById('btn-vlibras').addEventListener('click', function () {
        const vlibrasContainer = document.getElementById('vlibras-container');
        vlibrasContainer.classList.toggle('hidden');
        if (!vlibrasContainer.classList.contains('hidden')) {
            // Inicializar VLibras
            new window.VLibras.Widget('vlibras-container');
        }
    });

    document.getElementById('btn-text-reader').addEventListener('click', function () {
        const textToRead = document.body.innerText;
        const speechSynthesis = window.speechSynthesis;
        const utterance = new SpeechSynthesisUtterance(textToRead);
        utterance.lang = 'pt-BR';
        speechSynthesis.speak(utterance);
    });
});
