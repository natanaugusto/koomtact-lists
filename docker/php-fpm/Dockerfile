ARG PHP_VERSION=8
FROM php:${PHP_VERSION}-fpm-alpine

RUN echo ${PHP_VERSION}

USER root
## Install basics ###################################
RUN apk update && \
    apk upgrade && \
    apk add --update \
    $PHPIZE_DEPS \
    linux-headers \
    coreutils \
    util-linux \
    shadow

## Install PHP libs ###################################
RUN apk add --no-cache \
    openssh-client \
    libmcrypt-dev \
    openldap-dev \
    freetype-dev \
    mysql-client \
    libzip-dev \
    libpng-dev \
    giflib-dev \
    jpeg-dev \
    freetype \
    jpeg-dev \
    libjpeg \
    libldap \
    libxml2-dev \
    ldb-dev \
    libpng \
    zip \
    vim \
    git \
    bash \
    su-exec \
    zsh \
    && docker-php-ext-install \
    mysqli \
    pdo \
    pdo_mysql \
    bcmath \
    soap \
    ldap \
    zip \
    pdo \
    pcntl \
    gd \
    && pecl install \
    mcrypt \
    xdebug \
    redis \
    && docker-php-ext-enable \
    mcrypt \
    xdebug \
    redis

# Xdebug
COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

## Install Composer
ARG WORKSPACE_INSTALL_COMPOSER=false
ARG WORKSPACE_COMPOSER_VERSION=2
ARG WORKSPACE_COMPOSER_HASH=abc
RUN if [ ${WORKSPACE_INSTALL_COMPOSER} = true ]; then \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('sha384', 'composer-setup.php') === '${WORKSPACE_COMPOSER_HASH}') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');" \
    && composer self-update --${WORKSPACE_COMPOSER_VERSION} \
    ;fi

# Create workspace user 
ARG WORKSPACE_USER=workspace
ARG WORKSPACE_USER_HOME=/home/${WORKSPACE_USER}

RUN mkdir -p ${WORKSPACE_USER_HOME} \
    && groupadd -g 1000 ${WORKSPACE_USER} \
    && useradd -l -u 1000 -g ${WORKSPACE_USER} -m ${WORKSPACE_USER} \
    && chown -R ${WORKSPACE_USER}:${WORKSPACE_USER} ${WORKSPACE_USER_HOME} \
    && usermod -d ${WORKSPACE_USER_HOME} -p "*" ${WORKSPACE_USER} -s /bin/zsh \
    && usermod -a -G root,adm ${WORKSPACE_USER}

USER ${WORKSPACE_USER}
# Alias
COPY ./aliases.sh ${WORKSPACE_USER_HOME}/aliases.sh

RUN sed -i 's/\r//' ${WORKSPACE_USER_HOME}/aliases.sh  \
    && chown ${WORKSPACE_USER}:${WORKSPACE_USER} ${WORKSPACE_USER_HOME}/aliases.sh \
    && echo "" >> ${WORKSPACE_USER_HOME}/.bashrc \
    && echo "# Load Custom Aliases" >> ${WORKSPACE_USER_HOME}/.bashrc \
    && echo "source ~/aliases.sh" >> ${WORKSPACE_USER_HOME}/.bashrc \
    && echo "" >> ${WORKSPACE_USER_HOME}/.bashrc

# Install ZSH
ARG WORKSPACE_INSTALL_ZSH=false

RUN if [ ${WORKSPACE_INSTALL_ZSH} = true ]; then \
    sh -c "$(wget https://raw.github.com/robbyrussell/oh-my-zsh/master/tools/install.sh -O -)" \
    && sed -i "s/ZSH_THEME=\"robbyrussell\"/ZSH_THEME=\"custom\"/" ${WORKSPACE_USER_HOME}/.zshrc \
    && echo "" >> ${WORKSPACE_USER_HOME}/.zshrc \
    && echo "# Load Custom Aliases" >> ${WORKSPACE_USER_HOME}/.zshrc \
    && echo "source ~/aliases.sh" >> ${WORKSPACE_USER_HOME}/.zshrc \
    && echo "" >> ${WORKSPACE_USER_HOME}/.zshrc \
    ;fi
COPY ./custom.zsh-theme ${WORKSPACE_USER_HOME}/.oh-my-zsh/custom/themes/

USER root

ARG WORKSPACE_GITHUB_SSH_KEY=id_rsa
ENV WORKSPACE_GITHUB_SSH_KEY ${WORKSPACE_USER_HOME}/.ssh/${WORKSPACE_GITHUB_SSH_KEY}

WORKDIR /workspace

CMD ["php-fpm"]

EXPOSE 9000