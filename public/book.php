<?php 
    global $mydb;

    // Inputs (support existing ?category=... links, plus new ?search=...&sort=...)
    $category = isset($_GET['category']) ? $_GET['category'] : '';
    $search   = isset($_GET['search']) ? $_GET['search'] : '';
    $sort     = isset($_GET['sort']) ? $_GET['sort'] : 'top';
    $page     = isset($_GET['page']) ? $_GET['page'] : 1;

    $category = $mydb->escape_value($category);
    $search   = $mydb->escape_value($search);
    $sort     = $mydb->escape_value($sort);
    $page     = max(1, (int)$page);

    $no_of_records_per_page = 12;
    $offset = ($page - 1) * $no_of_records_per_page;

    $where = "Status='Available'";
    if ($category !== '') {
      $where .= " AND Category LIKE '%{$category}%'";
    }
    if ($search !== '') {
      $where .= " AND (BookTitle LIKE '%{$search}%' OR Author LIKE '%{$search}%' OR IBSN LIKE '%{$search}%')";
    }

    $orderBy = "BookTitle ASC"; // fallback
    switch ($sort) {
      case 'title_az':
        $orderBy = "BookTitle ASC";
        break;
      case 'title_za':
        $orderBy = "BookTitle DESC";
        break;
      case 'newest':
        $orderBy = "PublishDate DESC";
        break;
      case 'oldest':
        $orderBy = "PublishDate ASC";
        break;
      case 'top':
      default:
        // No rating field exists; keep stable ordering for now
        $orderBy = "BookTitle ASC";
        break;
    }

    // total rows
    $total_pages_sql = "SELECT IBSN FROM tblbooks WHERE {$where}";
    $mydb->setQuery($total_pages_sql);
    $curCount = $mydb->executeQuery();
    $total_rows = $mydb->num_rows($curCount);
    $total_pages = (int)ceil($total_rows / $no_of_records_per_page);

    // page rows
    $sql = "SELECT * FROM tblbooks WHERE {$where} ORDER BY {$orderBy} LIMIT {$offset}, {$no_of_records_per_page}";
    $mydb->setQuery($sql);
    $cur = $mydb->loadResultlist();
?>

<div class="books-v2">
  <div class="container">
    <header class="books-v2__header">
      <h1 class="books-v2__title">Explore Our Collection</h1>
      <p class="books-v2__subtitle">
        Discover thousands of books across all genres. Search, filter, and find your next favorite read.
      </p>

      <form class="books-v2__filters" action="index.php" method="GET" autocomplete="off">
        <input type="hidden" name="q" value="books" />

        <div class="books-v2__search">
          <i class="fa fa-search books-v2__search-icon" aria-hidden="true"></i>
          <input
            class="books-v2__search-input"
            type="text"
            name="search"
            value="<?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>"
            placeholder="Search by Title, Author, or ISBN..."
            aria-label="Search by Title, Author, or ISBN"
          />
        </div>

        <div class="books-v2__selects">
          <label class="books-v2__select">
            <span class="books-v2__select-label">Genre:</span>
            <select name="category" onchange="this.form.submit()">
              <option value="">ALL</option>
              <?php
                $catObj = new Category();
                $cats = $catObj->listOfcategory();
                foreach ($cats as $cat) {
                  $val = $cat->Category;
                  $selected = ($category !== '' && $category === $val) ? ' selected' : '';
                  echo '<option value="'.htmlspecialchars($val, ENT_QUOTES, 'UTF-8').'"'.$selected.'>'
                        .htmlspecialchars($val, ENT_QUOTES, 'UTF-8').
                      '</option>';
                }
              ?>
            </select>
          </label>

          <label class="books-v2__select">
            <span class="books-v2__select-label">Sort:</span>
            <select name="sort" onchange="this.form.submit()">
              <option value="top" <?php echo ($sort === 'top') ? 'selected' : ''; ?>>Top Rated</option>
              <option value="newest" <?php echo ($sort === 'newest') ? 'selected' : ''; ?>>Newest</option>
              <option value="oldest" <?php echo ($sort === 'oldest') ? 'selected' : ''; ?>>Oldest</option>
              <option value="title_az" <?php echo ($sort === 'title_az') ? 'selected' : ''; ?>>Title (A–Z)</option>
              <option value="title_za" <?php echo ($sort === 'title_za') ? 'selected' : ''; ?>>Title (Z–A)</option>
            </select>
          </label>
        </div>
      </form>
    </header>

    <section class="books-v2__grid" aria-label="Books">
      <?php if (!empty($cur)) { ?>
        <?php foreach ($cur as $result) {
          $coverWebPath = "asset/images/covers/" . $result->IBSN . ".jpg";
          $coverFsPath  = __DIR__ . '/' . $coverWebPath;
          if (!file_exists($coverFsPath)) {
            $coverWebPath = "asset/images/covers/default.jpg";
          }

          $desc = (string)($result->BookDesc ?? '');
          if (strlen($desc) > 140) {
            $desc = substr($desc, 0, 140) . '...';
          }
        ?>
          <article class="books-v2__card">
            <div class="books-v2__cover">
              <img
                src="<?php echo htmlspecialchars($coverWebPath, ENT_QUOTES, 'UTF-8'); ?>"
                alt="<?php echo htmlspecialchars($result->BookTitle, ENT_QUOTES, 'UTF-8'); ?>"
                loading="lazy"
              />
            </div>

            <div class="books-v2__card-body">
              <div class="books-v2__pill">
                <?php echo htmlspecialchars($result->Category, ENT_QUOTES, 'UTF-8'); ?>
              </div>

              <h3 class="books-v2__book-title">
                <?php echo htmlspecialchars($result->BookTitle, ENT_QUOTES, 'UTF-8'); ?>
              </h3>

              <div class="books-v2__author">
                <?php echo htmlspecialchars($result->Author, ENT_QUOTES, 'UTF-8'); ?>
              </div>

              <p class="books-v2__desc">
                <?php echo htmlspecialchars($desc, ENT_QUOTES, 'UTF-8'); ?>
              </p>
            </div>

            <div class="books-v2__card-footer">
              <a class="books-v2__btn" href="index.php?q=bookdetails&id=<?php echo urlencode($result->IBSN); ?>">
                <i class="fa fa-eye" aria-hidden="true"></i>
                View Details
              </a>
            </div>
          </article>
        <?php } ?>
      <?php } else { ?>
        <div class="books-v2__empty">
          No books found.
        </div>
      <?php } ?>
    </section>

    <?php if ($total_pages > 1) { ?>
      <nav class="books-v2__pager" aria-label="Pagination">
        <?php
          $base = "index.php?q=books"
                . "&category=" . urlencode($category)
                . "&search=" . urlencode($search)
                . "&sort=" . urlencode($sort);
        ?>
        <a class="books-v2__page <?php echo ($page <= 1) ? 'is-disabled' : ''; ?>"
           href="<?php echo ($page <= 1) ? '#' : ($base . "&page=" . ($page - 1)); ?>">
          Prev
        </a>

        <span class="books-v2__page-info">
          Page <?php echo (int)$page; ?> of <?php echo (int)$total_pages; ?>
        </span>

        <a class="books-v2__page <?php echo ($page >= $total_pages) ? 'is-disabled' : ''; ?>"
           href="<?php echo ($page >= $total_pages) ? '#' : ($base . "&page=" . ($page + 1)); ?>">
          Next
        </a>
      </nav>
    <?php } ?>
  </div>
</div>


