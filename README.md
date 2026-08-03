# minhyung/trif-fxrt

[![Packagist Version](https://img.shields.io/packagist/v/minhyung/trif-fxrt.svg)](https://packagist.org/packages/minhyung/trif-fxrt)
[![Packagist Downloads](https://img.shields.io/packagist/dt/minhyung/trif-fxrt.svg)](https://packagist.org/packages/minhyung/trif-fxrt)
[![PHP Version](https://img.shields.io/packagist/php-v/minhyung/trif-fxrt.svg)](https://packagist.org/packages/minhyung/trif-fxrt)
[![License](https://img.shields.io/packagist/l/minhyung/trif-fxrt.svg)](https://packagist.org/packages/minhyung/trif-fxrt)

## 소개
`minhyung/trif-fxrt`는 대한민국 관세청의 관세환율정보 Open API(`retrieveTrifFxrtInfo`)를 PHP에서 간편하게 사용할 수 있도록 도와주는 라이브러리입니다。

- **지원 API**: https://apis.data.go.kr/1220000/retrieveTrifFxrtInfo
- **PHP 버전**: 8.1 이상
- **라이선스**: MIT

## 설치

```bash
composer require minhyung/trif-fxrt
```

## 사용법

```php
use Minhyung\TrifFxrt\TrifFxrt;

$serviceKey = '발급받은 서비스키';
$client = new TrifFxrt($serviceKey);

// 환율정보 조회
$result = $client->getRetrieveTrifFxrtInfo('20240118', 1); // 1: 수출, 2: 수입

if ($result->isSuccessful()) {
	foreach ($result as $item) {
		// $item['aplyBgnDt'], $item['cntySgn'], $item['currSgn'], $item['fxrt'], ...
	}
} else {
	echo $result->resultMsg;
}
```
