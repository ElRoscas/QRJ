@extends('layouts.app')

@section('title', 'Inici - QR System')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="container text-center">
        <h1 class="display-3 display-md-2 mb-4">
            <i class="bi bi-qr-code-scan"></i> Sistema de Codis QR
        </h1>
        <p class="lead fs-4 fs-md-3">Crea, llegeix i comparteix codis QR fàcilment</p>
    </div>
</div>

<!-- Features -->
<div class="container mb-5">
    <div class="row g-4 justify-content-center">
        <!-- Card 1: Crear QR -->
        <div class="col-12 col-sm-10 col-md-6 col-lg-5">
            <div class="card qr-card h-100 text-center">
                <div class="card-body p-4 p-md-5">
                    <div class="mb-4">
                        <i class="bi bi-plus-circle-fill text-primary" style="font-size: 4.5rem;"></i>
                    </div>
                    <h4 class="card-title mb-3">Crear Codi QR</h4>
                    <p class="card-text mb-4 fs-6">Genera codis QR personalitzats amb el teu text, URL o dades.</p>
                    <a href="{{ route('qr.create') }}" class="btn btn-primary btn-lg px-4">
                        <i class="bi bi-plus-lg"></i> Crear Ara
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 2: Llegir QR -->
        <div class="col-12 col-sm-10 col-md-6 col-lg-5">
            <div class="card qr-card h-100 text-center">
                <div class="card-body p-4 p-md-5">
                    <div class="mb-4">
                        <i class="bi bi-search text-success" style="font-size: 4.5rem;"></i>
                    </div>
                    <h4 class="card-title mb-3">Llegir Codi QR</h4>
                    <p class="card-text mb-4 fs-6">Escaneja i descodifica codis QR des d'imatges.</p>
                    <a href="{{ route('qr.read') }}" class="btn btn-success btn-lg px-4">
                        <i class="bi bi-search"></i> Llegir Ara
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Info Section -->
<div class="container">
    <div class="row">
        <div class="col-12 col-lg-10 col-xl-8 mx-auto">
            <div class="card">
                <div class="card-body p-4 p-md-5">
                    <h3 class="card-title mb-4 mb-md-5">
                        <i class="bi bi-info-circle"></i> Com funciona?
                    </h3>
                    <div class="row g-4">
                        <div class="col-12 col-md-6 col-lg-4">
                            <h5 class="mb-3"><i class="bi bi-1-circle-fill text-primary"></i> Crea</h5>
                            <p class="mb-0">Introdueix el text o URL i genera el teu codi QR personalitzat.</p>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <h5 class="mb-3"><i class="bi bi-2-circle-fill text-success"></i> Comparteix</h5>
                            <p class="mb-0">Descarrega o envia el codi QR per correu electrònic.</p>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <h5 class="mb-3"><i class="bi bi-3-circle-fill text-info"></i> Llegeix</h5>
                            <p class="mb-0">Puja una imatge amb un codi QR per descodificar-la.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
