var a2lix_libJS = a2lix_libJS || {};

a2lix_libJS.commonModule = (function() {
    var com = {},
        cfg = {};

    com.setConfig = function(initCfg, customCfg)
    {
        for (var c in customCfg) {
            initCfg[c] = customCfg[c];
        }
    };

    return com;
}());

/**
 * Auto manage collection entries
 */
a2lix_libJS.collectionModule = (function(com) {
    var pub = {},
        cfg = {
            $context : null,
            deleteMsg : 'Are you sure ?',
            callbacks : {}
        };

    pub.init = function(customCfg)
    {
        com.setConfig(cfg, customCfg);

        var initNbEntries = cfg.$context.find('.a2lix_collectionEntry').length;
        cfg.$context.on('click', 'a[data-collection-act]', function(evt) {
            evt.preventDefault();

            var $elt = $(this);
            switch ($elt.data('collection-act')) {
                case 'delete':
                    deleteEntry($elt, cfg.deleteMsg);
                    break;
                case 'add':
                    var $newEntry = addEntry($elt, initNbEntries++);

                    // Callback
                    if (cfg.callbacks.afterAddEntry) {
                        cfg.callbacks.afterAddEntry($newEntry);
                    }

                    break;
            }
        });
    };

    var deleteEntry = function($elt, deleteMsg)
    {
        if (confirm(deleteMsg)) {
            $elt.parents('.a2lix_collectionEntry').remove();
        }
    };

    var addEntry = function($elt, incrEntry)
    {
        var $collectionEntryTpl = $($elt.data('collection-tpl')),
            $newDiv = $($collectionEntryTpl.html().replace(/__name__/g, incrEntry));

        return $newDiv.insertBefore($elt);
    };

    return pub;
})(a2lix_libJS.commonModule);


/**
 *
 */
a2lix_libJS.translationsTabsModule = (function(com) {
    var pub = {},
        cfg = {
            $context : $('ul.a2lix_translationsTabsLocales'),
            activeLocale : null
        };

    pub.init = function(customCfg)
    {
        com.setConfig(cfg, customCfg);

        cfg.$context.on('click', 'a[data-translation-locale]', function(evt) {
            evt.preventDefault();
            activeLocaleTab($(this).data('translation-locale'));
        });

        activeLocaleTab(cfg.activeLocale || getFirstLocaleTab());
    };

    var activeLocaleTab = function(locale)
    {
        $('li:has(a[data-translation-locale='+ locale +']), div.a2lix_translationLocale-'+ locale, 'div.a2lix_translationsTabs')
            .addClass('active').siblings().removeClass('active');

        cfg.activeLocale = locale;
    };

    var getFirstLocaleTab = function()
    {
        return cfg.$context.find('li:first a[data-translation-locale]').data('translation-locale');
    };

    return pub;
})(a2lix_libJS.commonModule);