<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label for="s" class="assistive-text"><?php _e( 'Search', 'paul-kiraly' ); ?></label>
    <div class="input-group mb-3">
        <input type="text" class="form-control" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', 'paul-kiraly' ); ?>" />
        <div class="input-group-append">
            <input type="submit" class="btn btn-outline-info" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'paul-kiraly' ); ?>" />
        </div>
    </div>
</form>