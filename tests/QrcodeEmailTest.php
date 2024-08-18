<?php
/**
 * Copyright (c) since 2004 Martin Takáč
 * @author Martin Takáč <martin@takac.name>
 */

namespace Taco\Latte;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;


class QrcodeEmailTest extends TestCase
{

	#[DataProvider('dataFormat')]
	function testFormat(string $expected, $def)
	{
		$this->assertEquals($expected, $def->toQrCode());
	}



	static function dataFormat(): array
	{
		return [
			["mailto:mail@domena.tld"
				, new QrcodeEmail('mail@domena.tld')
				],
			["mailto:email@domena.com?subject=Předmět emailu"
				, (new QrcodeEmail('email@domena.com'))
					->setSubject("Předmět emailu")
				],
			["mailto:email@domena.com?subject=Předmět emailu&body=Text těla zprávy"
				, (new QrcodeEmail('email@domena.com'))
					->setSubject("Předmět emailu")
					->setBody("Text těla zprávy")
				],
			["mailto:email1@domena.com,email2@domena.com"
				, (new QrcodeEmail('email1@domena.com'))
					->setEmail("email2@domena.com")
				],
			["mailto:email@domena.com?cc=kopie@domena.com&bcc=skryta@domena.com"
				, (new QrcodeEmail('email@domena.com'))
					->setEmailCc("kopie@domena.com")
					->setEmailBcc("skryta@domena.com")
				],
			["mailto:email@domena.com?cc=kopie@domena.com&bcc=skryta@domena.com&subject=Předmět emailu&body=Text těla zprávy"
				, (new QrcodeEmail('email@domena.com'))
					->setEmailCc("kopie@domena.com")
					->setEmailBcc("skryta@domena.com")
					->setSubject("Předmět emailu")
					->setBody("Text těla zprávy")
				],
		];
	}

}
