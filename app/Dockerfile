FROM php:7.4.23-apache

RUN a2enmod rewrite

ENV DEBIAN_FRONTEND noninteractive
RUN apt-get -qq update && apt-get -qq -y --no-install-recommends install \
    curl \
    unzip \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev \
    libjpeg-dev \
    libmemcached-dev \
    zlib1g-dev \
    imagemagick \
    libmagickwand-dev \
    wget \
    ghostscript \
    poppler-utils \
    libsodium-dev

# install the PHP extensions we need
RUN docker-php-ext-install -j$(nproc) iconv pdo pdo_mysql mysqli gd intl
RUN docker-php-ext-configure gd --with-jpeg=/usr/include/ --with-freetype=/usr/include/
RUN yes | pecl install imagick && docker-php-ext-enable imagick

RUN curl -J -L -s -k \
    'https://github.com/omeka/omeka-s/releases/download/v3.1.0/omeka-s-3.1.0.zip' \
    -o /var/www/omeka-s-3.1.0.zip \
&&  unzip -q /var/www/omeka-s-3.1.0.zip -d /var/www/ \
&&  rm /var/www/omeka-s-3.1.0.zip \
&&  rm -rf /var/www/html \
&&  mv /var/www/omeka-s /var/www/html \
&&  mkdir -p {/var/www/html/files,/var/www/html/modules,/var/www/html/logs} \
&&  chown -R www-data:www-data /var/www/html

# Download all 3rd party modules & themes
# https://omeka.org/s/modules/ has a list of latest modules.
# github repo has more recent releases. the mirrored gitlab repo is often outdated.
RUN wget https://github.com/Daniel-KM/Omeka-S-module-AdvancedSearch/releases/download/3.3.6.4/AdvancedSearch-3.3.6.4.zip -P modules \
    &&  wget https://github.com/Daniel-KM/Omeka-S-module-SearchSolr/releases/download/3.5.28.3/SearchSolr-3.5.28.3.zip -P modules \
    &&  wget https://github.com/solariumphp/solarium/zipball/gh-pages -P modules \
    &&  wget https://github.com/Daniel-KM/Omeka-S-module-Generic/releases/download/3.3.29/Generic-3.3.29.zip -P modules \
    &&  wget https://github.com/Daniel-KM/Omeka-S-module-Reference/releases/download/3.4.30.3/Reference-3.4.30.3.zip -P modules \
    &&  wget https://github.com/Daniel-KM/Omeka-S-module-BulkEdit/releases/download/3.3.12.4/BulkEdit-3.3.12.4.zip -P modules \
    &&  wget https://github.com/omeka-s-modules/CSVImport/releases/download/v2.2.1/CSVImport-2.2.1.zip -P modules \
    &&  wget https://github.com/lauraleif/Export/releases/download/v1.5.0/Export.zip -P modules \
    &&  wget https://github.com/Libnamic/Omeka-S-GoogleAnalytics/releases/download/v1.2.2/LibnamicOmekaSGA.zip -P modules \
    &&  wget https://github.com/zerocrates/HideProperties/releases/download/v1.3.0/HideProperties-1.3.0.zip -P modules \
    &&  wget https://github.com/Daniel-KM/Omeka-S-module-ImageServer/releases/download/3.6.8.3/ImageServer-3.6.8.3.zip -P modules \
    &&  wget https://github.com/Daniel-KM/Omeka-S-module-IiifServer/releases/download/3.6.5.3/IiifServer-3.6.5.3.zip -P modules \
    &&  wget https://github.com/omeka-s-modules/Mapping/releases/download/v1.5.0/Mapping-1.5.0.zip -P modules \
    &&  wget https://github.com/zerocrates/PdfEmbedS/releases/download/v1.2.0/PdfEmbed-1.2.0.zip -P modules \
    &&  wget https://github.com/omeka-s-modules/Scripto/releases/download/v1.3.0/Scripto-1.3.0.zip -P modules \
    &&  wget https://github.com/omeka-s-modules/Sharing/releases/download/v1.2.0/Sharing-1.2.0.zip -P modules \
    &&  wget https://github.com/omeka-s-modules/CSSEditor/releases/download/v1.3.0/CSSEditor-1.3.0.zip -P modules \
    &&  wget https://github.com/omeka-s-modules/CustomVocab/releases/download/v1.4.0/CustomVocab-1.4.0.zip -P modules \
    &&  wget https://github.com/omeka-s-modules/ExtractText/releases/download/v1.2.1/ExtractText-1.2.1.zip -P modules \
    &&  wget https://github.com/omeka-s-modules/MetadataBrowse/releases/download/v1.4.0/MetadataBrowse-1.4.0.zip -P modules \
    &&  unzip 'modules/*.zip' -d modules \
    &&  wget https://github.com/omeka-s-themes/centerrow/releases/download/v1.6.0/theme-centerrow-v1.6.0.zip -P themes \
    &&  wget https://github.com/omeka-s-themes/cozy/releases/download/v1.5.1/theme-cozy-v1.5.1.zip -P themes \
    &&  wget https://github.com/omeka-s-themes/thanksroy/releases/download/v1.0.0/theme-thanksroy-v1.0.0.zip -P themes \
    &&  unzip 'themes/*.zip' -d themes \
    && rm *.zip

# Copy our custom files into the image
COPY --chown=www-data:www-data ./config/database.ini /var/www/html/config/database.ini
COPY --chown=www-data:www-data ./config/.htaccess /var/www/html/.htaccess
COPY --chown=www-data:www-data ./config/local.config.php /var/www/html/config/local.config.php

CMD ["apache2-foreground"]