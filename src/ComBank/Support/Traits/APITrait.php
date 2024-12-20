<?php namespace ComBank\Support\Traits;

require 'c:\xampp\htdocs\M07-BackEnd\M07_UF1_Bank\vendor\autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

trait APITrait {
    public function convertBalance($balance, $originalCurrency = "EUR", $convertedCurrency = "USD") : float {
        $headers = array(
            'Accept' => 'application/json',
            'x-api-key' => 'sk_c1e7d228872048f8892955338a2e6eb1',
        );

        $client = new Client();

        // Define array of request body.
        $request_body = array(
            "amount" => $balance,
            "from" => $originalCurrency,
            "to" => $convertedCurrency
        );

        try {
            $response = $client->request('GET', 'https://api.manyapis.com/v1-convert-currency', array(
                'headers' => $headers,
                'query' => $request_body,
            ));
            
            // Decodificar el cuerpo de la respuesta y obtener el valor 'convertedAmount'
            $data = json_decode($response->getBody()->getContents(), true);
            return $data['convertedAmount'] ?? 0; // Retorna el valor o 0 si no existe
        } catch (BadResponseException $e) {
            // Maneja excepciones o errores de la API.
            print_r($e->getMessage());
            return 0; // Retorna 0 en caso de error
        }
    }
}
