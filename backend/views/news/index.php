<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php foreach ($newsList as $value) :?>

    <div><?php echo $value['title']; ?> </div>
    <a href="/news/<?php echo $value['id']; ?>">read</a>

    <?php endforeach ?>
</body>

</html>