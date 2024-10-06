<?php

namespace App\Services;

use Exception;
use Grpc\ChannelCredentials;
use Openweathermapstore\GetWeatherDataRequest;
use Openweathermapstore\GetWeatherDataResponse;
use Openweathermapstore\OpenWeatherMapStoreServerClient;
use Psr\Log\LoggerInterface;

class WeatherStoreMapService {

    protected LoggerInterface $logger;

    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getWeatherData(): array
    {
        $client = new OpenWeatherMapStoreServerClient('store:10060', [
            'credentials' => ChannelCredentials::createInsecure(),
        ]);

        $res = [
            'data' => null,
            'error' => ''
        ];

        list($weatherResp, $status) = $client->GetWeatherData(new GetWeatherDataRequest())->wait();
        if ($status->code !== \Grpc\STATUS_OK) {
            $err = "getWeatherData failed, ".$status->details.', GRPC code: '.$status->code;
            $this->logger->error($err);
            $res['error'] = $err;
            return $res;
        }

        $data = [];
        if(!$weatherResp instanceof GetWeatherDataResponse) {
            $res['error'] = 'Weather data unavailable';
            return $res;
        }

        $res['data'] = $weatherResp;
        return $res;
    }
}
