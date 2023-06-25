<?php

declare(strict_types=1);

namespace Domain\Address\DataTransferObjects;

final class GeolocationData extends \Parent\DataTransferObjects\Data
{
    
    public function __construct(
        public ?string $city,
        public ?string $region,
        public ?float $geo_lat,
        public ?float $geo_lon,
        public ?string $ip,
    ) {
    }

    public static function default(): self
    {        
        return new self(            
            city: 'Москва и МО',
            region: 'Москва и МО',            
            geo_lat: 55.75399400,
            geo_lon: 37.62209300,
            ip: null,
        );
    }
    public static function fromDaData(array $data, ?string $ip): self
    {
        return new self(      
            city: $data['location']['data']['city'],
            region: $data['location']['data']['region'],       
            geo_lat: floatval($data['location']['data']['geo_lat']),
            geo_lon: floatval($data['location']['data']['geo_lon']),
            ip: $ip,
        );
    }

    public static function fromSypexgeo(array $data): self
    {
        return new self(           
            city: $data['city']['name_ru'],   
            region: $data['region']['name_ru'],   
            geo_lat: floatval($data['city']['lat']),
            geo_lon: floatval($data['city']['lon']),
            ip: $data['ip'],
        );
    }
}
