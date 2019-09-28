<nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="padding: 12px;">
    <?php foreach ($breadcrumbs as $breadcrumb) { 
         echo '<li class="breadcrumb-item ' . ($breadcrumb->isActive == true ? 'active " aria-current="page"' : '"') . '>'.
         (isset($breadcrumb->link) ? '<a href="'.$breadcrumb->link .'">'. $breadcrumb->title. '</a>': $breadcrumb->title) .'</li>';
    }
    ?>
    </ol>
</nav>