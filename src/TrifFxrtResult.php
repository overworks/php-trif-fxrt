<?php

namespace Minhyung\TrifFxrt;

use ArrayAccess;
use LogicException;

class TrifFxrtResult implements ArrayAccess
{
    public readonly string $resultCode;
    public readonly string $resultMsg;

    private array $items = [];

    /**
     * @param  \SimpleXMLElement  $xml
     */
    public function __construct($xml)
    {
        $this->resultCode = (string) $xml->header->resultCode;
        $this->resultMsg = (string) $xml->header->resultMsg;
        if ($xml->body?->items) {
            foreach ($xml->body->items->item as $item) {
                $this->items[] = new TrifFxrtItem($item);
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

    public function items(): array
    {
        return $this->items;
    }

    public function offsetExists(mixed $offset): bool
    {
        if (is_int($offset)) {
            return isset($this->items[$offset]);
        }
        if (is_string($offset)) {
            // array_find는 8.4부터 지원하므로 쓰지 못한다...
            foreach ($this->items as $item) {
                if ($item->currSgn === $offset) {
                    return true;
                }
            }
            return false;
        }
        throw new LogicException('Invalid offset type.');
    }

    public function offsetGet(mixed $offset): mixed
    {
        if (is_int($offset)) {
            return $this->items[$offset] ?? null;
        }
        if (is_string($offset)) {
            foreach ($this->items as $item) {
                if ($item->currSgn === $offset) {
                    return $item;
                }
            }
            return null;
        }
        throw new LogicException('Invalid offset type.');
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
