<?php
/**
 * Copyright (c) since 2004 Martin Takáč
 * @author Martin Takáč <martin@takac.name>
 */

namespace Taco\Latte;


class QrcodeEmail implements ToQrCode
{

	/** @var array<string> */
	private array $emails = [];

	/** @var array<string> */
	private array $query = [];

	function __construct(string $email)
	{
		$this->emails[] = $email;
	}



	function setEmail(string $val): self
	{
		$this->emails[] = $val;
		return $this;
	}



	function setEmailCc(string $val): self
	{
		$this->query['cc'] = $val;
		return $this;
	}



	function setEmailBcc(string $val): self
	{
		$this->query['bcc'] = $val;
		return $this;
	}



	function setSubject(string $val): self
	{
		$this->query['subject'] = $val;
		return $this;
	}



	function setBody(string $val): self
	{
		$this->query['body'] = $val;
		return $this;
	}



	function toQrCode(): string
	{
		return 'mailto:'
			. implode(',', $this->emails)
			. ($this->query ? ('?' . self::http_build_query($this->query)) : '');
	}



	/**
	 * Without encoding of text.
	 * @param array<string, string> $xs
	 */
	private static function http_build_query(array $xs): string
	{
		$out = [];
		foreach ($xs as $k => $v) {
			$out[] = "{$k}={$v}";
		}
		return implode('&', $out);
	}

}
