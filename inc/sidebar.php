 <?php
 $queryMainMenu = mysqli_query($config, "SELECT * FROM menus WHERE parent_id = 0 OR parent_id = ''");
 $rowMainMenu = mysqli_fetch_all($queryMainMenu, MYSQLI_ASSOC);
 ?> 
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <?php foreach($rowMainMenu as $mainMenu): ?>

        <?php
          $id_menu = $mainMenu['id'];
          $querySubMenu = mysqli_query($config, "SELECT * FROM menus WHERE parent_id = '$id_menu' ORDER BY urutan ASC");
        ?>

        <?php if(mysqli_num_rows($querySubMenu) > 0): ?>

        <li class="nav-item"> 
          <a class="nav-link collapsed" data-bs-target="#menu-<?= $mainMenu['id'] ?>" data-bs-toggle="collapse" href="#">
            <i class="<?= $mainMenu['icon'] ?>"></i><span><?= $mainMenu['name'] ?></span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="menu-<?= $mainMenu['id'] ?>" class="nav-content collapse " data-bs-parent="#sidebar-nav">

          <?php while($rowSubMenu = mysqli_fetch_assoc($querySubMenu)): ?>  
            <li>
              <a href="?page=<?= $rowSubMenu['url'] ?>">
                <i class="<?= $rowSubMenu['icon'] ?>"></i><span><?= $rowSubMenu['name'] ?></span>
              </a>
            </li>
          <?php endwhile?>
          </ul>
        </li>

        <li class="nav-heading">Transaction</li>

            <?php elseif(!empty($mainMenu['url'])): ?>
              <?php $url = $mainMenu['url']?>
              
              <li class="nav-item">
                <a class="nav-link collapsed" href="<?= strpos($mainMenu['url'], '.php') !== false ? $url : "?page=$url" ?>">
                  <i class="<?= $mainMenu['icon'] ?>"></i>
                  <span><?= $mainMenu['name'] ?></span>
                </a>
              </li>

        <?php endif ?>
      <?php endforeach?>

        <!-- <li class="nav-heading">Transaction</li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="?page=modul">
            <i class="bi bi-book"></i>
            <span>Moduls</span>
          </a>
        </li>End Profile Page Nav -->


    </ul>

  </aside><!-- End Sidebar-->