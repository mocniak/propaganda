server {
    server_name beta.rowerowybialystok.pl www.beta.rowerowybialystok.pl;
    root /var/www/rowerowybialystok/web;

    location / {
        try_files $uri /app_dev.php$is_args$args;
    }

    location ~ ^/app_dev\.php(/|$) {
        fastcgi_pass unix:/var/run/php/php7.2-fpm.sock;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
        internal;
    }

    location ~ \.php$ {
        return 404;
    }

    error_log /var/log/nginx/beta.rowerowybialystok.pl_error.log;
    access_log /var/log/nginx/beta.rowerowybialystok.pl_access.log;
}
