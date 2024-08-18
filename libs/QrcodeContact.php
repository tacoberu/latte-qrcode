<?php
/**
 * Copyright (c) since 2004 Martin Takáč
 * @author Martin Takáč <martin@takac.name>
 */

namespace Taco\Latte;


class QrcodeContact extends VCard implements ToQrCode
{

	function __construct()
	{
	}



	function toQrCode(): string
	{
		return $this->buildVCard();
	}

}
