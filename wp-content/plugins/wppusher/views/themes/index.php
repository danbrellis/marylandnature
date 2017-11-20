<?php

// If this file is called directly, abort.
if ( ! defined('WPINC')) {
    die;
}

?><h2>WP Pusher Themes</h2>

<hr>
<br>

<div class="theme-browser rendered">
    <div class="themes">
        <?php foreach ($themes as $theme) { ?>
            <div class="theme wppusher-package" tabindex="0">
                <h3 class="theme-name repo-name"><i class="fa <?php echo getHostIcon($theme->host); ?>"></i>&nbsp; <?php echo $theme->repository; ?></h3>
                <div class="theme-screenshot package-info">
                    <div class="content">
                        <h3><?php echo $theme->name; ?></h3>
                        <p><i class="fa fa-code-fork"></i> Branch: <code><?php echo $theme->repository->getBranch(); ?></code></p>
                        <p>Push-to-Deploy: <code><?php echo ($theme->pushToDeploy) ? 'enabled' : 'disabled'; ?></code></p>
                        <p>Push-to-Deploy URL:<br><input style="width: 80%;" type="text" value="<?php echo $theme->getPushToDeployUrl(); ?>"></p>
                        <?php if ($theme->hasSubdirectory()) { ?>
                            <p>Subdirectory: <code><?php echo $theme->getSubdirectory(); ?></code></p>
                        <?php } ?>
                        <form action="" method="POST">
                            <?php wp_nonce_field('update-theme'); ?>
                            <input type="hidden" name="wppusher[action]" value="update-theme">
                            <input type="hidden" name="wppusher[repository]" value="<?php echo $theme->repository; ?>">
                            <input type="hidden" name="wppusher[stylesheet]" value="<?php echo $theme->stylesheet; ?>">
                            <button type="submit" class="button button-primary button-update-package"><i class="fa fa-refresh"></i>&nbsp; Update theme</button>
                        </form>
                        <a href="?page=wppusher-themes&package=<?php echo urlencode($theme->stylesheet); ?>" type="submit" class="button button-secondary button-save-package"><i class="fa fa-wrench"></i>&nbsp; Edit theme</a>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="theme add-new-theme">
            <a href="?page=wppusher-themes-create">
                <div class="theme-screenshot"><span></span></div>
                <h3 class="theme-name">Install New Theme</h3>
            </a>
        </div>
    </div>
    <br class="clear">
</div>
