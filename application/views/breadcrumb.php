<nav aria-label="breadcrumb" class="breadcrumb flat">
    <!-- <ol class="breadcrumb"> -->
    <?php 
    /*foreach ($breadcrumbs as $breadcrumb) { 
         echo '<li class="breadcrumb-item ' . ($breadcrumb->isActive == true ? 'active " aria-current="page"' : '"') . '>'.
         (isset($breadcrumb->link) ? '<a href="'.$breadcrumb->link .'">'. $breadcrumb->title. '</a>': '<a href="#">'.$breadcrumb->title.'</a>') .'</li>';
    }*/
    ?>
    <!-- </ol> -->

    <!-- <div class="breadcrumb flat"> -->
    <?php 
        foreach ($breadcrumbs as $breadcrumb) { 
         echo '<a class=" ' . ($breadcrumb->isActive == true ? 'active " aria-current="page"' : '"') .
         (isset($breadcrumb->link) ? ' href="'.$breadcrumb->link .'" ': ' '). '>'.$breadcrumb->title.'</a>';
    }
    ?>
    <!-- <a class="" href="#">test</a>
    <a class="" href="#">test</a>
    <a class="" href="#">test</a> -->
  
<!-- </div> -->
</nav>