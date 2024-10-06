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
     * @return string
     * @throws Exception
     */
    public function test(): string
    {
        $client = new OpenWeatherMapStoreServerClient('store:10060', [
            'credentials' => ChannelCredentials::createInsecure(),
        ]);

        list($response, $status) = $client->GetWeatherData(new GetWeatherDataRequest())->wait();
        if ($status->code !== \Grpc\STATUS_OK) {
            $err = "getWeatherData failed, ".$status->details.', GRPC code: '.$status->code;
            $this->logger->error($err);
            throw new Exception($err);
        }

        if ($response instanceof GetWeatherDataResponse) {
            echo '<pre>';
            var_dump('last updated', $response->getLastUpdated(), 'lat', $response->getLat(), 'lon', $response->getLon());
            echo '</pre>';
            return 'response OK';
        }

        return '';
    }
}
