@extends('layouts.app')

@section('title', 'Llegir Codi QR')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-search"></i> Llegir Codi QR
                    </h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <p class="text-muted">Escull com vols escanejar el codi QR</p>
                    </div>

                    <!-- Botons principals -->
                    <div class="row g-3 mb-4" id="button-container">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success btn-lg w-100" onclick="openCamera()">
                                <i class="bi bi-camera-fill" style="font-size: 2rem;"></i>
                                <br>
                                <span>Obrir Càmera</span>
                                <br>
                                <small class="opacity-75">Escaneja directament</small>
                            </button>
                        </div>
                        <div class="col-md-6">
                            <label for="qr_file_input" class="btn btn-primary btn-lg w-100" style="cursor: pointer;">
                                <i class="bi bi-image-fill" style="font-size: 2rem;"></i>
                                <br>
                                <span>Seleccionar Arxiu</span>
                                <br>
                                <small class="opacity-75">Des de la galeria</small>
                            </label>
                            <input 
                                type="file" 
                                id="qr_file_input" 
                                accept="image/*" 
                                style="display: none;"
                                onchange="handleFileSelect(event)"
                            >
                        </div>
                    </div>

                    <!-- Input ocult per la càmera (mòbils) -->
                    <input 
                        type="file" 
                        id="qr_camera_input" 
                        accept="image/*" 
                        capture="environment"
                        style="display: none;"
                        onchange="handleFileSelect(event)"
                    >

                    <!-- Visor de webcam (ordinadors) -->
                    <div id="webcam-container" style="display: none;">
                        <div class="alert alert-info text-center mb-3">
                            <strong><i class="bi bi-info-circle"></i> Permisos necessaris</strong>
                            <p class="mb-0 mt-2 small">Si el navegador demana permisos per a la webcam, fes clic a "Permetre"</p>
                        </div>
                        
                        <!-- Selector de càmeres -->
                        <div id="camera-selector" class="mb-3" style="display: none;">
                            <label for="camera-select" class="form-label text-center d-block">
                                <i class="bi bi-camera"></i> Selecciona la càmera:
                            </label>
                            <select id="camera-select" class="form-select" onchange="changeCamera()">
                                <option value="">Carregant càmeres...</option>
                            </select>
                        </div>

                        <div class="text-center mb-3">
                            <p class="text-muted"><strong>Apunta la webcam al codi QR</strong></p>
                        </div>
                        <div id="webcam-reader" class="webcam-viewer"></div>
                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-danger btn-lg" onclick="stopWebcam()">
                                <i class="bi bi-stop-circle"></i> Aturar Webcam
                            </button>
                        </div>
                    </div>

                    <!-- Preview i processament -->
                    <div id="processing-area" style="display: none;">
                        <div class="text-center mb-3">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Processant...</span>
                            </div>
                            <p class="mt-2 text-muted">Processant imatge...</p>
                        </div>
                        <div class="text-center">
                            <img id="captured-image" src="" alt="Imatge capturada" class="img-fluid border p-2" style="max-height: 400px; display: none;">
                        </div>
                    </div>

                    <!-- Botó Tornar -->
                    <div class="text-center mt-4 pt-3 border-top">
                        <a href="{{ url('/') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Tornar a l'inici
                        </a>
                    </div>
                </div>
            </div>

            <!-- Resultat (es mostra quan s'escaneja) -->
            <div class="card shadow mt-4" id="result-card" style="display: none;">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-check-circle"></i> Contingut del QR
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-success mb-3">
                        <h6 class="alert-heading">
                            <i class="bi bi-info-circle"></i> Text descodificat:
                        </h6>
                        <hr>
                        <p class="mb-0" id="scanned-result" style="font-size: 1.1rem; word-break: break-all;"></p>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" onclick="copyScannedText()">
                            <i class="bi bi-clipboard"></i> Copiar al portapapers
                        </button>
                        <button class="btn btn-success" onclick="scanAgain()">
                            <i class="bi bi-arrow-clockwise"></i> Escanejar un Altre
                        </button>
                    </div>
                </div>
            </div>

            <!-- Resultat del servidor (per quan es puja arxiu) -->
            @if(session('decoded_content'))
            <div class="card shadow mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-check-circle"></i> Contingut del QR
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-success mb-3">
                        <h6 class="alert-heading">
                            <i class="bi bi-info-circle"></i> Text descodificat:
                        </h6>
                        <hr>
                        <p class="mb-0" style="font-size: 1.1rem; word-break: break-all;">
                            {{ session('decoded_content') }}
                        </p>
                    </div>
                    
                    @if(session('uploaded_image'))
                    <div class="text-center mb-3">
                        <img src="{{ Storage::url(session('uploaded_image')) }}" 
                             alt="QR Escanejat" 
                             class="img-fluid border p-2"
                             style="max-height: 300px;">
                    </div>
                    @endif

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" onclick="copyToClipboard()">
                            <i class="bi bi-clipboard"></i> Copiar al portapapers
                        </button>
                        <a href="{{ route('qr.read') }}" class="btn btn-success">
                            <i class="bi bi-arrow-clockwise"></i> Llegir un Altre
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .btn-lg {
        padding: 1.5rem;
        transition: all 0.3s ease;
    }
    
    .btn-lg:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(107, 70, 193, 0.4);
    }
    
    .btn-lg i {
        display: block;
        margin-bottom: 10px;
    }

    #captured-image {
        border: 2px solid rgba(139, 92, 246, 0.5);
        border-radius: 15px;
    }

    /* Webcam viewer */
    .webcam-viewer {
        max-width: 600px;
        margin: 0 auto;
        background: #000;
        border: 3px solid rgba(139, 92, 246, 0.8);
        border-radius: 15px;
        overflow: hidden;
        min-height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 32px rgba(107, 70, 193, 0.5);
    }

    #webcam-reader video {
        width: 100% !important;
        height: auto !important;
        border-radius: 0 !important;
        display: block !important;
    }

    #webcam-reader canvas {
        display: none !important;
    }

    #webcam-reader__dashboard {
        padding: 0 !important;
    }

    #webcam-reader__scan_region {
        border: 2px dashed #10b981 !important;
    }
</style>
@endpush

@push('scripts')
<!-- Llibreria HTML5 QR Code Scanner -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
    let html5QrcodeScanner = null;
    let availableCameras = [];
    let currentCameraId = null;

    // Detectar si és un dispositiu mòbil
    function isMobileDevice() {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    }

    // Funció principal per obrir càmera
    function openCamera() {
        if (isMobileDevice()) {
            // MÒBIL: Obrir app de càmera nativa
            document.getElementById('qr_camera_input').click();
        } else {
            // ORDINADOR: Activar webcam en temps real
            startWebcam();
        }
    }

    // Activar webcam (només ordinadors)
    function startWebcam() {
        console.log('Iniciant webcam...');
        document.getElementById('button-container').style.display = 'none';
        document.getElementById('webcam-container').style.display = 'block';
        
        // Intentar obtenir càmeres disponibles
        Html5Qrcode.getCameras().then(cameras => {
            console.log('Càmeres detectades:', cameras);
            availableCameras = cameras;
            
            if (cameras && cameras.length) {
                // Mostrar selector de càmeres si hi ha més d'una
                if (cameras.length > 1) {
                    populateCameraSelector(cameras);
                    document.getElementById('camera-selector').style.display = 'block';
                }
                
                // Filtrar càmeres virtuals i preferir càmeres USB/reals
                let selectedCameraIndex = 0;
                for (let i = 0; i < cameras.length; i++) {
                    const label = cameras[i].label.toLowerCase();
                    // Buscar càmeres USB o que continguin "webcam" i no siguin virtuals
                    if ((label.includes('usb') || label.includes('webcam')) && 
                        !label.includes('virtual') && 
                        !label.includes('obs')) {
                        selectedCameraIndex = i;
                        break;
                    }
                }
                
                currentCameraId = cameras[selectedCameraIndex].id;
                
                // Actualitzar el selector
                if (cameras.length > 1) {
                    document.getElementById('camera-select').value = currentCameraId;
                }
                
                startCameraStream(currentCameraId);
            } else {
                alert('No s\'han detectat càmeres al dispositiu.\n\nUtilitza l\'opció "Seleccionar Arxiu".');
                stopWebcam();
            }
        }).catch((err) => {
            console.error("Error obtenint càmeres:", err);
            alert("No s'ha pogut accedir a la webcam.\n\nAssegura't de:\n1. Donar permisos quan el navegador ho demani\n2. Estar en localhost o HTTPS\n3. Tenir una webcam connectada\n\nUtilitza 'Seleccionar Arxiu' com a alternativa.");
            stopWebcam();
        });
    }

    // Omplir el selector de càmeres
    function populateCameraSelector(cameras) {
        const select = document.getElementById('camera-select');
        select.innerHTML = '';
        
        cameras.forEach((camera, index) => {
            const option = document.createElement('option');
            option.value = camera.id;
            option.text = camera.label || `Càmera ${index + 1}`;
            select.appendChild(option);
        });
    }

    // Canviar de càmera
    function changeCamera() {
        const selectedCameraId = document.getElementById('camera-select').value;
        if (selectedCameraId && selectedCameraId !== currentCameraId) {
            console.log('Canviant a càmera:', selectedCameraId);
            
            // Aturar la càmera actual
            if (html5QrcodeScanner) {
                html5QrcodeScanner.stop().then(() => {
                    html5QrcodeScanner.clear();
                    currentCameraId = selectedCameraId;
                    startCameraStream(selectedCameraId);
                }).catch(err => {
                    console.error('Error aturant càmera:', err);
                    currentCameraId = selectedCameraId;
                    startCameraStream(selectedCameraId);
                });
            } else {
                currentCameraId = selectedCameraId;
                startCameraStream(selectedCameraId);
            }
        }
    }

    // Iniciar stream de la càmera
    function startCameraStream(cameraId) {
        html5QrcodeScanner = new Html5Qrcode("webcam-reader");
        
        const config = {
            fps: 10,
            qrbox: { width: 250, height: 250 },
            aspectRatio: 1.777778  // 16:9
        };

        html5QrcodeScanner.start(
            cameraId,
            config,
            onScanSuccess,
            onScanFailure
        ).then(() => {
            console.log('Webcam iniciada correctament!');
        }).catch((err) => {
            console.error("Error iniciant webcam:", err);
            alert("Error iniciant la webcam: " + err.message + "\n\nProva amb una altra càmera o utilitza 'Seleccionar Arxiu'.");
        });
    }

    // Aturar webcam
    function stopWebcam() {
        if (html5QrcodeScanner) {
            html5QrcodeScanner.stop().then(() => {
                html5QrcodeScanner.clear();
                document.getElementById('button-container').style.display = 'flex';
                document.getElementById('webcam-container').style.display = 'none';
            }).catch(err => {
                console.error("Error aturant webcam:", err);
                document.getElementById('button-container').style.display = 'flex';
                document.getElementById('webcam-container').style.display = 'none';
            });
        } else {
            document.getElementById('button-container').style.display = 'flex';
            document.getElementById('webcam-container').style.display = 'none';
        }
    }

    // Quan es detecta un QR amb la webcam
    function onScanSuccess(decodedText, decodedResult) {
        if (navigator.vibrate) {
            navigator.vibrate(200);
        }

        stopWebcam();

        document.getElementById('scanned-result').textContent = decodedText;
        document.getElementById('result-card').style.display = 'block';
        
        setTimeout(() => {
            document.getElementById('result-card').scrollIntoView({ behavior: 'smooth' });
        }, 100);
    }

    function onScanFailure(error) {
        // Normal mentre busca el QR
    }

    // Processar imatge seleccionada (mòbil o arxiu)
    function handleFileSelect(event) {
        const file = event.target.files[0];
        if (!file) return;

        document.getElementById('processing-area').style.display = 'block';
        document.getElementById('result-card').style.display = 'none';

        const reader = new FileReader();
        reader.onload = function(e) {
            const imgElement = document.getElementById('captured-image');
            imgElement.src = e.target.result;
            imgElement.style.display = 'block';

            scanQRFromImage(file);
        };
        reader.readAsDataURL(file);
    }

    // Escanejar QR des d'una imatge
    function scanQRFromImage(imageFile) {
        const html5QrCode = new Html5Qrcode("qr-reader-temp");
        
        html5QrCode.scanFile(imageFile, true)
            .then(decodedText => {
                if (navigator.vibrate) {
                    navigator.vibrate(200);
                }

                document.getElementById('scanned-result').textContent = decodedText;
                document.getElementById('result-card').style.display = 'block';
                document.getElementById('processing-area').style.display = 'none';

                setTimeout(() => {
                    document.getElementById('result-card').scrollIntoView({ behavior: 'smooth' });
                }, 100);
            })
            .catch(err => {
                console.error('Error llegint el QR:', err);
                document.getElementById('processing-area').style.display = 'none';
                alert('No s\'ha pogut detectar cap codi QR a la imatge.\n\nAssegura\'t que:\n- La imatge contingui un codi QR visible\n- El QR estigui enfocat i ben il·luminat\n- El QR no estigui deformat');
            });
    }

    // Escanejar un altre
    function scanAgain() {
        document.getElementById('result-card').style.display = 'none';
        document.getElementById('captured-image').style.display = 'none';
        document.getElementById('qr_camera_input').value = '';
        document.getElementById('qr_file_input').value = '';
        document.getElementById('button-container').style.display = 'flex';
    }

    // Copiar text escanejat
    function copyScannedText() {
        const text = document.getElementById('scanned-result').textContent;
        navigator.clipboard.writeText(text).then(function() {
            alert('✓ Text copiat al portapapers!');
        }).catch(err => {
            console.error('Error copiant:', err);
            alert('No s\'ha pogut copiar el text');
        });
    }

    // Copiar al portapapers (per resultat del servidor)
    function copyToClipboard() {
        const text = "{{ session('decoded_content') }}";
        navigator.clipboard.writeText(text).then(function() {
            alert('✓ Text copiat al portapapers!');
        }).catch(err => {
            console.error('Error copiant:', err);
            alert('No s\'ha pogut copiar el text');
        });
    }
</script>

<!-- Element temporal per al processament -->
<div id="qr-reader-temp" style="display: none;"></div>
@endpush
@endsection
