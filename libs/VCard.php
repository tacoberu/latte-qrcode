<?php
/**
 * Copyright (c) since 2004 Martin Takáč
 * @author Martin Takáč <martin@takac.name>
 */

namespace Taco\Latte;

use JeroenDesloovere;


class VCard extends JeroenDesloovere\VCard\VCard
{

	/**
	 * Build VCard (.vcf)
	 */
	function buildVCard(): string
	{
		// init string
		$string = "BEGIN:VCARD\r\n";
		$string .= "VERSION:3.0\r\n";

		// loop all properties
		$properties = $this->getProperties();
		foreach ($properties as $property) {
			// add to string
			$string .= $this->fold($property['key'] . ':' . $this->escape($property['value']) . "\r\n");
		}

		// add to string
		$string .= "END:VCARD\r\n";

		// return
		return $string;
	}

}
