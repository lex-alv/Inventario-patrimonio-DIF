@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 text-center">
                    <h5 class="mb-1 fw-bold text-dark d-flex align-items-center justify-content-center">
                        <i class="bi bi-qr-code-scan me-2" style="color: var(--gov-primary);"></i>Lector de Inventario Patrimonial
                    </h5>
                    <div class="small text-muted">Escanea la etiqueta oficial QR adherida al activo mueble</div>
                </div>

                <div class="card-body p-4 text-center">

                    <!-- Selector de Cámara (Visible si hay múltiples cámaras disponibles) -->
                    <div id="camera-select-group" class="mb-3 d-none text-start">
                        <label for="cameraSelect" class="form-label">
                            <i class="bi bi-camera-video me-1"></i>Seleccionar Cámara de Entrada:
                        </label>
                        <select id="cameraSelect" class="form-select form-select-sm"></select>
                    </div>

                    <!-- Contenedor del visor de la cámara -->
                    <div class="scanner-container position-relative mx-auto rounded overflow-hidden bg-dark shadow-sm"
                        style="max-width: 420px; min-height: 300px; aspect-ratio: 4/3; border: 2px solid var(--gov-border-strong);">

                        <!-- Elemento donde Html5Qrcode renderiza el video de la cámara -->
                        <div id="reader" style="width: 100%; height: 100%;"></div>

                        <!-- Marco visual de escaneo con animación -->
                        <div id="scanner-overlay" class="scanner-overlay d-none">
                            <div class="scanner-laser"></div>
                            <div class="scanner-corners"></div>
                        </div>

                        <!-- Indicador de carga inicial -->
                        <div id="camera-loading" class="position-absolute top-50 start-50 translate-middle text-white text-center w-100 px-3">
                            <div class="spinner-border text-light mb-2" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <p class="small mb-0 text-white-50">Iniciando sensor óptico...</p>
                        </div>
                    </div>

                    <!-- Estado de detección -->
                    <div id="scan-status" class="alert alert-info py-2 small mt-3 mb-0 text-start">
                        <i class="bi bi-info-circle me-1"></i> Conceda permisos de cámara en el navegador para comenzar el escaneo del código QR.
                    </div>

                    <!-- Búsqueda manual alternativa -->
                    <div class="mt-4 pt-3 border-top text-start">
                        <label for="manualInput" class="form-label">
                            <i class="bi bi-keyboard me-1"></i>Ingreso Manual de Número de Inventario:
                        </label>
                        <div class="input-group">
                            <input type="text" id="manualInput" class="form-control font-mono-num text-uppercase"
                                placeholder="Ej. SMDIF-2026-0001">
                            <button class="btn btn-primary px-3" type="button" id="manualBtn">
                                <i class="bi bi-search me-1"></i>Buscar Ficha
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Estilos personalizados para el visor de escaneo -->
    <style>
        .scanner-container {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #0F172A !important;
        }
        #reader {
            width: 100% !important;
            height: 100% !important;
            border: none !important;
        }
        #reader video {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            display: block !important;
        }
        #reader__scan_region {
            min-height: auto !important;
        }
        .scanner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .scanner-laser {
            position: absolute;
            left: 10%;
            right: 10%;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gov-accent-teal), #67e8f9, var(--gov-accent-teal), transparent);
            box-shadow: 0 0 8px rgba(13, 148, 136, 0.8);
            animation: laserScan 2.5s infinite ease-in-out;
        }
        @keyframes laserScan {
            0% { top: 15%; }
            50% { top: 85%; }
            100% { top: 15%; }
        }
        .scanner-corners {
            width: 70%;
            height: 70%;
            border: 2px solid rgba(255, 255, 255, 0.5);
            border-radius: 6px;
            position: relative;
        }
    </style>

    <!-- Biblioteca html5-qrcode -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusDiv = document.getElementById('scan-status');
            const loadingDiv = document.getElementById('camera-loading');
            const overlayDiv = document.getElementById('scanner-overlay');
            const cameraSelectGroup = document.getElementById('camera-select-group');
            const cameraSelect = document.getElementById('cameraSelect');
            const manualInput = document.getElementById('manualInput');
            const manualBtn = document.getElementById('manualBtn');

            let html5QrCode = null;
            let isScanning = false;

            function buscarActivo(numeroInventario) {
                if (!numeroInventario) return;
                window.location.href = "{{ route('bienes.buscar') }}?numero=" + encodeURIComponent(numeroInventario.trim());
            }

            function onScanSuccess(decodedText, decodedResult) {
                if (!isScanning) return;
                isScanning = false;

                statusDiv.className = "alert alert-success py-2 small mt-3 mb-0 text-start";
                statusDiv.innerHTML = `<i class="bi bi-check-circle-fill me-1"></i> ¡Código detectado: <strong class="font-mono-num">${decodedText}</strong>! Redirigiendo a ficha...`;

                // Detener la cámara antes de redirigir
                if (html5QrCode) {
                    html5QrCode.stop().then(() => {
                        buscarActivo(decodedText);
                    }).catch(() => {
                        buscarActivo(decodedText);
                    });
                } else {
                    buscarActivo(decodedText);
                }
            }

            function onScanFailure(error) {
                // Errores normales por fotograma sin QR presente
            }

            function iniciarStream(cameraIdOrConfig) {
                html5QrCode = new Html5Qrcode("reader");

                const config = {
                    fps: 15,
                    qrbox: function(viewfinderWidth, viewfinderHeight) {
                        const minEdge = Math.min(viewfinderWidth, viewfinderHeight);
                        const edge = Math.floor(minEdge * 0.7);
                        return { width: edge, height: edge };
                    },
                    aspectRatio: 4/3
                };

                html5QrCode.start(
                    cameraIdOrConfig,
                    config,
                    onScanSuccess,
                    onScanFailure
                ).then(() => {
                    isScanning = true;
                    loadingDiv.classList.add('d-none');
                    overlayDiv.classList.remove('d-none');
                    statusDiv.className = "alert alert-success py-2 small mt-3 mb-0 text-start";
                    statusDiv.innerHTML = '<i class="bi bi-camera-video me-1"></i> Cámara activa. Apunta hacia el código QR impreso en el bien.';
                }).catch(err => {
                    loadingDiv.classList.add('d-none');
                    isScanning = false;
                    console.error("Error al iniciar cámara:", err);
                    statusDiv.className = "alert alert-danger py-2 small mt-3 mb-0 text-start";
                    statusDiv.innerHTML = `<i class="bi bi-exclamation-triangle-fill me-1"></i> No se pudo iniciar la cámara: <strong>${err}</strong>. Verifique los permisos del navegador o ingrese el código manualmente.`;
                });
            }

            function startCamera(cameraIdOrConfig) {
                loadingDiv.classList.remove('d-none');
                overlayDiv.classList.add('d-none');

                if (html5QrCode && isScanning) {
                    html5QrCode.stop().then(() => {
                        iniciarStream(cameraIdOrConfig);
                    }).catch(() => {
                        iniciarStream(cameraIdOrConfig);
                    });
                } else {
                    iniciarStream(cameraIdOrConfig);
                }
            }

            // Detectar cámaras disponibles
            Html5Qrcode.getCameras().then(devices => {
                if (devices && devices.length > 0) {
                    if (devices.length > 1) {
                        cameraSelectGroup.classList.remove('d-none');
                        cameraSelect.innerHTML = '';
                        devices.forEach((device, index) => {
                            const option = document.createElement('option');
                            option.value = device.id;
                            option.text = device.label || `Cámara ${index + 1}`;
                            cameraSelect.appendChild(option);
                        });

                        cameraSelect.addEventListener('change', function () {
                            startCamera(this.value);
                        });
                    }

                    let preferredCamera = devices[0].id;
                    const backCam = devices.find(d => 
                        d.label.toLowerCase().includes('back') || 
                        d.label.toLowerCase().includes('trasera') || 
                        d.label.toLowerCase().includes('environment')
                    );
                    if (backCam) {
                        preferredCamera = backCam.id;
                        if (cameraSelect) cameraSelect.value = backCam.id;
                    }

                    startCamera(preferredCamera);
                } else {
                    startCamera({ facingMode: "environment" });
                }
            }).catch(err => {
                startCamera({ facingMode: "environment" });
            });

            // Búsqueda manual
            manualBtn.addEventListener('click', function () {
                buscarActivo(manualInput.value);
            });

            manualInput.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    buscarActivo(manualInput.value);
                }
            });
        });
    </script>
@endsection