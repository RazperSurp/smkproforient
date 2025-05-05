<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->name ?></title>
    <?php foreach ($this->_cssFiles as $link): ?>
        <link rel="stylesheet" href="/assets/css/<?= $link ?>">
    <?php endforeach; ?>
    <?php foreach ($this->_jsFiles['before'] as $link): ?>
        <?php if(str_ends_with($link, '.mjs')): ?>
            <script type="module" src="/assets/js/<?= $link ?>"> </script>
        <?php else: ?>
            <script type="text/javascript" src="/assets/js/<?= $link ?>"> </script>
        <?php endif; ?>
    <?php endforeach; ?>
</head>