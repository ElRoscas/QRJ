@extends('layouts.app')

@section('title', 'Factures')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="bi bi-file-earmark-text"></i> Gestió de Factures
                    </h4>
                </div>
                <div class="card-body">
                    <p class="lead">Crea factures professionals amb codis QR integrats i envia-les per correu electrònic</p>
                    
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <div class="card text-center h-100">
                                <div class="card-body">
                                    <i class="bi bi-plus-circle-fill text-warning" style="font-size: 3rem;"></i>
                                    <h5 class="card-title mt-3">Crear Factura</h5>
                                    <p class="card-text">Genera una factura personalitzada amb QR</p>
                                    <a href="{{ route('invoices.create') }}" class="btn btn-warning">
                                        <i class="bi bi-plus-circle"></i> Nova Factura
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <div class="card text-center h-100">
                                <div class="card-body">
                                    <i class="bi bi-download text-success" style="font-size: 3rem;"></i>
                                    <h5 class="card-title mt-3">Factura Demo</h5>
                                    <p class="card-text">Descarrega un exemple de factura</p>
                                    <a href="{{ route('get-invoice') }}" class="btn btn-success">
                                        <i class="bi bi-download"></i> Descarregar Demo
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="card text-center h-100">
                                <div class="card-body">
                                    <i class="bi bi-envelope text-primary" style="font-size: 3rem;"></i>
                                    <h5 class="card-title mt-3">Enviar per Email</h5>
                                    <p class="card-text">Les factures poden enviar-se automàticament</p>
                                    <button class="btn btn-primary" disabled>
                                        <i class="bi bi-info-circle"></i> Crea una factura primer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <h5 class="alert-heading">
                            <i class="bi bi-info-circle"></i> Característiques de les Factures
                        </h5>
                        <ul class="mb-0">
                            <li><strong>Codi QR Integrat:</strong> Cada factura inclou un codi QR amb el número de comanda</li>
                            <li><strong>PDF Professional:</strong> Format estàndard i professional</li>
                            <li><strong>Enviament Automàtic:</strong> Opció d'enviar per correu electrònic al client</li>
                            <li><strong>Personalitzable:</strong> Afegeix descomptes, IVA i costos d'enviament</li>
                        </ul>
                    </div>

                    <div class="alert alert-warning">
                        <strong><i class="bi bi-envelope"></i> Nota sobre correus:</strong>
                        Els correus es guarden al log per defecte. 
                        Consulta <a href="{{ asset('CONFIGURACIO-EMAIL.md') }}" target="_blank">CONFIGURACIO-EMAIL.md</a> 
                        per configurar l'enviament real de correus.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
