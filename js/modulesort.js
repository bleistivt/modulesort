/*global gdn, jQuery*/

jQuery(function ($) {
    'use strict';

    var lists = $('ol.Sortable'),
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

    $('.AddModule').submit(function (e) {
        var $this = $(e.currentTarget),
            input = $this.find('.InputBox'),
            list = $('ol.Sort-' + $this.data('group'));

        $('.Dummy li')
            .clone().data('name', input.val())
            .find('.Name').text(input.val())
            .end().prependTo(list);

        list.sortable();
        input.val('');
        update();

        return false;
    });

    $('.RemoveModule').click(function (e) {
        $(e.currentTarget).closest('li').remove();
        update();
    });

});
