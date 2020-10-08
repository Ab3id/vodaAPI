<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use phpseclib\Crypt\RSA;


class VodaApiController extends Controller
{
    // private $generated_key = "D2X3VV7whFQDrF1i/m4jaD+H6nyUm7bCxnjo6uJu3Q9iOBGa9+vhavaFUlAoCkukTNb/MvKY+hOGiECQQpZpQ9AGlJUx6mN9Ch5t0dXcrDscmetCdaxuHiPBel3t8uW6DXpj+LZJ60fmh4Ew6Qq89B5fJFbug5uvCFw18EEOxI0QbyJ66lK6f5oaRIVnaX5BtkZ8h0CwewnPgx/Uabuht6r2YTkw9IYOH+F+92c0+4Ls5cGAzciQo0MjGhsRyu6z+lSnfaC2EcON9WYATUgK2Sf+nFvPZr5Wl6HMpLX5QrwIbGvqs8dTTswY6ujh3TwoZWOHxrmuhlw0X19MGH170X3PI8IDDncm5MzvWXKvf7/7pqa4M4zA2Oy25mf1qpOyMaWyWqOG2WRtw8+Ei+x+/2rK96qB+Gdm6thCzSy/N7dZ9e8WCVJ9lwuuI1TpE7pbRw05uEJM/kiKMmPVtfX+LaIKYgaHXhjQAn6W5RqyhaDbiH2QKSgH+7VMaIh12taOHWnMfsjyVOyOhloXOfH3mmmkmQWB+SEQJ0qH1zTIZ1DwJEUJoRgkJBGe8t296zGJ6o4BC52CA1TWvYOTl7X6RdWRnBke/3fct7lEt3/+54tM90dkQh5fqwv0Rg2J0TFr3BaAXVFXkhdmuiNXYjVCZAKFEDNJwfzxlQu/CAI8SVo=D2X3VV7whFQDrF1i/m4jaD+H6nyUm7bCxnjo6uJu3Q9iOBGa9+vhavaFUlAoCkukTNb/MvKY+hOGiECQQpZpQ9AGlJUx6mN9Ch5t0dXcrDscmetCdaxuHiPBel3t8uW6DXpj+LZJ60fmh4Ew6Qq89B5fJFbug5uvCFw18EEOxI0QbyJ66lK6f5oaRIVnaX5BtkZ8h0CwewnPgx/Uabuht6r2YTkw9IYOH+F+92c0+4Ls5cGAzciQo0MjGhsRyu6z+lSnfaC2EcON9WYATUgK2Sf+nFvPZr5Wl6HMpLX5QrwIbGvqs8dTTswY6ujh3TwoZWOHxrmuhlw0X19MGH170X3PI8IDDncm5MzvWXKvf7/7pqa4M4zA2Oy25mf1qpOyMaWyWqOG2WRtw8+Ei+x+/2rK96qB+Gdm6thCzSy/N7dZ9e8WCVJ9lwuuI1TpE7pbRw05uEJM/kiKMmPVtfX+LaIKYgaHXhjQAn6W5RqyhaDbiH2QKSgH+7VMaIh12taOHWnMfsjyVOyOhloXOfH3mmmkmQWB+SEQJ0qH1zTIZ1DwJEUJoRgkJBGe8t296zGJ6o4BC52CA1TWvYOTl7X6RdWRnBke/3fct7lEt3/+54tM90dkQh5fqwv0Rg2J0TFr3BaAXVFXkhdmuiNXYjVCZAKFEDNJwfzxlQu/CAI8SVo=";

    private $APIKEY = "";
    private $publicKey = "MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEArv9yxA69XQKBo24BaF/D+fvlqmGdYjqLQ5WtNBb5tquqGvAvG3WMFETVUSow/LizQalxj2ElMVrUmzu5mGGkxK08bWEXF7a1DEvtVJs6nppIlFJc2SnrU14AOrIrB28ogm58JjAl5BOQawOXD5dfSk7MaAA82pVHoIqEu0FxA8BOKU+RGTihRU+ptw1j4bsAJYiPbSX6i71gfPvwHPYamM0bfI4CmlsUUR3KvCG24rB6FNPcRBhM3jDuv8ae2kC33w9hEq8qNB55uw51vK7hyXoAa+U7IqP1y6nBdlN25gkxEA8yrsl1678cspeXr+3ciRyqoRgj9RD/ONbJhhxFvt1cLBh+qwK2eqISfBb06eRnNeC71oBokDm3zyCnkOtMDGl7IvnMfZfEPFCfg5QgJVk1msPpRvQxmEsrX9MQRyFVzgy2CWNIb7c+jPapyrNwoUbANlN8adU1m6yOuoX7F49x+OjiG2se0EJ6nafeKUXw/+hiJZvELUYgzKUtMAZVTNZfT8jjb58j8GVtuS+6TM2AutbejaCV84ZK58E2CRJqhmjQibEUO6KPdD7oTlEkFy52Y1uOOBXgYpqMzufNPmfdqqqSM4dU70PO8ogyKGiLAIxCetMjjm6FCMEA3Kc8K0Ig7/XtFm9By6VxTJK1Mg36TlHaZKP6VzVLXMtesJECAwEAAQ==";
  
    public function GenerateSessionKey()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Origin' => '*'
        ])->withToken($this->create_bearer_token($this->APIKEY))->get("https://openapi.m-pesa.com/sandbox/ipg/v2/vodacomTZN/getSession/");
        $session_id = $response['output_SessionID'];
        return $session_id;
    }

    function create_bearer_token($apiKEY) {
		// Need to do these lines to create a 'valid' formatted RSA key for the openssl library
        $rsa = new RSA();
		$rsa->loadKey($this->publicKey);
		$rsa->setPublicKey($this->publicKey);
		
		$publickey = $rsa->getPublicKey();
		$api_encrypted = '';
		$encrypted = '';
		
		if (openssl_public_encrypt($apiKEY, $encrypted, $publickey)) {
			$api_encrypted = base64_encode($encrypted);
        }
		return $api_encrypted;
    }
    
    function SendUSSDPUSH(){
        $token = $this->create_bearer_token($this->GenerateSessionKey());
        sleep(30);
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Origin' => '*',
        ])->withToken($token)
        ->post("https://openapi.m-pesa.com/sandbox/ipg/v2/vodacomTZN/c2bPayment/singleStage/",[
            'input_Amount' => 2030,
            'input_Country' => 'TZN',
            'input_Currency' => 'TZS',
            'input_CustomerMSISDN' => '255766303775',
            'input_ServiceProviderCode' => '000000',
            'input_ThirdPartyConversationID' => 'rerekf',
            'input_TransactionReference' => 'odfdferre',
            'input_PurchasedItemsDesc' => 'Test Two Item'
        ]);
        echo $response->body();
    }
   
}
