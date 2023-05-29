<?php


?>
<?= 'User-agent: *' . PHP_EOL; ?>
<?= 'Disallow: /admin/' . PHP_EOL; ?>
<?= 'Disallow: /site/' . PHP_EOL; ?>
<?php foreach ($posts as $post): ?>
<?= 'Disallow: /' . $post->url . PHP_EOL; ?>
<?php endforeach; ?>
<?= "Sitemap: $host/sitemap.xml"; ?>