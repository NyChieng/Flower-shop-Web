<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (empty($_SESSION['user_email'])) {
    $_SESSION['flash'] = 'Please login to continue.';
    header('Location: login.php?redirect=' . urlencode('products.php'));
    exit;
}
$categories = [
    [
        'key' => 'romance-anniversary',
        'title' => 'Romance & Anniversary',
        'description' => 'Elegant and romantic arrangements perfect for expressing love, celebrating anniversaries, and special moments with your significant other.',
        'cta' => 'Shop Romance',
        'items' => [
            ['name' => 'Crimson Serenade', 'price' => 'RM159', 'image' => 'img/products/product_2.jpg', 'desc' => 'Red gerbera and roses with deep accents - bold and romantic, perfect for passionate declarations'],
            ['name' => 'Snow & Ruby', 'price' => 'RM169', 'image' => 'img/products/product_3.jpg', 'desc' => 'Baby\'s breath cloud with ruby roses - classic and elegant for timeless romance'],
            ['name' => 'Aqua Bloom', 'price' => 'RM149', 'image' => 'img/products/product_5.jpg', 'desc' => 'Pastel pink roses with blue hydrangea and aqua wrap - fresh and modern love expression'],
            ['name' => 'Blush & Daisy', 'price' => 'RM139', 'image' => 'img/products/product_7.jpg', 'desc' => 'Blush roses with daisies and sky wrap - sweet and gentle affection'],
            ['name' => 'Petal Whisper', 'price' => 'RM159', 'image' => 'img/products/product_9.jpg', 'desc' => 'Pastel pinks with gerbera, roses, and daisies - romantic and soft whispers of love'],
        ],
    ],
    [
        'key' => 'birthday-cheer',
        'title' => 'Birthday & Celebrations',
        'description' => 'Cheerful and vibrant arrangements to brighten someone\'s day, perfect for birthdays, thank you gifts, and spreading joy.',
        'cta' => 'Explore Celebrations',
        'items' => [
            ['name' => 'Pastel Sunrise', 'price' => 'RM129', 'image' => 'img/products/product_1.jpg', 'desc' => 'Soft yellow gerbera, lilac rose, and chamomile - pastel and cheerful for bright celebrations'],
            ['name' => 'Meadow Cloud', 'price' => 'RM149', 'image' => 'img/products/product_4.jpg', 'desc' => 'Blue hydrangea mix with daisies and roses - garden fresh and airy for happy occasions'],
            ['name' => 'Peachy Cheer', 'price' => 'RM119', 'image' => 'img/products/product_8.jpg', 'desc' => 'Pink gerbera and carnations with leafy pops - bright and cute energy booster'],
        ],
    ],
    [
        'key' => 'graduation-congrats',
        'title' => 'Graduation & Congratulations',
        'description' => 'Bold and impressive arrangements to celebrate achievements, milestones, and new beginnings.',
        'cta' => 'Celebrate Success',
        'items' => [
            ['name' => 'Crimson Serenade', 'price' => 'RM159', 'image' => 'img/products/product_2.jpg', 'desc' => 'Red gerbera and roses with deep accents - bold statement for major achievements'],
            ['name' => 'Meadow Cloud', 'price' => 'RM149', 'image' => 'img/products/product_4.jpg', 'desc' => 'Blue hydrangea mix with daisies and roses - celebratory and uplifting'],
            ['name' => 'Scarlet Muse', 'price' => 'RM139', 'image' => 'img/products/product_6.jpg', 'desc' => 'Compact red mix with calla and gerbera - petite yet dramatic for graduates'],
        ],
    ],
    [
        'key' => 'business-prosperity',
        'title' => 'Grand Opening & Business',
        'description' => 'Impressive and auspicious arrangements for business celebrations, grand openings, and corporate success.',
        'cta' => 'Business Flowers',
        'items' => [
            ['name' => 'Sunrise Prosperity Stand', 'price' => 'RM399', 'image' => 'img/products/product_10.jpg', 'desc' => 'Sunflower and orange celebration stand with decorative fan and lucky cat - perfect for grand openings'],
            ['name' => 'Fortune Cat Prosperity Basket', 'price' => 'RM349', 'image' => 'img/products/product_11.jpg', 'desc' => 'Red and blush blooms with maneki-neko and fan in elegant basket - brings good fortune and prosperity'],
        ],
    ],
    [
        'key' => 'sympathy-formal',
        'title' => 'Sympathy & Formal',
        'description' => 'Elegant and respectful arrangements for condolences, sympathy, and formal occasions.',
        'cta' => 'Sympathy Flowers',
        'items' => [
            ['name' => 'Ivory Noir', 'price' => 'RM179', 'image' => 'img/products/product_12.jpg', 'desc' => 'White gerberas and roses in sleek black wrap - monochrome elegance for solemn occasions'],
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
  <meta name="author" content="Neng Yi Chieng" />
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
        <h1 id="catalog-intro" class="rf-section-title">Our Complete Collection</h1>
        <p class="rf-section-text">Discover our curated selection of premium flowers, event styling services, and living plants. Each category features handpicked items designed to bring natural beauty into your life.</p>
      </header>
    </section>

    <?php foreach ($categories as $category):
      $ctaLink = purchase_link($category['key']);
    ?>
      <section class="rf-section product-category-section" aria-labelledby="<?php echo htmlspecialchars($category['key']); ?>-title">
        <header class="rf-section-header product-category-header">
          <div>
            <h2 id="<?php echo htmlspecialchars($category['key']); ?>-title" class="rf-section-title"><?php echo htmlspecialchars($category['title']); ?></h2>
            <p class="rf-section-text"><?php echo htmlspecialchars($category['description']); ?></p>
          </div>
        </header>

        <div class="rf-grid products-grid">
          <?php foreach ($category['items'] as $item): ?>
            <article class="rf-card product-item-card">
              <div class="rf-card-body">
                <div class="rf-card-top">
                  <span class="rf-card-icon" data-icon="<?php echo substr($category['title'], 0, 1); ?>"></span>
                  <span class="rf-card-label"><?php echo htmlspecialchars($category['title']); ?></span>
                </div>
                <div class="rf-card-media">
                  <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" />
                </div>
                <h3 class="rf-card-title"><?php echo htmlspecialchars($item['name']); ?></h3>
                <p class="rf-card-text"><?php echo htmlspecialchars($item['desc'] ?? 'Starting at ' . $item['price'] . '. Custom palettes available upon request.'); ?></p>
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <span class="fw-bold text-danger" style="font-size: 1.1rem;"><?php echo htmlspecialchars($item['price']); ?></span>
                  <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Available</span>
                </div>
                <button class="rf-button rf-button-block rf-button-disabled-purchase" disabled aria-disabled="true">
                  <i class="bi bi-lock-fill me-2"></i>Purchase Unavailable
                </button>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endforeach; ?>
  </main>

  <?php include __DIR__ . '/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Smooth product card animations
    document.addEventListener('DOMContentLoaded', function() {
      const productCards = document.querySelectorAll('.product-item-card');
      
      // Entrance animation with stagger
      productCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
          card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
          card.style.opacity = '1';
          card.style.transform = 'translateY(0)';
        }, index * 80);
      });

      // Smooth hover effects
      productCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
          this.style.transform = 'translateY(-12px)';
          this.style.boxShadow = '0 20px 40px rgba(0,0,0,0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
          this.style.transform = 'translateY(0)';
          this.style.boxShadow = '';
        });
      });

      // Smooth scroll to category when clicking category titles
      document.querySelectorAll('.product-category-header').forEach(header => {
        header.style.cursor = 'pointer';
        header.addEventListener('click', function() {
          this.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
      });

      // Add loading shimmer effect to images
      const productImages = document.querySelectorAll('.rf-card-media img');
      productImages.forEach(img => {
        img.addEventListener('load', function() {
          this.style.animation = 'fadeIn 0.5s ease-in';
        });
      });
    });

    // Smooth availability badge pulse
    setInterval(() => {
      document.querySelectorAll('.badge.bg-success').forEach(badge => {
        badge.style.transform = 'scale(1.05)';
        setTimeout(() => {
          badge.style.transform = 'scale(1)';
        }, 200);
      });
    }, 3000);
  </script>
</body>
</html>



