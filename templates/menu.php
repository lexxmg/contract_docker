<ul class="header-menu__list header-menu-list">
  <?php foreach (arraySort($array, $key, $sort) as $key => $value): ?>
    <li class="header-menu-list__item">
      <a class="<?= isCurrentUrl($value['path']) 
          ? 'header-menu-list__link  header-menu-list__link--active'
          : 'header-menu-list__link'?>"
          href="<?=$value['path']?>"
      >
        <?= $value['title'] ?>
      </a>
    </li>
  <?php endforeach; ?> 
</ul>
