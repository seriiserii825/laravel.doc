server {
        listen 80;
        listen [::]:80;

        root /var/www/laravel_projects/oop.local/public;
        index index.html index.htm index.nginx-debian.html;
        error_log  /var/log/nginx/error.log;
        access_log  /var/log/nginx/access.log;

        server_name oop.local www.oop.local;

        location / {
                index index.php;
                try_files $uri $uri/ /index.php?$args;
        }

        location ~ [^/]\.php(/|$) {
                fastcgi_split_path_info ^(.+?\.php)(/.*)$;
                if (!-f $document_root$fastcgi_script_name) {return 404;}
                fastcgi_param HTTP_PROXY "";
                include fastcgi_params;
                fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
                fastcgi_index index.php;
                fastcgi_param SCRIPT_FILENAME $request_filename;
        }

        location ~ /\.ht {
                deny all;
        }
}
