<?php
require_once __DIR__ . '/auth.php';
startSessionIfNeeded();
requireLogin('workshops.php');
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
$workshops = [
    [
        'slug' => 'hand-tied',
        'title' => 'Hand-tied Bouquet Lab',
        'date' => 'Every Saturday',
        'time' => '9:30 AM - 12:30 PM',
        'price' => 'RM220 per participant',
        'venue' => 'Root Flowers Studio, Kuching',
        'summary' => 'Learn stem preparation, spiral binding, and finishing techniques. Includes all flowers and a take-home guide.',
    ],
    [
        'slug' => 'tablescape',
        'title' => 'Modern Tablescapes Intensive',
        'date' => 'First Sunday each month',
        'time' => '2:00 PM - 6:00 PM',
        'price' => 'RM320 per participant',
        'venue' => 'Jalan Song Event Loft',
        'summary' => 'Build layered centrepieces, candle-safe styling, and transport plans for dining events.',
    ],
    [
        'slug' => 'terrarium',
        'title' => 'Closed Terrarium Study',
        'date' => 'Alternate Wednesdays',
        'time' => '7:30 PM - 9:30 PM',
        'price' => 'RM180 per participant',
        'venue' => 'Root Flowers Studio Lab Room',
        'summary' => 'Create a sealed terrarium while learning humidity cycles, plant pairing, and long-term care.',
    ],
    [
        'slug' => 'orchid',
        'title' => 'Orchid Care Masterclass',
        'date' => 'Quarterly (Jan / Apr / Jul / Oct)',
        'time' => 'Full day, 9:00 AM - 5:00 PM',
        'price' => 'RM480 per participant',
        'venue' => 'Sarawak Orchid Park Conservatory',
        'summary' => 'Hands-on orchid repotting, pest management, and bloom planning with guest horticulturists.',
    ],
];

function registration_link(array $workshop): array
{
    $params = ['title' => $workshop['title']];
    $email = currentUser();
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
        <h1 id="workshop-intro" class="rf-section-title">Workshops overview</h1>
        <p class="rf-section-text">Venue, schedule, and pricing details for every Root Flowers workshop. Use the links below to secure a spot.</p>
      </header>
    </section>

    <section class="rf-section" aria-label="Workshops">
      <div class="rf-grid">
        <?php foreach ($workshops as $workshop):
          [$ctaHref, $ctaLabel] = registration_link($workshop);
        ?>
          <article class="rf-card">
            <div class="rf-card-body">
              <div class="rf-card-top">
                <span class="rf-card-icon" data-icon="W"></span>
                <span class="rf-card-label">Workshop</span>
              </div>
              <h2 class="rf-card-title"><?php echo htmlspecialchars($workshop['title']); ?></h2>
              <dl class="rf-list">
                <div><dt>Date</dt><dd><?php echo htmlspecialchars($workshop['date']); ?></dd></div>
                <div><dt>Time</dt><dd><?php echo htmlspecialchars($workshop['time']); ?></dd></div>
                <div><dt>Price</dt><dd><?php echo htmlspecialchars($workshop['price']); ?></dd></div>
                <div><dt>Venue</dt><dd><?php echo htmlspecialchars($workshop['venue']); ?></dd></div>
              </dl>
              <p class="rf-card-text"><?php echo htmlspecialchars($workshop['summary']); ?></p>
              <a class="rf-button rf-button-block" href="<?php echo htmlspecialchars($ctaHref); ?>"><?php echo htmlspecialchars($ctaLabel); ?></a>
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
