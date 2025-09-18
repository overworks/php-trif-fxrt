<?php

namespace Minhyung\TrifFxrt;

use ArrayAccess;
use DateTimeImmutable;
use LogicException;

class TrifFxrtResult implements ArrayAccess
{
    public readonly string $resultCode;
    public readonly string $resultMsg;

    private array $items = [];

    public function __construct(string $xmlString)
    {
        $xml = simplexml_load_string($xmlString);
        $this->resultCode = (string) $xml->header->resultCode;
        $this->resultMsg = (string) $xml->header->resultMsg;
        if ($xml->body?->items) {
            foreach ($xml->body->items->item as $item) {
                $this->items[] = [
                    'aplyBgnDt' =>
                        DateTimeImmutable::createFromFormat('Ymd', (string) $item->aplyBgnDt),   // 적용개시일자
                    'cntySgn' => (string) $item->cntySgn,       // 국가부호
                    'currSgn' => (string) $item->currSgn,       // 통화부호
                    'fxrt' => (float) $item->fxrt,              // 환율
                    'imexTp' => (int) $item->imexTp,         // 수출입구분(1:수출, 2:수입)
                    'mtryUtNm' => (string) $item->mtryUtNm,     // 화폐단위명
                ];
            }
        }
    }

    public function isSuccessful(): bool
    {
        return $this->resultCode === '00';
    }

    public function isFailed(): bool
    {
        return $this->resultCode !== '00';
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->items[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new LogicException('This object is read-only.');
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new LogicException('This object is read-only.');
    }
}
