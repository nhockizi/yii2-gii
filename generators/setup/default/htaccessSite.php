<?php
echo '# prevent directory listings
Options -Indexes
IndexIgnore */*

# follow symbolic links
Options FollowSymlinks

RewriteEngine on
RewriteRule ^admin(.+)?$ backend/web/$1 [L]
RewriteRule ^(.+)?$ frontend/web/$1';
?>