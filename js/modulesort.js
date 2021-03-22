/*global gdn, jQuery*/

jQuery(($) => {
    const lists = $('ol.modulesort');

    const update = () => {
        const modules = {};

        lists.each((ignore, list) => {
            modules[$(list).data('appname')] = {
                Panel: $('li', list).map((ignore, item) => $(item).data('name')).get()
            };
        });

        $.post(gdn.url('settings/modulesort.json'), {
            Modules: JSON.stringify(modules),
            TransientKey: gdn.definition('TransientKey')
        });
    };

    lists.sortable({forcePlaceholderSize: true}).on('sortupdate', update);

    $('.modulesort-add').submit(({currentTarget}) => {
        const $this = $(currentTarget);
        const input = $this.find('.form-control');
        const list = $('ol.sort-' + $this.data('group'));

        $('.modulesort-dummy li')
            .clone().data('name', input.val())
            .find('.plank-title').text(input.val())
            .end().prependTo(list);

        list.sortable();
        input.val('');
        update();

        return false;
    });

    lists.on('click', '.modulesort-remove', ({currentTarget}) => {
        $(currentTarget).closest('li').remove();
        update();
    });
});
