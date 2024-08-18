<?php
/**
 * Copyright (c) since 2004 Martin Takáč
 * @author Martin Takáč <martin@takac.name>
 */

namespace Taco\Latte;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use DateTime;


class QrcodeSPDPayTest extends TestCase
{

	#[DataProvider('dataFormat')]
	function testFormat(string $expected, $def)
	{
		$this->assertEquals($expected, $def->toQrCode());
	}



	static function dataFormat(): array
	{
		return [
			['SPD*1.0*ACC:CZ7603000000000076327632*AM:1500.00*CC:CZK'
				, new QrcodeSPDPay('CZ7603000000000076327632', 1500.00, 'CZK')
				],
			['SPD*1.0*ACC:CZ1234567890123456789012*AM:1500.00*CC:CZK'
				, new QrcodeSPDPay('CZ1234567890123456789012', 1500.00, 'CZK')
				],
			['SPD*1.0*ACC:CZ1234567890123456789012*AM:1500.00*CC:CZK*MSG:Popis platby'
				, (new QrcodeSPDPay('CZ1234567890123456789012', 1500.00, 'CZK'))
					->setMessage('Popis platby')
				],
			["SPD*1.0*ACC:CZ1234567890123456789012*AM:1500.00*CC:CZK*X-VS:1234567890*X-SS:0987654321*MSG:Popis platby"
				, (new QrcodeSPDPay('CZ1234567890123456789012', 1500.00, 'CZK'))
					->setMessage('Popis platby')
					->setVariableSymbol("1234567890")
					->setSpecificSymbol("0987654321")
				],
			["SPD*1.0*ACC:CZ1234567890123456789012*AM:1500.00*CC:CZK*X-VS:1234567890*X-SS:0987654321*X-KS:4545*MSG:Popis platby"
				, (new QrcodeSPDPay('CZ1234567890123456789012', 1500.00, 'CZK'))
					->setMessage('Popis platby')
					->setVariableSymbol("1234567890")
					->setSpecificSymbol("0987654321")
					->setConstantSymbol("4545")
				],
			["SPD*1.0*ACC:CZ7603000000000076327632*AM:1500.00*CC:CZK*X-INV:F2024654*DT:20240204*X-VS:1234567890*X-SS:0987654321*X-KS:4545*MSG:Popis platby"
				, (new QrcodeSPDPay('CZ7603000000000076327632', 1500.00, 'CZK'))
					->setMessage('Popis platby')
					->setInvoice('F2024654')
					->setDate(new DateTime('2024-02-04'))
					->setVariableSymbol("1234567890")
					->setSpecificSymbol("0987654321")
					->setConstantSymbol("4545")
				],
		];
	}

}
