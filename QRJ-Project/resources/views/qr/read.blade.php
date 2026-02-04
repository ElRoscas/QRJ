<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llegir Codi QR - La Salle Mollerussa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
</head>

<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Navegació -->
        <nav class="bg-white shadow-md">
            <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">
                    <span class="text-blue-600">LA SALLE</span> MOLLERUSSA
                </h1>
                <a href="{{ route('menu_admin') }}" class="text-gray-600 hover:text-gray-800">
                    <i class="bi bi-arrow-left"></i> Tornar al Menú
                </a>
            </div>
        </nav>

        <!-- Contingut Principal -->
        <div class="max-w-4xl mx-auto p-6">
            <!-- Missatges -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <!-- Formulari -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">
                    <i class="bi bi-camera"></i> Escanejar Codi QR amb Càmera
                </h2>

                <!-- Escàner de QR amb càmera -->
                <div id="qr-reader" class="mb-4" style="width: 100%;"></div>

                <div class="flex gap-3 justify-center mb-4">
                    <button id="start-camera" onclick="startScanner()"
                        class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        <i class="bi bi-camera-fill"></i> Iniciar Càmera
                    </button>
                    <button id="stop-camera" onclick="stopScanner()" style="display: none;"
                        class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        <i class="bi bi-camera-video-off-fill"></i> Aturar Càmera
                    </button>
                </div>

                <form action="{{ route('qr.decode') }}" method="POST" id="qr-form" style="display: none;">
                    @csrf
                    <input type="hidden" id="qr_code_input" name="qr_code" value="">
                </form>

                <div class="text-center">
                    <a href="{{ route('menu_admin') }}"
                        class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition inline-block">
                        <i class="bi bi-arrow-left"></i> Tornar al Menú
                    </a>
                </div>
            </div>

            <!-- Resultat -->
            @if(session('success') && session('user_name'))
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-center">
                        @if(session('action') === 'entrar')
                            <div class="bg-green-100 border-4 border-green-500 rounded-lg p-8 mb-4">
                                <i class="bi bi-check-circle-fill text-green-600" style="font-size: 4rem;"></i>
                                <h3 class="text-3xl font-bold text-green-700 mt-4">
                                    El <span class="text-green-800">{{ session('user_name') }}</span> pot ENTRAR
                                </h3>
                                <p class="text-green-600 text-xl mt-2">
                                    <i class="bi bi-box-arrow-in-right"></i> Estat: DINS
                                </p>
                            </div>
                        @else
                            <div class="bg-blue-100 border-4 border-blue-500 rounded-lg p-8 mb-4">
                                <i class="bi bi-check-circle-fill text-blue-600" style="font-size: 4rem;"></i>
                                <h3 class="text-3xl font-bold text-blue-700 mt-4">
                                    El <span class="text-blue-800">{{ session('user_name') }}</span> pot SORTIR
                                </h3>
                                <p class="text-blue-600 text-xl mt-2">
                                    <i class="bi bi-box-arrow-right"></i> Estat: FORA
                                </p>
                            </div>
                        @endif

                        <a href="{{ route('qr.read') }}"
                            class="px-8 py-3 bg-green-600 text-white text-lg rounded-lg hover:bg-green-700 transition inline-block">
                            <i class="bi bi-arrow-repeat"></i> Escanejar un Altre
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        let html5QrCode;
        let isScanning = false;

        function startScanner() {
            const qrReader = document.getElementById("qr-reader");

            if (isScanning) {
                return;
            }

            html5QrCode = new Html5Qrcode("qr-reader");

            html5QrCode.start(
                { facingMode: "environment" }, // Càmera posterior
                {
                    fps: 10,
                    qrbox: { width: 250, height: 250 }
                },
                (decodedText, decodedResult) => {
                    // QR detectat!
                    document.getElementById('qr_code_input').value = decodedText;

                    // Aturar escàner
                    stopScanner();

                    // Enviar formulari
                    document.getElementById('qr-form').submit();
                },
                (errorMessage) => {
                    // Error de lectura (normal mentre busca QR)
                }
            ).then(() => {
                isScanning = true;
                document.getElementById('start-camera').style.display = 'none';
                document.getElementById('stop-camera').style.display = 'inline-block';
            }).catch((err) => {
                console.error('Error iniciant càmera:', err);
                alert('No s\'ha pogut accedir a la càmera. Assegura\'t de donar permisos.');
            });
        }

        function stopScanner() {
            if (html5QrCode && isScanning) {
                html5QrCode.stop().then(() => {
                    isScanning = false;
                    document.getElementById('start-camera').style.display = 'inline-block';
                    document.getElementById('stop-camera').style.display = 'none';
                }).catch((err) => {
                    console.error('Error aturant càmera:', err);
                });
            }
        }

        // Aturar càmera quan es tanca la pàgina
        window.addEventListener('beforeunload', () => {
            stopScanner();
        });
    </script>
</body>

</html>