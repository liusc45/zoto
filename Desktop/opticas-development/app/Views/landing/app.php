<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inicio - <?=env('app.title')?></title>
    <link href="/css/output.css" rel="stylesheet">
</head>
<body>
    <?=$this->include('landing/components/navbar')?>
    <?=$this->include('landing/components/hero')?>
    <?=$this->include('landing/components/features')?>
    <?=$this->include('landing/components/services')?>
    <?=$this->include('landing/components/online-benefits')?>
    <?=$this->include('landing/components/products')?>
    <?=$this->include('landing/components/reviews')?>
    <?=$this->include('landing/components/contact')?>
    <?=$this->include('landing/components/footer')?>

    <script src="/js/global.js"></script>
</body>
</html>