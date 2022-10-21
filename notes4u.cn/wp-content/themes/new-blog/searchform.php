<?php

/*
This is search form which overide the deafult one.
*/
?>
<div class="sidenav-header"  action="<?php echo esc_url(home_url());?>">
        <form class="search-form"  action="<?php echo esc_url(home_url());?>" >
          <input name="s" value=" <?php get_search_query() ?>" class="form-control mr-sm-2" type="search" placeholder="<?php echo esc_attr_x( 'Search;', 'placeholder', 'new-blog' ); ?>"" aria-label="Search">
          <button class="btn search-submit" type="submit"><span class="fa fa-search" aria-hidden="true"></span></button>
        </form>
</div>