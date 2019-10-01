# Safepay Extension for Magento 2

## Pre-Installation

Before any installation put your Magento store in developer mode, to do that please go to the Magento folder and run the following command:

```php bin/magento deploy:mode:set developer```

Next turn off Magento cache:

```php bin/magento cache:disable```

Now you're ready for the installation.

## Installation

### Installation using composer

You can install this module by Composer (If your server supports Composer). 
Please go to the Magento folder and run the following command:

```composer require abdelkebir/magento2-safepay```

### Install by uploading files

You can download as "zip" file and unzip Safepay extension:

![alt text](http://url/to/img.png)

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

