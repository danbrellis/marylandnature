<?php

// If this file is called directly, abort.
if ( ! defined('WPINC')) {
    die;
}

?><h2>WP Pusher Plugins</h2>

<hr>
<br>

<div class="theme-browser rendered">
    <div class="themes">
        <?php foreach ($plugins as $plugin) { ?>
        <div class="theme wppusher-package" tabindex="0">
            <h3 class="theme-name repo-name"><i class="fa <?php echo getHostIcon($plugin->host); ?>"></i>&nbsp; <?php echo $plugin->repository; ?></h3>
            <div class="theme-screenshot package-info">
                <div class="content">
                    <h3><?php echo $plugin->name; ?></h3>
                    <p><i class="fa fa-code-fork"></i> Branch: <code><?php echo $plugin->repository->getBranch(); ?></code></p>
                    <p>Push-to-Deploy: <code><?php echo ($plugin->pushToDeploy) ? 'enabled' : 'disabled'; ?></code></p>
                    <p>Push-to-Deploy URL:<br><input style="width: 80%;" type="text" value="<?php echo $plugin->getPushToDeployUrl(); ?>"></p>
                    <?php if ($plugin->hasSubdirectory()) { ?>
                        <p>Subdirectory: <code><?php echo $plugin->getSubdirectory(); ?></code></p>
                    <?php } ?>
                    <form action="" method="POST">
                        <?php wp_nonce_field('update-plugin'); ?>
                        <input type="hidden" name="wppusher[action]" value="update-plugin">
                        <input type="hidden" name="wppusher[repository]" value="<?php echo $plugin->repository; ?>">
                        <input type="hidden" name="wppusher[file]" value="<?php echo $plugin->file; ?>">
                        <button type="submit" class="button button-primary button-update-package"><i class="fa fa-refresh"></i>&nbsp; Update plugin</button>
                    </form>
                    <a href="?page=wppusher-plugins&package=<?php echo urlencode($plugin->file); ?>" type="submit" class="button button-secondary button-save-package"><i class="fa fa-wrench"></i>&nbsp; Edit plugin</a>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="theme add-new-theme">
            <a href="?page=wppusher-plugins-create">
                <div class="theme-screenshot"><span></span></div>
                <h3 class="theme-name">Install New Plugin</h3>
            </a>
        </div>
    </div>
    <br class="clear">
</div>
