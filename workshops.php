<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (empty($_SESSION['user_email'])) {
    $_SESSION['flash'] = 'Please login to continue.';
    header('Location: login.php?redirect=' . urlencode('workshops.php'));
    exit;
}
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
$workshops = [
    [
        'slug' => 'hand-tied',
        'title' => 'Hand-tied Bouquet Masterclass',
        'date' => 'Every Saturday',
        'time' => '9:30 AM - 12:30 PM',
        'price' => 'RM220 per participant',
        'venue' => 'Root Flowers Studio, Kuching',
        'image' => 'img/workshop_1.jpg',
        'summary' => 'Master the art of spiral binding and create stunning hand-tied bouquets. Learn stem preparation, color theory, and professional finishing techniques. All flowers, tools, and a comprehensive care guide included.',
        'details' => 'Perfect for beginners and intermediate florists. This hands-on workshop covers classic European hand-tying techniques, proper stem conditioning, and design principles that will elevate your bouquet arrangements. You\'ll take home a beautiful bouquet and newfound confidence.',
        'includes' => ['Premium fresh flowers', 'Professional tools usage', 'Take-home bouquet', 'Care guide booklet', 'Certificate of completion'],
    ],
    [
        'slug' => 'tablescape',
        'title' => 'Modern Tablescapes Intensive',
        'date' => 'First Sunday each month',
        'time' => '2:00 PM - 6:00 PM',
        'price' => 'RM320 per participant',
        'venue' => 'Jalan Song Event Loft',
        'image' => 'img/workshop_2.jpg',
        'summary' => 'Transform ordinary tables into extraordinary focal points. Learn layering techniques, candle safety, height variation, and transport planning for professional event centerpieces.',
        'details' => 'Ideal for event planners, stylists, and anyone looking to create stunning table arrangements. Learn the secrets of professional tablescapes including color palettes, texture mixing, and creating memorable dining experiences.',
        'includes' => ['3 different centerpiece styles', 'Candle safety training', 'Event planning templates', 'Photography tips', 'Afternoon tea service'],
    ],
    [
        'slug' => 'terrarium',
        'title' => 'Closed Terrarium Study',
        'date' => 'Alternate Wednesdays',
        'time' => '7:30 PM - 9:30 PM',
        'price' => 'RM180 per participant',
        'venue' => 'Root Flowers Studio Lab Room',
        'image' => 'img/workshop_3.jpg',
        'summary' => 'Design and build your own self-sustaining ecosystem. Understand humidity cycles, plant compatibility, soil layering, and long-term maintenance for thriving terrariums.',
        'details' => 'Discover the fascinating world of closed terrariums. Learn about plant selection, water cycles, and creating beautiful miniature landscapes that require minimal maintenance. Perfect for plant lovers and those seeking unique home decor.',
        'includes' => ['Glass terrarium container', 'Selected plants & moss', 'Specialized soil layers', 'Decorative elements', '6-month care support'],
    ],
    [
        'slug' => 'orchid',
        'title' => 'Orchid Care Masterclass',
        'date' => 'Quarterly (Jan / Apr / Jul / Oct)',
        'time' => 'Full day, 9:00 AM - 5:00 PM',
        'price' => 'RM480 per participant',
        'venue' => 'Sarawak Orchid Park Conservatory',
        'image' => 'img/workshop_4.jpg',
        'summary' => 'Comprehensive orchid care workshop with hands-on repotting, pest identification, bloom planning, and expert guidance from professional horticulturists. Lunch and materials included.',
        'details' => 'An immersive full-day experience with orchid specialists. Visit the conservatory, learn advanced care techniques, understand different orchid varieties, and get personalized advice for your home collection. Limited to 12 participants per session.',
        'includes' => ['Conservatory tour', 'Hands-on repotting', 'Pest management kit', 'Gourmet lunch', 'Orchid starter plant', 'Lifetime consultation access'],
    ],
];

function registration_link(array $workshop): array
{
    $params = ['title' => $workshop['title']];
    $email = $_SESSION['user_email'] ?? '';
    if ($email) {
        $params['email'] = $email;
    }
    $href = 'workshop_reg.php?' . http_build_query($params);
    return [$href, 'Register now'];
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="author" content="Neng Yi Chieng" />
  <title>Root Flowers - Workshops</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="./style/style.css" />
</head>
<body class="rf-page">
  <?php include __DIR__ . '/nav.php'; ?>

  <main class="rf-main">
    <?php if ($flash): ?>
      <div class="alert alert-success" role="status"><?php echo htmlspecialchars($flash); ?></div>
    <?php endif; ?>

    <section class="rf-section" aria-labelledby="workshop-intro">
      <header class="rf-section-header">
        <h1 id="workshop-intro" class="rf-section-title">Floral Workshops & Classes</h1>
        <p class="rf-section-text">Join our expert-led workshops and learn professional floral design techniques. All skill levels welcome - from beginners to experienced florists looking to refine their craft.</p>
      </header>
    </section>

    <section class="rf-section" aria-label="Workshops">
      <div class="accordion accordion-flush" id="workshopsAccordion">
        <?php foreach ($workshops as $index => $workshop):
          [$ctaHref, $ctaLabel] = registration_link($workshop);
          $accordionId = 'workshop-' . $index;
          $isFirst = $index === 0;
        ?>
          <div class="accordion-item workshop-accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button workshop-accordion-button <?php echo !$isFirst ? 'collapsed' : ''; ?>" 
                      type="button" 
                      data-bs-toggle="collapse" 
                      data-bs-target="#<?php echo $accordionId; ?>" 
                      aria-expanded="<?php echo $isFirst ? 'true' : 'false'; ?>" 
                      aria-controls="<?php echo $accordionId; ?>">
                <div class="workshop-header-content">
                  <span class="workshop-number"><?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?></span>
                  <div class="workshop-title-group">
                    <h3 class="workshop-title-text"><?php echo htmlspecialchars($workshop['title']); ?></h3>
                    <span class="workshop-price-badge"><?php echo htmlspecialchars($workshop['price']); ?></span>
                  </div>
                </div>
              </button>
            </h2>
            <div id="<?php echo $accordionId; ?>" 
                 class="accordion-collapse collapse <?php echo $isFirst ? 'show' : ''; ?>" 
                 data-bs-parent="#workshopsAccordion">
              <div class="accordion-body workshop-accordion-body">
                <div class="row g-4">
                  <div class="col-lg-5">
                    <div class="workshop-image-container">
                      <img src="<?php echo htmlspecialchars($workshop['image']); ?>" 
                           alt="<?php echo htmlspecialchars($workshop['title']); ?>" 
                           class="workshop-image">
                      <div class="workshop-image-overlay">
                        <i class="bi bi-mortarboard-fill"></i>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-7">
                    <div class="workshop-details">
                      <p class="workshop-summary"><?php echo htmlspecialchars($workshop['summary']); ?></p>
                      <p class="workshop-description"><?php echo htmlspecialchars($workshop['details']); ?></p>
                      
                      <div class="workshop-info-grid">
                        <div class="workshop-info-item">
                          <i class="bi bi-calendar-event"></i>
                          <div>
                            <span class="info-label">Date</span>
                            <span class="info-value"><?php echo htmlspecialchars($workshop['date']); ?></span>
                          </div>
                        </div>
                        <div class="workshop-info-item">
                          <i class="bi bi-clock"></i>
                          <div>
                            <span class="info-label">Time</span>
                            <span class="info-value"><?php echo htmlspecialchars($workshop['time']); ?></span>
                          </div>
                        </div>
                        <div class="workshop-info-item">
                          <i class="bi bi-geo-alt"></i>
                          <div>
                            <span class="info-label">Venue</span>
                            <span class="info-value"><?php echo htmlspecialchars($workshop['venue']); ?></span>
                          </div>
                        </div>
                      </div>

                      <div class="workshop-includes">
                        <h4 class="includes-title"><i class="bi bi-check-circle-fill me-2"></i>What's Included</h4>
                        <ul class="includes-list">
                          <?php foreach ($workshop['includes'] as $item): ?>
                            <li><i class="bi bi-check2"></i><?php echo htmlspecialchars($item); ?></li>
                          <?php endforeach; ?>
                        </ul>
                      </div>

                      <a class="btn btn-danger btn-lg workshop-cta-button" href="<?php echo htmlspecialchars($ctaHref); ?>">
                        <i class="bi bi-pencil-square me-2"></i><?php echo htmlspecialchars($ctaLabel); ?>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  </main>

  <?php include __DIR__ . '/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
