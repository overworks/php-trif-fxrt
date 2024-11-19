<?php

namespace Minhyung\TrifFxrt;

use GuzzleHttp\Client;

class TrifFxrt
{
    const ENDPOINT = 'http://apis.data.go.kr/1220000/retrieveTrifFxrtInfo';

    private ?Client $client = null;

    public function __construct(private string $serviceKey)
    {
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
        $this->client ??= new Client();
        $response = $this->client->get(self::ENDPOINT.'/getRetrieveTrifFxrtInfo', [
            'query' => [
                'serviceKey' => $this->serviceKey,
                'aplyBgnDt' => $aplyBgnDt,
                'weekFxrtTpcd' => $weekFxrtTpcd,
            ],
        ]);
        $responseBody = (string) $response->getBody();
        $xml = simplexml_load_string($responseBody);

        $result = [];
        foreach ($xml->body->items->item as $item) {
            $result[] = [
                'aplyBgnDt' => (string) $item->aplyBgnDt,
                'cntySgn' => (string) $item->cntySgn,
                'currSgn' => (string) $item->currSgn,
                'fxrt' => (float) $item->fxrt,
                'imexTp' => (string) $item->imexTp,
                'mtryUtNm' => (string) $item->mtryUtNm,
            ];
        };
        return $result;
    }
}
