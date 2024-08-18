<?php
/**
 * Copyright (c) since 2004 Martin Takáč
 * @author Martin Takáč <martin@takac.name>
 */

namespace Taco\Latte;

use PHPUnit\Framework\TestCase;
use LogicException;
use DateTime;


class QrcodeLatteExtensionTest extends TestCase
{

	function testQrcode1()
	{
		$inst = new QrcodeLatteExtension;
		$this->assertStringEqualsFileData('hi.svq', $inst->qrcodeText("Hi", 64));
	}



	function testQrcodeContact_1()
	{
		$def = new QrcodeContact();
		$def->addName('Dee', 'John');
		$def->addPhoneNumber('+420123456789', 'TYPE=CELL');
		$def->addEmail('john.dee@example.com');
		$inst = new QrcodeLatteExtension;
		$this->assertStringEqualsFileData('john-dee.svq', $inst->qrcodeContact($def, 64));
	}



	function testQrcodeContact_2()
	{
		$def = new QrcodeContact();
		$def->addName('Desloovere', 'Jeroen', additional: '', prefix: '', suffix: '');
		$def->addCompany('Siesqo');
		$def->addJobtitle('Web Developer');
		$def->addRole('Data Protection Officer');
		$def->addEmail('info@jeroendesloovere.be');
		$def->addPhoneNumber(1234121212, 'PREF;WORK');
		$def->addPhoneNumber(123456789, 'WORK');
		$def->addAddress(null, null, 'street', 'worktown', null, 'workpostcode', 'Belgium');
		$def->addLabel('street, worktown, workpostcode Belgium');
		$def->addURL('http://www.jeroendesloovere.be');
		$inst = new QrcodeLatteExtension;
		$this->assertStringEqualsFileData('jeroen-desloovere.svq', $inst->qrcodeContact($def, 64));
	}



	function testQrcodeEmail_1()
	{
		$def = new QrcodeEmail('mail@domena.tld');
		$inst = new QrcodeLatteExtension;
		$this->assertStringEqualsFileData('mail_1.svq', $inst->qrcodeEmail($def));
	}



	function testQrcodeEmail_6()
	{
		$def = (new QrcodeEmail('email@domena.com'))
			->setEmailCc("kopie@domena.com")
			->setEmailBcc("skryta@domena.com")
			->setSubject("Předmět emailu")
			->setBody("Text těla zprávy");
		$inst = new QrcodeLatteExtension;
		$this->assertStringEqualsFileData('mail_6.svq', $inst->qrcodeEmail($def));
	}



	function testQrcodeSPD_1()
	{
		$def = (new QrcodeSPDPay('CZ7603000000000076327632', 1500.00, 'CZK'));
		$inst = new QrcodeLatteExtension;
		$this->assertStringEqualsFileData('spd_1.svq', $inst->qrcode($def));
	}



	function testQrcodeSPD_2()
	{
		$def = (new QrcodeSPDPay('CZ7603000000000076327632', 1500.00, 'CZK'))
			->setMessage('Testovací platba')
			->setInvoice('F2024654')
			->setOptional('RN', 'Jan Novák')
			->setDate(new DateTime('2024-02-04'))
			->setVariableSymbol("1234567890")
			->setSpecificSymbol("0987654321")
			->setConstantSymbol("4545");
		$inst = new QrcodeLatteExtension;
		$this->assertStringEqualsFileData('spd_2.svq', $inst->qrcode($def));
	}



	private function assertStringEqualsFileData(string $expected, string $value)
	{
		$this->assertStringEqualsFile(__dir__ . '/data/' . $expected, $value);
	}

}
