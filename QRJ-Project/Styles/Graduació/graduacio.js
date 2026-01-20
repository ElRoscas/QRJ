// Funció que s'executa quan s'escaneja un codi correctament
function onScanSuccess(decodedText, decodedResult) {
    const resultContainer = document.getElementById('qr-result');
    resultContainer.innerHTML = `
        <span style="color: #28a745; display: block;">✓ ACCÉS PERMÈS</span>
        <span style="font-size: 0.75rem; color: #555;">ID: ${decodedText}</span>
    `;
    
    // Incrementar comptador visual (Exemple)
    const qrCount = document.getElementById('count-qr');
    qrCount.innerText = parseInt(qrCount.innerText) + 1;
    
    console.log(`Codi escanejat: ${decodedText}`);
}

function onScanFailure(error) {
    // No fem res en cas de fallada per no saturar la consola
}

// Inicialització del lector QR
let html5QrcodeScanner = new Html5QrcodeScanner(
    "qr-reader", 
    { 
        fps: 15, 
        qrbox: { width: 200, height: 200 },
        aspectRatio: 1.0 
    }, 
    false
);
html5QrcodeScanner.render(onScanSuccess, onScanFailure);

// Generador d'estrelles ambiental
window.addEventListener('load', () => {
    const container = document.getElementById('starContainer');
    if (container) {
        for (let i = 0; i < 20; i++) {
            const star = document.createElement('div');
            star.innerHTML = '★';
            star.className = 'bg-star';
            star.style.left = Math.random() * 100 + '%';
            star.style.top = Math.random() * 100 + '%';
            star.style.fontSize = (Math.random() * 20 + 10) + 'px';
            container.appendChild(star);
        }
    }
});