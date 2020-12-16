<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\CurrencyType;

class UpdateCurrencyTypeRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:rate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update CurrencyType Rate';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $xml='<?xml version="1.0" encoding="utf-8"?>
        <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
          <soap:Body>
            <ExchangeRatesLatest xmlns="http://www.cba.am/" />
          </soap:Body>
        </soap:Envelope>';

        $response = Http::withHeaders([
            "Content-Type" => "text/xml;charset=utf-8",
            'SOAPAction'   => 'http://www.cba.am/ExchangeRatesLatest'
        ])->send("POST", "http://api.cba.am/exchangerates.asmx", [
            "body" =>  $xml
        ]);
        $response =$response->body();

        $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
        $xml = new \SimpleXMLElement($response);
        $body = $xml->xpath('//SBody');
        $rates = json_decode(json_encode((array)$xml), TRUE); 
        $rates = $rates['soapBody']['ExchangeRatesLatestResponse']['ExchangeRatesLatestResult']['Rates']['ExchangeRate'];

        $currencyTypes = CurrencyType::all();

        foreach($currencyTypes as $currencyType){
            $name = $currencyType->name;
            $rate = $this->findRate($rates,$name);
          
            if($rate){
              CurrencyType::where('name',$name)->update(['rate' =>  $rate]);
            } 

        }

       
    }


     /**
     * Find ISO rate.
     *
     * @return float
     */

    public function findRate($rates,$ISO)
    {

        foreach($rates as $rate){
            if($rate['ISO']==$ISO && $rate['Rate']){
                return  (float)$rate['Rate'];
            };
        }

        return null;

     }
}
