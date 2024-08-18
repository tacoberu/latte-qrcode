<?php
/**
 * Copyright (c) since 2004 Martin Takáč
 * @author Martin Takáč <martin@takac.name>
 */

namespace Taco\Latte;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;


class QrcodeContactTest extends TestCase
{

	function testFormatJohnDee()
	{
		$vcard = new VCard();
		$vcard->addName('Dee', 'John');
		$vcard->addPhoneNumber('+420123456789', 'TYPE=CELL');
		$vcard->addEmail('john.dee@example.com');
		$this->assertStringEqualsFileData('john-dee.vcf', $vcard->buildVCard());

		$def = new QrcodeContact();
		$def->addName('Dee', 'John');
		$def->addPhoneNumber('+420123456789', 'TYPE=CELL');
		$def->addEmail('john.dee@example.com');
		$this->assertStringEqualsFileData('john-dee.vcf', $def->toQrCode());
	}



	function testFormatJeroen()
	{
		$vcard = new VCard();
		$vcard->addName('Desloovere', 'Jeroen', additional: '', prefix: '', suffix: '');
		$vcard->addCompany('Siesqo');
		$vcard->addJobtitle('Web Developer');
		$vcard->addRole('Data Protection Officer');
		$vcard->addEmail('info@jeroendesloovere.be');
		$vcard->addPhoneNumber(1234121212, 'PREF;WORK');
		$vcard->addPhoneNumber(123456789, 'WORK');
		$vcard->addAddress(null, null, 'street', 'worktown', null, 'workpostcode', 'Belgium');
		$vcard->addLabel('street, worktown, workpostcode Belgium');
		$vcard->addURL('http://www.jeroendesloovere.be');

		$this->assertStringEqualsFileData('jeroen-desloovere.vcf', $vcard->buildVCard());
	}



	private function assertStringEqualsFileData(string $expected, string $value)
	{
		$this->assertStringEqualsFile(__dir__ . '/data/' . $expected, $value);
	}

}
