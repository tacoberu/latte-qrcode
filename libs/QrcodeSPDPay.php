<?php
/**
 * Copyright (c) since 2004 Martin Takáč
 * @author Martin Takáč <martin@takac.name>
 */

namespace Taco\Latte;

use DateTimeInterface;


/**
 * Formát pro bankovní platbu v QR kódu, známý jako QR Platba v České republice, má specifický formát,
 * který je definován standardem Czech Banking Association (ČBA). Tento formát obsahuje různé údaje
 * o platbě, jako je číslo účtu, částka, měna a další volitelné položky.
 *
 * SPD*1.0*ACC:CZ1234567890123456789012*AM:1500.00*CC:CZK*X-VS:1234567890*X-SS:0987654321*MSG:Popis platby
 *
 * Povinné položky
 *  ACC (Account): Číslo účtu příjemce ve formátu IBAN.
 *  AM (Amount): Částka, která má být zaplacena, ve formátu "decimal".
 *  CC (Currency Code): Měna platby ve formátu ISO 4217, např. CZK pro české koruny.
 *
 * Volitelné položky
 *  MSG (Message): Zpráva pro příjemce, kterou uvidí příjemce platby.
 *  X-VS (Variable Symbol): Variabilní symbol platby, maximálně 10 číslic.
 *  X-SS (Specific Symbol): Specifický symbol platby, maximálně 10 číslic.
 *  X-KS (Constant Symbol): Konstantní symbol platby, maximálně 4 číslice.
 *  RF (Reference): Referenční číslo platby (např. v rámci SEPA platby).
 *  DT (Date): Datum splatnosti platby ve formátu YYYYMMDD.
 *  CRC32 (Check Code): Kontrolní součet pro ověření integrity dat v kódu.
 *  X-IBAN (IBAN): IBAN číslo účtu.
 *  X-BIC (Bank Identifier Code): Kód banky (BIC/SWIFT).
 *  X-PER (Payer Identifikator): Identifikátor plátce, který lze použít pro identifikaci plátce v rámci platby.
 *  X-INV (Invoice): Číslo faktury.
 *  X-REM (Remittance Information): Dodatečné informace o platbě, např. popis nebo specifikace.
 *
 * https://qr-platba.cz
 */
class QrcodeSPDPay implements ToQrCode
{

	/** @var array<int|string, string> */
	private array $parts = [];


	/**
	 * @param string $account Like CZ1234567890123456789012: Číslo účtu příjemce ve formátu IBAN (CZ+22 číslic).
	 * @param float $amount Like 1500.00: Částka platby.
	 * @param string $currency Like CZK: Měna platby ve formátu ISO 4217, např. CZK pro české koruny.
	 */
	function __construct(string $account, float $amount, string $currency)
	{
		$this->parts[] = 'SPD';
		$this->parts[] = '1.0';
		$this->parts['ACC'] = "ACC:{$account}";
		$this->parts['AM'] = "AM:" . number_format($amount, 2, '.', '');
		$this->parts['CC'] = "CC:{$currency}";
	}



	function setOptional(string $key, string $val): self
	{
		$key = strtoupper($key);
		$this->parts[$key] = "{$key}:{$val}";
		return $this;
	}



	/**
	 * Zpráva pro příjemce, kterou uvidí příjemce platby.
	 */
	function setMessage(string $val): self
	{
		return $this->setOptional('MSG', $val);
	}



	/**
	 * Datum splatnosti platby
	 */
	function setDate(DateTimeInterface $val): self
	{
		return $this->setOptional('DT', $val->format('Ymd'));
	}



	/**
	 * Číslo faktury
	 */
	function setInvoice(string $val): self
	{
		return $this->setOptional('X-INV', $val);
	}



	function setVariableSymbol(string $val): self
	{
		return $this->setOptional('X-VS', $val);
	}



	function setSpecificSymbol(string $val): self
	{
		return $this->setOptional('X-SS', $val);
	}



	function setConstantSymbol(string $val): self
	{
		return $this->setOptional('X-KS', $val);
	}



	/**
	 * X-ID: Identifikátor platby.
	 */
	function setIdentificationSymbol(string $val): self
	{
		return $this->setOptional('X-ID', $val);
	}



	/**
	 * X-URL: URL pro další informace o platbě.
	 */
	function setUrl(string $val): self
	{
		return $this->setOptional('X-URL', $val);
	}



	function toQrCode(): string
	{
		$parts = $this->parts;
		// Přesunout MSG až na konec
		if (array_key_exists('MSG', $parts)) {
			unset($parts['MSG']);
			$parts['MSG'] = $this->parts['MSG'];
		}
		return implode('*', $parts);
	}

}
