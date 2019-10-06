<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;


class IEXController extends Controller
{
    public function welcomeENV()
    {
      $apikey = config('app.name');
      return $apiKey;
    }
    public function getSymbols()
    {
      $client = new Client(['base_uri' => 'https://api.iextrading.com/']);
      $req = $client->request('GET','1.0/ref-data/symbols');

      $res = json_decode((string) $req->getBody(), true);

      $symbols = '<option>--Select Company--</option>';
      foreach ($res as $value) {
        if($value['isEnabled'] == true) {
          $symbols .= '<option value="'.$value['symbol'].'">'.$value['symbol'].' - '.$value['name'].'</option>';
        }
      }

      return $symbols;
    }

    public function getTimeSeries($symbol)
    {
      $client = new Client(['base_uri' => "https://investors-exchange-iex-trading.p.rapidapi.com/stock/"]);
      $req = $client->request('GET',$symbol.'/time-series',[
        'headers' => [
          'X-RapidAPI-Host' => 'investors-exchange-iex-trading.p.rapidapi.com',
          'X-RapidAPI-Key' => 'a87b025783msh27c9984bcc2c9e6p138316jsn6fa1d61b9315',
        ]
      ]);

      $res = json_decode((string) $req->getBody(), true);

      $timeseries = [];
      foreach ($res as $value) {
        $timeseries[] = [
          Carbon::parse($value['date'])->format('d M Y'),
          $value['low'],
          $value['open'],
          $value['close'],
          $value['high'],
        ];
      }

      return $timeseries;
    }

    public function getEffectiveSpread($symbol)
    {
      $client = new Client(['base_uri' => "https://investors-exchange-iex-trading.p.rapidapi.com/stock/"]);
      $req = $client->request('GET',$symbol.'/effective-spread',[
        'headers' => [
          'X-RapidAPI-Host' => 'investors-exchange-iex-trading.p.rapidapi.com',
          'X-RapidAPI-Key' => 'a87b025783msh27c9984bcc2c9e6p138316jsn6fa1d61b9315',
        ]
      ]);

      $res = json_decode((string) $req->getBody(), true);

      $es_array = [];
      foreach ($res as $value) {
        $es_array[] = [
          'venue' => $value['venue'],
          'venueName' => $value['venueName'],
          'volume' => $value['volume'],
          'es' => $value['effectiveSpread'],
          'eq' => $value['effectiveQuoted'],
          'pi' => $value['priceImprovement'],
        ];
      }

      return $es_array;
    }
}
