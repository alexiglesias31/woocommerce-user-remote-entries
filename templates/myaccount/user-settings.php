<?php

/**
 * User settings template
 */
defined('ABSPATH') || exit;

do_action('wcure_before_edit_user_settings'); ?>

<form class="wcure-edit-user-settings" action="" method="post" <?php do_action('wcure_edit_user_settings_form_tag'); ?>>

    <?php do_action('wcure_edit_user_settings_start'); ?>

    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="remote_entries_user_settings"><?php esc_html_e('Settings', 'woocommerce-user-remote-entries'); ?>&nbsp;<span class="required">*</span></label>
    </p>
    <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="remote_entries_user_settings" id="remote_entries_user_settings" value="" />
    </p>
    <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
        <button href="#" class="woocommerce-Button button wcure-button-add-setting"><?php esc_html_e('Add setting', 'woocommerce-user-remote-entries'); ?></button>
    </p>
    <div class="clear"></div>

    <?php do_action('wcure_edit_user_settings_form'); ?>


    <?php do_action('wcure_before_user_settings_list'); ?>

    <div class="wcure-user-settings-list-container">
        <ul class="wcure-user-settings-list">
            <?php
            foreach ($settings as $key => $value) {
            ?>
                <li class="wcure-user-settings-list-item" data-setting-key="<?php echo $key; ?>">
                    <a href="#" class="remove">x</a>
                    <p class="wcure-user-settings-list-item-value"><?php echo $value; ?></p>
                </li>
            <?php
            }
            ?>
        </ul>
    </div>
    <div class="clear"></div>
    <?php do_action('wcure_after_user_settings_list'); ?>


    <p clas="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <?php wp_nonce_field('save_remote_entries_settings', 'save-remote-entries-settings-nonce'); ?>
        <button type="submit" class="woocommerce-Button button" name="save_remote_entries_settings" value="<?php esc_attr_e('Save settings', 'woocommerce-user-remote-entries'); ?>"><?php esc_html_e('Save settings', 'woocommerce-user-remote-entries'); ?></button>
        <input type="hidden" name="action" value="save_remote_entries_settings" />
    </p>

    <?php do_action('wcure_edit_user_settings_end'); ?>
</form>

<?php do_action('wcure_after_edit_user_settings'); ?>