# Extend ProductApi Module
[![Build Status](https://travis-ci.org/fond-of/spryker-product-api.svg?branch=master)](https://travis-ci.org/fond-of/spryker-product-api)
[![PHP from Travis config](https://img.shields.io/travis/php-v/symfony/symfony.svg)](https://php.net/)
[![license](https://img.shields.io/github/license/mashape/apistatus.svg)](https://packagist.org/packages/fond-of-spryker/product-api)

ProductApi extends the Base Spryker Product Api Module:
 * the update and get calls  are using the SKU of a product instead of the Abstract Product ID 
 * touch Abstract Product on create



## Installation

```
composer require fond-of-spryker/product-api
```

## API

GET /api/rest/products/{sku}

```
curl -X GET "http://zed.yourdomain.com/api/rest/products/{sku}" \
     -H 'Content-Type: application/json' \
     
```
POST /api/rest/products/
```
curl -X GET "http://zed.yourdomain.com/api/rest/products/" \
     -H 'Content-Type: application/json' \
     
```

PATCH /api/rest/products/{sku}

```
curl -X PATCH "http://zed.yourdomain.com/api/rest/products/{sku}" \
     -H 'Content-Type: application/json' \
     -d $'{
          "data": {
            "sku": "sku",
            "id_tax_set": 1,
            "name": "Name",
            "fk_locale": "en_US",
            "attributes" : {
                "attribute": "value"
            },
            "localized_attributes": [
             {
              "name": "Name",
              "description": "Description",
               "meta_description": "Meta Description",
               "attributes": {
                
               },
               "locale": {
                    "id_locale": 46,
                    "locale_name": "en_US",
                    "is_active": true
                }
             }
            ]       
          }
     }'
     
```

