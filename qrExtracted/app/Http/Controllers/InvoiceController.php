<?php

namespace App\Http\Controllers;

use App\Services\Facades\InvoiceService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function __invoke()
    {
        return response()
            ->streamDownload(
                callback: function (): void {
                    echo InvoiceService::createInvoiceAsPdf();
                },
                name: 'invoice.pdf'
            );
    }
}
