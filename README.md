Latte qrcode
============

Latte |qrcode supporting.


## Installation

The best way to install **tacoberu/latte-qrcode** is using  [Composer](http://getcomposer.org/):

```sh
$ composer require tacoberu/latte-qrcode
```

Then register the extension in the config file:
```yaml
# app/config/config.neon
latte:
    extensions:
        - Taco\Latte\QrcodeLatteExtension
```


## Usage

```latte
<img src="{('Hi')|qrcode}" alt="qrcode with text"/>
<img src="{$contact|qrcode}" alt="qrcode with QrcodeContact"/>
<img src="{$email|qrcode}" alt="qrcode with QrcodeEmail"/>
<img src="{$pay|qrcode}" alt="qrcode with QrcodeSPDPay"/>
```


## License

Latte filters is under the MIT license. See the [LICENSE](LICENSE) file for details.
