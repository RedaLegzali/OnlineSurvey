<!DOCTYPE html>
<html>
<head>
    <title>Online Survey</title>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/logo_paper.png') ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">    <?php if( isset($style) ): ?>
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/'.$style.'.css') ?>">
    <?php endif; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/color/jquery.color-2.2.0.min.js" integrity="sha256-aSe2ZC5QeunlL/w/7PsVKmV+fa0eDbmybn/ptsKHR6I=" crossorigin="anonymous"></script>
</head>

<body> 