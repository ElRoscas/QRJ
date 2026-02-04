@extends('layouts.app')

@section('title', 'Crear Codi QR')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-plus-circle"></i> Crear Codi QR
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('qr.store') }}" method="POST">
                        @csrf
                        
                        <!-- Text/URL del QR -->
                        <div class="mb-4">
                            <label for="qr_content" class="form-label">
                                <i class="bi bi-text-paragraph"></i> Contingut del QR
                            </label>
                            <textarea 
                                class="form-control @error('qr_content') is-invalid @enderror" 
                                id="qr_content" 
                                name="qr_content" 
                                rows="4" 
                                placeholder="Introdueix text, URL, número de comanda, etc."
                                required
                            >{{ old('qr_content') }}</textarea>
                            @error('qr_content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Aquest text serà codificat en el codi QR</div>
                        </div>

                        <!-- Mida del QR -->
                        <div class="mb-4">
                            <label for="size" class="form-label">
                                <i class="bi bi-arrows-angle-expand"></i> Mida del QR
                            </label>
                            <select class="form-select" id="size" name="size">
                                <option value="200" {{ old('size') == '200' ? 'selected' : '' }}>Petita (200x200)</option>
                                <option value="300" {{ old('size', '300') == '300' ? 'selected' : '' }}>Mitjana (300x300)</option>
                                <option value="400" {{ old('size') == '400' ? 'selected' : '' }}>Gran (400x400)</option>
                                <option value="500" {{ old('size') == '500' ? 'selected' : '' }}>Extra Gran (500x500)</option>
                            </select>
                        </div>

                        <!-- Email (opcional) -->
                        <div class="mb-4">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope"></i> Enviar per correu (opcional)
                            </label>
                            <input 
                                type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                placeholder="exemple@correu.com"
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Si introdueixes un correu, s'enviarà el codi QR automàticament</div>
                        </div>

                        <!-- Botons -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ url('/') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Tornar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-qr-code"></i> Generar QR
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Preview Section (si hi ha QR generat) -->
            @if(session('qr_image'))
            <div class="card shadow mt-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-check-circle"></i> QR Generat
                    </h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="data:image/png;base64,{{ session('qr_image') }}" 
                             alt="QR Code" 
                             class="img-fluid border p-2"
                             style="max-width: 400px;">
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="data:image/png;base64,{{ session('qr_image') }}" 
                           download="qr-code.png" 
                           class="btn btn-success">
                            <i class="bi bi-download"></i> Descarregar PNG
                        </a>
                        <a href="{{ route('qr.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg"></i> Crear un Altre
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
