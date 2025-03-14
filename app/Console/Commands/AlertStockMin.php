<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\produit;
use Illuminate\Support\Facades\Mail;
use App\Mail\AlertMail;

class AlertStockMin extends Command
{
    protected $signature = 'produits:check-min-stock';

    protected $description = 'Envoi d\'un Mail Automatiquement lorsque le stock d\'un produit arrive au min stock !';

    public function handle()
    {
        $produits = produit::where('stock','<=',10)->get();
        $email = "khadijasahnoun70@gmail.com";

        foreach($produits as $produit){
            Mail::to($email)->send(new AlertMail($produit->nom,$produit->stock));
        }

        $this->info("Mail d'alerte du Stock Minimale est envoyés !");
    }
}
