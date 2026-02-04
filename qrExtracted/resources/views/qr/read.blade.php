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
                    <form action="{{ route('qr.decode') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Upload d'imatge -->
                        <div class="mb-4">
                            <label for="qr_image" class="form-label">
                                <i class="bi bi-image"></i> Selecciona una imatge amb QR
                            </label>
                            <input 
                                class="form-control @error('qr_image') is-invalid @enderror" 
                                type="file" 
                                id="qr_image" 
                                name="qr_image"
                                accept="image/*"
                                required
                            >
                            @error('qr_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Formats acceptats: PNG, JPG, JPEG, GIF</div>
                        </div>

                        <!-- Preview de la imatge -->
                        <div class="mb-4" id="preview-container" style="display: none;">
                            <label class="form-label">Vista prèvia:</label>
                            <div class="text-center">
                                <img id="preview-image" src="" alt="Preview" class="img-fluid border p-2" style="max-height: 300px;">
                            </div>
                        </div>

                        <!-- Botons -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ url('/') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Tornar
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-search"></i> Llegir QR
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Resultat -->
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

@push('scripts')
<script>
    // Preview de la imatge
    document.getElementById('qr_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
                document.getElementById('preview-container').style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });

    // Copiar al portapapers
    function copyToClipboard() {
        const text = "{{ session('decoded_content') }}";
        navigator.clipboard.writeText(text).then(function() {
            alert('Text copiat al portapapers!');
        });
    }
</script>
@endpush
@endsection
