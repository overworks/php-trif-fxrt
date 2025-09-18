<?php

namespace Minhyung\TrifFxrt;

use DateTimeImmutable;

class TrifFxrt
{
    const ENDPOINT = 'http://apis.data.go.kr/1220000/retrieveTrifFxrtInfo';

    public function __construct(
        private readonly string $serviceKey
    ) {
        //
    }

    /**
     * 관세환율정보 조회
     * 
     * @param  string  $aplyBgnDt 적용개시일자(YYYYMMDD)
     * @param  int     $weekFxrtTpcd 주간환율구분코드(1:수출, 2:수입)
     */
    public function getRetrieveTrifFxrtInfo($aplyBgnDt, $weekFxrtTpcd)
    {
        $queryString = http_build_query([
            'serviceKey' => $this->serviceKey,
            'aplyBgnDt' => $aplyBgnDt,
            'weekFxrtTpcd' => $weekFxrtTpcd,
        ]);

        $url = self::ENDPOINT.'/getRetrieveTrifFxrtInfo?'.$queryString;
        
        $options = [
            'http' => [
                'method' => 'GET',
            ],
        ];

        $resource = stream_context_create($options);

        $responseBody = file_get_contents($url, false, $resource);
        if ($responseBody === false) {
            throw new \RuntimeException('Failed to fetch data from API');
        }

        return new TrifFxrtResult($responseBody);
    }
}
