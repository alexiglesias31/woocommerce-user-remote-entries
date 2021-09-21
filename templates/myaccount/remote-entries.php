<?php

/**
 * Remote entries template
 */
defined('ABSPATH') || exit;

do_action('wcure_before_remote_entries');

do_action('wcure_before_remote_entries_title'); ?>
<p class="wcure-remote-entries-title">
    <?php echo __('Remote Data:', 'woocommerce-user-remote-entries'); ?>
</p>
<?php do_action('wcure_after_remote_entries_title'); ?>

<?php
if (empty($data)) {
?>
    <p class="woocommerce-error"><?php echo __('There was a problem getting the data. Please try again later', 'woocommerce-user-remote-entries'); ?></p>
<?php
} else {
?>
    <ul class="wcure-remote-entries-list">
        <?php
        foreach ($data as $id => $value) {
        ?>
            <li class="wcure-remote-entries-item">
                <span class="wcure-remote-entries-item-title"><?php echo $id; ?>: </span>
                <span class="wcure-remote-entries-item-value"><?php echo $value; ?></span>
            </li>
        <?php
        }
        ?>
    </ul>
<?php
}

do_action('wcure_after_remote_entries');
