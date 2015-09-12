<?php if (!defined('APPLICATION')) exit();

$item = '<li data-name="%1$s"><div><table><tr>'
        .'<td class="Name">%1$s</td>'
        .'<td class="Buttons"><button class="SmallButton RemoveModule">'.t('Remove').'</button></td>'
        .'</tr></table></div></li>';

echo wrap($this->data('Title'), 'h1');

echo '<div class="Info">',
    wrap(t('Drag & drop modules to sort them. Removing modules from the list does not make them disappear, it just removes them from the defined sort order.'), 'p'),
    wrap(t('Your settings are saved automatically.').'<br>'.anchor(t('Restore defaults'), 'settings/modulesort/reset', 'Hijack'), 'p'),
    '</div>';

foreach (array_keys(c('EnabledApplications')) as $app) {
    echo '<form class="AddModule" data-group="'.$app.'" style="float:right;padding:6px;">',
        '<input type="text" class="InputBox" placeholder="'.t('Add module...').'">',
        '<button class="Button">'.t('Add').'</button>',
        '</form>',
        wrap($app, 'h1'),
        '<ol class="Sortable Sort-'.$app.'" data-appname="'.$app.'">';
    foreach (c('Modules.'.$app.'.Panel', []) as $module) {
        echo sprintf($item, $module);
    }
    echo '</ol>';
}

echo '<div class="Hidden Dummy">'.sprintf($item, '').'</div>';
