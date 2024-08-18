<?php
/**
 * Copyright (c) since 2004 Martin Takáč
 * @author Martin Takáč <martin@takac.name>
 */

namespace Taco\Latte;

use Latte;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;


final class QrcodeLatteExtension extends Latte\Extension
{
	const DefaultSize = 128;


	function install(Latte\Engine $engine): void
	{
		$engine->addFilter('qrcode', [$this, 'qrcode']);
		$engine->addFilter('qrcodeText', [$this, 'qrcodeText']);
		$engine->addFilter('qrcodeContact', [$this, 'qrcodeContact']);
		$engine->addFilter('qrcodeEmail', [$this, 'qrcodeEmail']);
	}



	function getFilters(): array
	{
		return [
			'qrcode' => [$this, 'qrcode'],
			'qrcodeText' => [$this, 'qrcodeText'],
			'qrcodeContact' => [$this, 'qrcodeContact'],
			'qrcodeEmail' => [$this, 'qrcodeEmail'],
		];
	}



	function qrcode(ToQrCode $src, int $size = self::DefaultSize): string
	{
		return (new Writer($this->createRendererWith($size)))
			->writeString($src->toQrCode(), 'UTF-8');
	}



	function qrcodeText(string $src, int $size = self::DefaultSize): string
	{
		return (new Writer($this->createRendererWith($size)))
			->writeString($src, 'UTF-8');
	}



	function qrcodeContact(QrcodeContact $src, int $size = self::DefaultSize): string
	{
		return $this->qrcode($src, $size);
	}



	function qrcodeEmail(QrcodeEmail $src, int $size = self::DefaultSize): string
	{
		return $this->qrcode($src, $size);
	}



	private function createRendererWith(int $size): ImageRenderer
	{
		//~ $backend = new ImagickImageBackEnd();
		$backend = new SvgImageBackEnd();
		return new ImageRenderer(
			new RendererStyle($size),
			$backend
		);
	}

}
