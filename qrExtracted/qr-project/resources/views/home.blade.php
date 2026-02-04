@extends('layouts.app')

@section('title', 'Inici - QR System')

@section('content')
<div class="system-header text-center mb-4">
    <i class="bi bi-qr-code-scan" style="font-size: 3rem; color: var(--ls-blue);"></i>
    <h2 class="fw-bold text-uppercase mt-2">Sistema de Codis QR</h2>
    <p class="text-muted">Crea, llegeix i comparteix codis QR fàcilment</p>
</div>

<div class="action-grid mb-5">
    <a href="{{ route('qr.create') }}" class="action-card text-decoration-none">
        <div class="mb-3">
            <i class="bi bi-plus-circle-fill fs-1 text-primary"></i>
        </div>
        <h4 class="fw-bold">Crear Codi QR</h4>
        <p class="small text-muted">Genera codis personalitzats amb el teu text, URL o dades.</p>
        <div class="btn btn-primary btn-sm px-4">Crear Ara</div>
    </a>

    <a href="{{ route('qr.read') }}" class="action-card text-decoration-none">
        <div class="mb-3">
            <i class="bi bi-search fs-1 text-success"></i>
        </div>
        <h4 class="fw-bold">Llegir Codi QR</h4>
        <p class="small text-muted">Escaneja i descodifica codis QR des d'imatges.</p>
        <div class="btn btn-success btn-sm px-4">Llegir Ara</div>
    </a>
</div>

<div class="p-4 bg-light rounded-4 shadow-sm">
    <h5 class="fw-bold mb-4 text-center">
        <i class="bi bi-info-circle me-2"></i>Com funciona?
    </h5>
    <div class="row g-4 text-center">
        <div class="col-12 col-md-4">
            <div class="mb-2">
                <i class="bi bi-1-circle-fill text-primary fs-4"></i>
            </div>
            <h6 class="fw-bold">Crea</h6>
            <p class="small text-muted mb-0">Introdueix el text o URL i genera el teu codi.</p>
        </div>
        <div class="col-12 col-md-4">
            <div class="mb-2">
                <i class="bi bi-2-circle-fill text-success fs-4"></i>
            </div>
            <h6 class="fw-bold">Comparteix</h6>
            <p class="small text-muted mb-0">Descarrega o envia el codi QR per correu.</p>
        </div>
        <div class="col-12 col-md-4">
            <div class="mb-2">
                <i class="bi bi-3-circle-fill text-info fs-4"></i>
            </div>
            <h6 class="fw-bold">Llegir</h6>
            <p class="small text-muted mb-0">Escaneja amb la càmera o puja una imatge.</p>
        </div>
    </div>
</div>
@endsection