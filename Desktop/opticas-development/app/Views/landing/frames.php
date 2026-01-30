<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Armazones - <?=env('app.title')?></title>
    <link href="/css/output.css" rel="stylesheet">
</head>
<body>
<?=$this->include('landing/components/navbar')?>
<div class="flex container mx-auto py-12">
    <div class="flex items-center justify-center w-full h-full">
        <div class="text-center w-full h-full">
            <h4 class="text-sm text-orange-600 uppercase">Nuestros productos</h4>
            <h2 class="text-4xl lg:text-5xl font-bold">Elige el que más te guste</h2>
        </div>
    </div>
</div>
<?=$this->include('landing/components/filter')?>
<?=$this->include('landing/components/products')?>
<?=$this->include('landing/components/footer')?>


<script src="/js/global.js"></script>
<script>
    console.log('Frame JS loaded');
    const filterButtons = document.querySelectorAll(".filter-btn");
    const cards = document.querySelectorAll("[data-category]");

    document.addEventListener("DOMContentLoaded", function () {
        const buttons = document.querySelectorAll(".option-btn");

        buttons.forEach(button => {
            button.addEventListener("click", function () {
                console.log(this.dataset.target)
                buttons.forEach(btn => btn.classList.remove("bg-primary", "text-white"));

                this.classList.add("bg-primary", "text-white");

                const targetInput = document.getElementById(this.dataset.target);
                if (targetInput) {
                    targetInput.checked = true;
                }
            });
        });

        filterButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const category = this.getAttribute("data-filter");

                cards.forEach((card) => {
                    if (category === "all" || card.dataset.category === category) {
                        card.style.display = "block";
                    } else {
                        card.style.display = "none";
                    }
                });
            });
        });
    });
</script>
</body>
</html>