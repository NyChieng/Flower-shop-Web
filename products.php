<?php
require_once __DIR__ . '/auth.php';
startSessionIfNeeded();
requireLogin('products.php');
$categories = [
    [
        'key' => 'bouquet-bar',
        'title' => 'Bouquet bar',
        'description' => 'Six signature bouquets crafted with Sarawak-grown florals. Perfect for gifting or styling your space.',
        'cta' => 'Build a bouquet',
        'items' => [
            ['name' => 'Aurora Peony', 'price' => 'RM129', 'image' => 'img/products/product_1.jpg'],
            ['name' => 'Cottage Garden', 'price' => 'RM139', 'image' => 'img/products/product_2.jpg'],
            ['name' => 'Citrus Sunrise', 'price' => 'RM119', 'image' => 'img/products/product_3.jpg'],
            ['name' => 'Velvet Petals', 'price' => 'RM159', 'image' => 'img/products/product_4.jpg'],
            ['name' => 'Blushing Meadow', 'price' => 'RM149', 'image' => 'img/products/product_5.jpg'],
            ['name' => 'Moonlit Ranunculus', 'price' => 'RM169', 'image' => 'img/products/product_6.jpg'],
        ],
    ],
    [
        'key' => 'event-styling',
        'title' => 'Event styling',
        'description' => 'Statement arrangements for weddings, launches, and corporate dinners. Styled sets include delivery and on-site setup.',
        'cta' => 'Plan an event',
        'items' => [
            ['name' => 'Botanical Aisle', 'price' => 'From RM890', 'image' => 'img/products/product_4.jpg'],
            ['name' => 'Garden Canopy', 'price' => 'From RM1,050', 'image' => 'img/products/product_7.jpg'],
            ['name' => 'Sakura Backdrop', 'price' => 'From RM990', 'image' => 'img/products/product_8.jpg'],
            ['name' => 'Table Meadow', 'price' => 'From RM450', 'image' => 'img/products/product_2.jpg'],
            ['name' => 'Ribboned Columns', 'price' => 'From RM780', 'image' => 'img/products/product_9.jpg'],
            ['name' => 'Chandelier Blooms', 'price' => 'From RM1,200', 'image' => 'img/products/product_5.jpg'],
        ],
    ],
    [
        'key' => 'plant-gifts',
        'title' => 'Plant gifts',
        'description' => 'Low-maintenance plants paired with ceramic pots and care guides. Ideal for hampers or team appreciation.',
        'cta' => 'Preview plant gifts',
        'items' => [
            ['name' => 'Mini Monstera', 'price' => 'RM89', 'image' => 'img/products/product_6.jpg'],
            ['name' => 'Sunset Succulent Trio', 'price' => 'RM79', 'image' => 'img/products/product_3.jpg'],
            ['name' => 'Orchid Showcase', 'price' => 'RM159', 'image' => 'img/products/product_1.jpg'],
            ['name' => 'Lavender Desk Pot', 'price' => 'RM69', 'image' => 'img/products/product_7.jpg'],
            ['name' => 'Fern Terrarium', 'price' => 'RM109', 'image' => 'img/products/product_8.jpg'],
            ['name' => 'Herb Companion Set', 'price' => 'RM99', 'image' => 'img/products/product_9.jpg'],
        ],
    ],
];

function purchase_link(string $categoryKey): string
{
    return 'purchase.php?category=' . urlencode($categoryKey);
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Root Flowers - Products</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="./style/style.css" />
</head>
<body class="rf-page">
  <?php include __DIR__ . '/nav.php'; ?>

  <main class="rf-main">
    <section class="rf-section" aria-labelledby="catalog-intro">
      <header class="rf-section-header">
        <h1 id="catalog-intro" class="rf-section-title">Product overview</h1>
        <p class="rf-section-text">Three curated categories cover bouquets, event styling, and plant gifts&mdash;each with six featured items ready for Assignment&nbsp;1 documentation.</p>
      </header>
    </section>

    <?php foreach ($categories as $category):
      $ctaLink = purchase_link($category['key']);
    ?>
      <section class="rf-section" aria-labelledby="<?php echo htmlspecialchars($category['key']); ?>-title">
        <header class="rf-section-header">
          <div>
            <h2 id="<?php echo htmlspecialchars($category['key']); ?>-title" class="rf-section-title"><?php echo htmlspecialchars($category['title']); ?></h2>
            <p class="rf-section-text"><?php echo htmlspecialchars($category['description']); ?></p>
          </div>
          <a class="rf-button" href="<?php echo htmlspecialchars($ctaLink); ?>"><?php echo htmlspecialchars($category['cta']); ?></a>
        </header>

        <div class="rf-grid">
          <?php foreach ($category['items'] as $item): ?>
            <article class="rf-card">
              <div class="rf-card-body">
                <div class="rf-card-top">
                  <span class="rf-card-icon" data-icon="P"></span>
                  <span class="rf-card-label"><?php echo htmlspecialchars($category['title']); ?></span>
                </div>
                <div class="rf-card-media">
                  <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" />
                </div>
                <h3 class="rf-card-title"><?php echo htmlspecialchars($item['name']); ?></h3>
                <p class="rf-card-text">Starting at <?php echo htmlspecialchars($item['price']); ?>. Custom palettes available upon request.</p>
                <span class="rf-button rf-button-outline rf-button-block rf-button-disabled" role="button" aria-disabled="true">Purchase (Assignment 2)</span>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endforeach; ?>
  </main>

  <?php include __DIR__ . '/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



