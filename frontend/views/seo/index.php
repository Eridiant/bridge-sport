<?php

?>
<?= '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL ; ?>
    <url>
        <loc><?= $host; ?></loc>  
        <lastmod><?= date(DATE_W3C, $posts[0]->updated_at ?? 0);date('Y-m-d') ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach ($posts as $post): ?>
        <url>
            <loc><?= $host; ?>/<?= $post->url ?></loc>  
            <lastmod><?= date(DATE_W3C, $post->updated_at);date('Y-m-d') ?></lastmod>
            <changefreq><?= $post->changefreq; ?></changefreq>
            <priority>0.<?= $post->priority; ?></priority>
        </url>
    <?php endforeach; ?>
</urlset>