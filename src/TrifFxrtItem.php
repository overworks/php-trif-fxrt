<?php

namespace Minhyung\TrifFxrt;

use ArrayAccess;
use DateTimeImmutable;
use LogicException;

class TrifFxrtItem implements ArrayAccess
{
    /**
     * @var \DateTimeImmutable 적용개시일자
     */
    public readonly DateTimeImmutable $aplyBgnDt;

    /**
     * @var string 국가부호
     */
    public readonly string $cntySgn;

    /**
     * @var string 통화부호
     */
    public readonly string $currSgn;

    /**
     * @var float 환율
     */
    public readonly float $fxrt;

    /**
     * @var int 수출입구분(1:수출, 2:수입)
     */
    public readonly int $imexTp;

    /**
     * @var string 화폐단위명
     */
    public readonly string $mtryUtNm;

    /**
     * @param  \SimpleXMLElement  $elem
     */
    public function __construct($elem)
    {
        $this->aplyBgnDt = DateTimeImmutable::createFromFormat('Ymd', (string) $elem->aplyBgnDt);
        $this->cntySgn = (string) $elem->cntySgn;
        $this->currSgn = (string) $elem->currSgn;
        $this->fxrt = (float) $elem->fxrt;
        $this->imexTp = (int) $elem->imexTp;
        $this->mtryUtNm = (string) $elem->mtryUtNm;
    }

    public function offsetExists(mixed $offset): bool
    {
        return property_exists($this, $offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->$offset ?? null;
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
