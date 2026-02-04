@extends('layouts.app')

@section('title', 'Crear Factura')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="bi bi-file-earmark-text"></i> Crear Nova Factura
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('invoices.store') }}" method="POST">
                        @csrf
                        
                        <!-- Informació del Client -->
                        <h5 class="mb-3"><i class="bi bi-person"></i> Informació del Client</h5>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="customer_name" class="form-label">Nom del Client *</label>
                                <input type="text" class="form-control @error('customer_name') is-invalid @enderror" 
                                       id="customer_name" name="customer_name" value="{{ old('customer_name', 'John Doe') }}" required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="customer_email" class="form-label">Email del Client *</label>
                                <input type="email" class="form-control @error('customer_email') is-invalid @enderror" 
                                       id="customer_email" name="customer_email" value="{{ old('customer_email', 'client@example.com') }}" required>
                                @error('customer_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Número de Comanda -->
                        <div class="mb-4">
                            <label for="order_id" class="form-label">Número de Comanda</label>
                            <input type="number" class="form-control" id="order_id" name="order_id" 
                                   value="{{ old('order_id', rand(10000, 99999)) }}">
                            <div class="form-text">Aquest número s'inclourà al codi QR</div>
                        </div>

                        <hr>

                        <!-- Producte/Servei -->
                        <h5 class="mb-3"><i class="bi bi-cart"></i> Producte/Servei</h5>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="item_title" class="form-label">Descripció *</label>
                                <input type="text" class="form-control" id="item_title" name="item_title" 
                                       value="{{ old('item_title', 'Servei Professional') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label for="price" class="form-label">Preu Unitari (€) *</label>
                                <input type="number" step="0.01" class="form-control" id="price" name="price" 
                                       value="{{ old('price', '100') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label for="quantity" class="form-label">Quantitat</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" 
                                       value="{{ old('quantity', '1') }}">
                            </div>
                        </div>

                        <!-- Descompte i Impostos -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="discount" class="form-label">Descompte (%)</label>
                                <input type="number" step="0.01" class="form-control" id="discount" name="discount" 
                                       value="{{ old('discount', '10') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="tax" class="form-label">IVA (%)</label>
                                <input type="number" step="0.01" class="form-control" id="tax" name="tax" 
                                       value="{{ old('tax', '21') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="shipping" class="form-label">Enviament (€)</label>
                                <input type="number" step="0.01" class="form-control" id="shipping" name="shipping" 
                                       value="{{ old('shipping', '0') }}">
                            </div>
                        </div>

                        <hr>

                        <!-- Opcions d'enviament -->
                        <h5 class="mb-3"><i class="bi bi-envelope"></i> Opcions d'Enviament</h5>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="send_email" name="send_email" value="1" checked>
                            <label class="form-check-label" for="send_email">
                                Enviar factura per correu electrònic al client
                            </label>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="download_pdf" name="download_pdf" value="1" checked>
                            <label class="form-check-label" for="download_pdf">
                                Descarregar PDF automàticament
                            </label>
                        </div>

                        <!-- Botons -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Tornar
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-file-earmark-text"></i> Generar Factura
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
