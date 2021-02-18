<?php

/**
 * Template Name: Pagina Home
 *
 * @package weride
 * @subpackage weride-mk01-theme
 * @since Mk. 1.0
 */
?>
<?php get_header(); ?>
<?php the_post(); ?>
<main class="container-fluid p-0" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
    <div class="row no-gutters">
        <div class="main-elementor-container col-12">
            <?php the_content(); ?>
        </div>
    </div>
</main>
<?php get_footer(); ?>