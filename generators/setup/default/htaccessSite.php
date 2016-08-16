<?php
echo 'Options +FollowSymlinks
RewriteEngine On

# deal with admin first
RewriteCond %{REQUEST_URI} ^/phu/advanced/(admin)
RewriteRule ^admin/assets/(.*)$ backend/web/assets/$1 [L]
RewriteRule ^admin/css/(.*)$ backend/web/css/$1 [L]

RewriteCond %{REQUEST_URI} !^/phu/advanced/backend/web/(assets|css)/ 
RewriteCond %{REQUEST_URI} ^/phu/advanced/(admin) 
RewriteRule ^.*$ backend/web/index.php [L]


RewriteCond %{REQUEST_URI} ^/phu/advanced/(assets|css) 
RewriteRule ^assets/(.*)$ frontend/web/assets/$1 [L]
RewriteRule ^css/(.*)$ frontend/web/css/$1 [L]

RewriteCond %{REQUEST_URI} !^/phu/advanced/(frontend|backend)/web/(assets|css)/ 
RewriteCond %{REQUEST_URI} !index.php
RewriteCond %{REQUEST_FILENAME} !-f [OR]
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^.*$ frontend/web/index.php';
?>