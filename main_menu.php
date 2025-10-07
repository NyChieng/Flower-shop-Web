<?php
require_once __DIR__ . '/auth.php';
startSessionIfNeeded();
requireLogin('main_menu.php');

$firstName = trim($_SESSION['first_name'] ?? ($_SESSION['user_name'] ?? 'Friend'));
if ($firstName === '') {
    $firstName = 'Friend';
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$portalCards = [
    [
        'icon' => 'P',
        'title' => 'Products showcase',
        'text'  => 'Preview bouquet collections, event styling packages, and gift ideas ready for enquiry.',
        'href'  => 'products.php',
        'cta'   => 'Open products',
        'disabled' => false,
    ],
    [
        'icon' => 'W',
        'title' => 'Workshop schedule',
        'text'  => 'Check upcoming sessions, venues, pricing, and reserve your seat in a few clicks.',
        'href'  => 'workshops.php',
        'cta'   => 'Open workshops',
        'disabled' => false,
    ],
    [
        'icon' => 'S',
        'title' => 'Student works gallery',
        'text'  => 'Browse completed arrangements and inspiration from Root Flowers workshop graduates.',
        'href'  => 'studentworks.php',
        'cta'   => 'Open gallery',
        'disabled' => false,
    ],
    [
        'icon' => 'AI',
        'title' => 'Flower name lookup (soon)',
        'text'  => 'Assignment 2 feature: upload a flower photo to receive species and pricing information.',
        'href'  => '#',
        'cta'   => 'Coming soon',
        'disabled' => true,
    ],
];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Root Flowers - Main Menu</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="./style/style.css" />
</head>
<body class="rf-page">
  <header class="py-3 border-bottom">
    <div class="container d-flex justify-content-between align-items-center">
      <a class="brand-text fw-semibold text-decoration-none" href="index.php">Root Flowers</a>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-dark btn-sm" href="index.php">Home</a>
        <a class="btn btn-secondary btn-sm" href="logout.php">Logout</a>
      </div>
    </div>
  </header>

  <main class="rf-main" id="main-content">
    <?php if ($flash): ?>
      <div class="rf-alert" role="status"><?php echo htmlspecialchars($flash, ENT_QUOTES); ?></div>
    <?php endif; ?>

    <section class="rf-hero" aria-labelledby="portal-title">
      <div class="rf-hero-content">
        <span class="rf-pill">Main menu</span>
        <h1 id="portal-title" class="rf-title">Hi <?php echo htmlspecialchars($firstName, ENT_QUOTES); ?>, where to next?</h1>
        <p class="rf-subtitle">
          Jump into the live Assignment&nbsp;1 sections. Active pages are highlighted; upcoming features stay grey until Assignment&nbsp;2.
        </p>

        <div class="rf-hero-actions">
          <a class="rf-button" href="products.php">Products</a>
          <a class="rf-button rf-button-outline" href="workshops.php">Workshops</a>
          <a class="rf-button rf-button-outline" href="studentworks.php">Student works</a>
        </div>
      </div>
    </section>

    <section class="rf-section" aria-labelledby="quick-actions">
      <header class="rf-section-header">
        <h2 id="quick-actions" class="rf-section-title">Choose a destination</h2>
        <p class="rf-section-text">Unavailable cards appear greyed out to indicate they are still in development.</p>
      </header>

      <div class="rf-grid">
        <?php foreach ($portalCards as $card):
          $disabled = !empty($card['disabled']);
          $buttonClass = 'rf-button rf-button-block' . ($disabled ? ' rf-button-disabled' : '');
          $href = $disabled ? '#' : $card['href'];
        ?>
          <article class="rf-card<?php echo $disabled ? ' rf-card-disabled' : ''; ?>">
            <div class="rf-card-body">
              <div class="rf-card-top">
                <span class="rf-card-icon" data-icon="<?php echo htmlspecialchars($card['icon'], ENT_QUOTES); ?>"></span>
              </div>
              <h3 class="rf-card-title"><?php echo htmlspecialchars($card['title'], ENT_QUOTES); ?></h3>
              <p class="rf-card-text"><?php echo htmlspecialchars($card['text'], ENT_QUOTES); ?></p>
              <a class="<?php echo $buttonClass; ?>" href="<?php echo htmlspecialchars($href, ENT_QUOTES); ?>"<?php echo $disabled ? ' aria-disabled="true"' : ''; ?>>
                <?php echo htmlspecialchars($card['cta'], ENT_QUOTES); ?>
              </a>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </section>
  </main>

  <?php include __DIR__ . '/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
