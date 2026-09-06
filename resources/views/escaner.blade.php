@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 text-center border-bottom">
                    <h5 class="mb-1 fw-bold text-dark">
                        <i class="bi bi-qr-code-scan me-2 text-primary"></i>Lector de Inventario Patrimonial
                    </h5>
                    <small class="text-muted">Escanea la etiqueta QR adherida al activo mueble</small>
                </div>

                <div class="card-body p-4 text-center">

                    <!-- Selector de Cámara (Visible si hay múltiples cámaras disponibles) -->
                    <div id="camera-select-group" class="mb-3 d-none text-start">
                        <label for="cameraSelect" class="form-label small fw-bold text-muted">
                            <i class="bi bi-camera-video me-1"></i>Seleccionar Cámara:
                        </label>
                        <select id="cameraSelect" class="form-select form-select-sm"></select>
                    </div>

                    <!-- Contenedor del visor de la cámara -->
                    <div class="scanner-container position-relative mx-auto rounded-3 overflow-hidden bg-dark shadow-sm"
                        style="max-width: 420px; min-height: 320px; aspect-ratio: 4/3;">

                        <!-- Elemento donde Html5Qrcode renderiza el video de la cámara -->
                        <div id="reader" style="width: 100%; height: 100%;"></div>

                        <!-- Marco visual de escaneo con animación -->
                        <div id="scanner-overlay" class="scanner-overlay d-none">
                            <div class="scanner-laser"></div>
                            <div class="scanner-corners"></div>
                        </div>

                        <!-- Indicador de carga inicial -->
                        <div id="camera-loading" class="position-absolute top-50 start-50 translate-middle text-white text-center w-100 px-3">
                            <div class="spinner-border text-primary mb-2" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <p class="small mb-0 text-white-50">Iniciando cámara...</p>
                        </div>
                    </div>

                    <!-- Estado de detección -->
                    <div id="scan-status" class="alert alert-info py-2 small mt-3 mb-0 text-start">
                        <i class="bi bi-info-circle me-1"></i> Conceda los permisos de cámara en el navegador para comenzar a escanear.
                    </div>

                    <!-- Búsqueda manual alternativa -->
                    <div class="mt-4 pt-3 border-top text-start">
                        <label for="manualInput" class="form-label small fw-bold text-muted">
                            <i class="bi bi-keyboard me-1"></i>¿No puedes escanear? Ingresa el número de inventario:
                        </label>
                        <div class="input-group">
                            <input type="text" id="manualInput" class="form-control text-uppercase"
                                placeholder="Ej. SMDIF-SAI-2026-0001">
                            <button class="btn btn-primary px-3" type="button" id="manualBtn">
                                <i class="bi bi-search me-1"></i>Buscar
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
            background: linear-gradient(90deg, transparent, #0d6efd, #00f2fe, #0d6efd, transparent);
            box-shadow: 0 0 8px rgba(13, 110, 253, 0.8);
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
            border: 2px solid rgba(255, 255, 255, 0.4);
            border-radius: 12px;
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
                statusDiv.innerHTML = `<i class="bi bi-check-circle-fill me-1"></i> ¡Código detectado: <strong>${decodedText}</strong>! Redirigiendo...`;

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
                    statusDiv.innerHTML = '<i class="bi bi-camera-video me-1"></i> Cámara activa. Apunta hacia el código QR.';
                }).catch(err => {
                    loadingDiv.classList.add('d-none');
                    isScanning = false;
                    console.error("Error al iniciar cámara:", err);
                    statusDiv.className = "alert alert-danger py-2 small mt-3 mb-0 text-start";
                    statusDiv.innerHTML = `<i class="bi bi-exclamation-triangle-fill me-1"></i> No se pudo iniciar la cámara: <strong>${err}</strong>. Asegúrate de permitir el acceso en tu navegador o ingresa el código manualmente.`;
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
                    // Si hay múltiples cámaras, mostrar selector
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

                    // Preferir cámara trasera en dispositivos móviles si existe
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
                    // Si no hay lista explícita, intentar con facingMode
                    startCamera({ facingMode: "environment" });
                }
            }).catch(err => {
                // Si falla la enumeración previa de cámaras, intentar iniciar directamente con facingMode
                startCamera({ facingMode: "environment" });
            });

            // Búsqueda manual por botón o tecla Enter
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