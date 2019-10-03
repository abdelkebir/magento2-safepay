# Safepay Extension for Magento 2


![Safepay](https://drive.google.com/uc?id=1iJlUH7WF2Rhyb__B1Cayua5oPPUjBw-_)

## Pre-Installation

Before any installation put your Magento store in developer mode, to do that please go to the Magento folder and run the following command:

```php bin/magento deploy:mode:set developer```

Next turn off Magento cache:

```php bin/magento cache:disable```

Now you're ready for the installation.

## Installation

### Uploading Files

You can download as "zip" file and unzip Safepay extension:

![Download az zip](https://drive.google.com/uc?id=1PyG1o0JM5FA3a73_GULN-uaIEfPloB-i)

or clone this repository by the following commands:

```git clone https://github.com/abdelkebir/magento2-safepay.git```

Please create the folder **app/code/Godogi/Safepay** and copy all files which you have downloaded to it.

The code directory would be like this:

![Directory architecture](https://drive.google.com/uc?id=17guR8pV9FxXVIHC3WkJund8yL4etLr6p)

### Magento CLI

To complete the installation open your terminal, change to magento root directory and use command line :

```cd [magento 2 root folder]```

```php bin/magento setup:upgrade```

After that, if your website is in the production mode, please run the command:

```php bin/magento setup:static-content:deploy```

## Configuration

Log in to your Magento admin panel, go to STORES > Configuration:

![STORES > Configuration](https://drive.google.com/uc?id=1H3okL8cFh-mtWewhtiAVoyhtzJnmNgur)

Then go to SALES > Payment Methods:

![Directory architecture](https://drive.google.com/uc?id=1i_vw3t3lm9Tw4oJEeGKVaw85ghSSEhYB)

You will find Safepay configuration block under Safepay tab:

![Directory architecture](https://drive.google.com/uc?id=1wg1WbSgxdJ6ZJT9TDcgODURHe9WdKF4v)

In this form you need to add your Safepay sandbox and production keys, you can also enable or disable this module and change the module title on checkout. Remember to save your configuration.


