/*global gdn, jQuery*/

jQuery(function ($) {
    'use strict';

    var lists = $('ol.modulesort'),
        update = function () {
            var modules = {};

            lists.each(function (ignore, list) {
                modules[$(list).data('appname')] = {
                    Panel: $('li', list).map(function (ignore, item) {
                        return $(item).data('name');
                    }).get()
                };
            });

            $.post(gdn.url('settings/modulesort.json'), {
                Modules: JSON.stringify(modules),
                TransientKey: gdn.definition('TransientKey')
            });
        };

    lists.sortable({forcePlaceholderSize: true}).on('sortupdate', update);

    $('.modulesort-add').submit(function (e) {
        var $this = $(e.currentTarget),
            input = $this.find('.form-control'),
            list = $('ol.sort-' + $this.data('group'));

        $('.modulesort-dummy li')
            .clone().data('name', input.val())
            .find('.plank-title').text(input.val())
            .end().prependTo(list);

        list.sortable();
        input.val('');
        update();

        return false;
    });

    lists.on('click', '.modulesort-remove', function (e) {
        $(e.currentTarget).closest('li').remove();
        update();
    });

});
