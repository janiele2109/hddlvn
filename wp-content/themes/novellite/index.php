<?php
/**
* The main template file.
*
* This is the most generic template file in a WordPress theme
* and one of the two required files for a theme (the other being style.css).
* It is used to display a page when nothing more specific matches a query. 
* E.g., it puts together the home page when no home.php file exists.
* Learn more: http://codex.wordpress.org/Template_Hierarchy
*
*/
?>
<?php get_header(); ?> 
<?php      
// slider template
get_template_part( 'template/home','slider'); 

    //-- All section loop --
    $section = array('section_three_column','section_testimonial','section_woo',
    'section_blog','section_team','section_pricing','section_countactus');

        foreach(get_theme_mod('home_sorting',$section) as $value):
        get_template_part( 'template/'.$value); 
        endforeach;
?>
    <div id ="slspeed" sliderspeed="<?php if ((get_theme_mod('second_slider_image') != '') ) { echo true; } else { echo false;  } ?>"></div>
<?php get_footer(); ?>