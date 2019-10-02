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

![alt text](http://url/to/img.png)

### Magento CLI

To complete the installation open your terminal, change to magento root directory and use command line :

```cd [magento 2 root folder]```

```php bin/magento setup:upgrade```

After that, if your website is in the production mode, please run the command:

```php bin/magento setup:static-content:deploy```

## Configuration



![alt text](http://url/to/img.png)

