# FileJet Pro Magento2 plugin

We welcome your feedback and we accept pull-requests.


# Installation

```
# build the image with PHP 5.6 and composer
docker build -t filejet-magento2-plugin - < Dockerfile

# install vendors
docker run -it --rm -v "$PWD":/magento -w /magento filejet-wordpress-plugin composer install --no-dev --no-autoloader
```
