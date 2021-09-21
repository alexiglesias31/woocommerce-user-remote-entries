jQuery(function ($) {
    /*****************
     * General Section
     *****************/
    // wcure_params is required to continue, ensure the object exists
    if (typeof wcure_params === "undefined") {
        return false;
    }

    var ajaxUrl = wcure_params.ajax_url;

    /*****************
     * User Settings Section
     *****************/
    /**
     * Object to handle the settings form
     */
    var settings_form = {
        /**
         * Initialize event handlers
         */
        init: function (settings_list) {
            this.add_setting = this.add_setting.bind(this);
            this.remove_setting = this.remove_setting.bind(this);
            this.save_settings = this.save_settings.bind(this);

            this.settings_list = settings_list;
            this.input_field = $(document.body).find(
                'input[name="remote_entries_user_settings"]'
            );

            $(document).on(
                "click",
                ".wcure-button-add-setting",
                this.add_setting
            );

            $(document).on(
                "click",
                ".wcure-user-settings-list-item a.remove",
                this.remove_setting
            );

            $(document).on(
                "click",
                '.button[name="save_remote_entries_settings"]',
                this.save_settings
            );
        },
        /*
         * Add new item to settings
         */
        add_setting: function (evt) {
            evt.preventDefault();
            if (this.input_field.val()) {
                this.settings_list.create_setting(this.input_field.val());
                this.input_field.val("");
            }
        },
        /*
         * Remove item from settings
         */
        remove_setting: function (evt) {
            evt.preventDefault();
            var item = $(evt.target).parent("li.wcure-user-settings-list-item");
            this.settings_list.remove_setting(item.data("setting-key"));
        },
        /**
         * Save settings
         */
        save_settings: function (evt, allowEvt) {
            if (allowEvt === true) {
                return;
            }
            evt.preventDefault();
            clear_notices();
            var data = {
                action: "wcure_update_user_settings",
                data: this.settings_list.get_settings(),
                nonce: $(
                    'input[name="save-remote-entries-settings-nonce"]'
                ).val(),
            };
            $.ajax({
                type: "post",
                url: ajaxUrl,
                data: data,
                dataType: "json",
                success: function () {
                    $(evt.target).trigger("click", true);
                },
                error: function (error) {
                    show_notice(error.responseJSON.data.error);
                },
            });
        },
    };

    /**
     * Object to handle the settings list
     */
    var settings_list = {
        /**
         * Initialize the UI state
         */
        init: function () {
            this.create_setting = this.create_setting.bind(this);
            this.get_setting_id = this.get_setting_id.bind(this);
            this.get_settings = this.get_settings.bind(this);
            this.update_settings = this.update_settings.bind(this);

            this.list_element = $(".wcure-user-settings-list");
            this.update_settings();
        },
        /**
         * Create new setting item
         */
        create_setting: function (value) {
            var new_item = `
            <li class="wcure-user-settings-list-item" data-setting-key="${this.get_setting_id()}">
                <a href="#" class="remove">x</a>
                <p class="wcure-user-settings-list-item-value">${value}</p>
            </li>`;
            this.list_element.append(new_item);
            this.update_settings();
        },
        /**
         * Remove specified settings from list
         */
        remove_setting: function (item_id) {
            setting_item.remove(item_id);
            this.update_settings();
        },
        /**
         * Get the number of current settings
         */
        get_setting_id: function () {
            return this.settings.length;
        },
        /**
         * Get the current settings into the state
         */
        get_settings: function () {
            return this.settings.reduce((acc, item_id) => {
                acc[item_id] = setting_item.value(item_id);
                return acc;
            }, {});
        },
        /**
         * Update the current settings into the state
         */
        update_settings: function () {
            var settings = [];
            this.list_element
                .children(".wcure-user-settings-list-item")
                .each(function (index) {
                    $(this).attr("data-setting-key", index);
                    settings.push(index);
                });
            this.settings = settings;
        },
    };

    /**
     * Methods to handle a service_item
     */
    var setting_item = {
        is_item: function (item_id) {
            var item = $(".wcure-user-settings-list").find(
                `.wcure-user-settings-list-item[data-setting-key="${item_id}"]`
            );
            return item !== undefined ? true : false;
        },
        value: function (item_id) {
            var item = $(".wcure-user-settings-list").find(
                `.wcure-user-settings-list-item[data-setting-key="${item_id}"]`
            );
            return item.find(".wcure-user-settings-list-item-value").text();
        },
        remove: function (item_id) {
            var item = $(".wcure-user-settings-list").find(
                `.wcure-user-settings-list-item[data-setting-key="${item_id}"]`
            );
            item.remove();
        },
    };

    settings_form.init(settings_list);
    settings_list.init();

    /*****************
     * Remote Entries Section
     *****************/
    var remote_entries_object = {
        /**
         * Initialize the UI state
         */
        init: function () {
            this.get_entries = this.get_entries.bind(this);
            this.populate_entries = this.populate_entries.bind(this);

            this.entries_container = $(".wcure-remote-entries-container");

            this.get_entries();
        },
        /**
         * Get remote entries via Ajax
         */
        get_entries: function () {
            var data = {
                action: "wcure_get_remote_entries",
            };
            $.ajax({
                type: "get",
                url: ajaxUrl,
                data: data,
                dataType: "json",
                success: function (response) {
                    $(".wcure-remote-entries-container").html(response);
                },
                error: function (error) {
                    $(".woocommerce-notices-wrapper").html(error);
                },
            });
        },
        /**
         * Populate remote entries
         */
        populate_entries: function (data) {
            var html = "";
            Object.keys(data).forEach(function (key) {
                html += `
                <li class="wcure-remote-entries-item">
                ${key}: ${data[key]}
                </li>`;
            });
            $("ul.wcure-remote-entries-list").html(html);
        },
    };

    remote_entries_object.init();

    /**
     * Show message as woocommerce notice
     */
    function show_notice(message, type = "error") {
        $(".woocommerce-notices-wrapper:first").prepend(
            `<div class="woocommerce-${type}">
                ${message}
            </div>`
        );
    }

    function clear_notices() {
        $(".woocommerce-notices-wrapper:first").html("");
    }
});
