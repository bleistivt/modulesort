<?php if (!defined('APPLICATION')) exit();

$item = '<li data-name="%1$s"><div class="plank" style="cursor:grab;">'
        .'<div class="plank-title">%1$s</div>'
        .'<div class="plank-options"><button class="btn btn-secondary modulesort-remove">'.t('Remove').'</button></div>'
        .'</div></li>';

echo heading($this->data('Title'));

echo '<div class="padded">',
    wrap(t('Drag & drop modules to sort them. Removing modules from the list does not make them disappear, it just removes them from the defined sort order.'), 'p'),
    wrap(t('Your settings are saved automatically.').'<br><br>'.anchor(t('Restore defaults'), 'settings/modulesort/reset', 'Hijack btn btn-primary'), 'p'),
    '</div>';

foreach (array_keys(c('EnabledApplications')) as $app) {
    $app = htmlspecialchars($app);
    ?>
    <div class="header-block">
        <h2><?php echo $app; ?></h2>
        <form class="modulesort-add" data-group="<?php echo $app; ?>">
            <div class="input-wrap input-wrap-multiple">
                <input type="text" class="form-control" placeholder="<?php echo t('Add module...'); ?>">
                <button class="btn btn-primary"><?php echo t('Add'); ?></button>
            </div>
        </form>
    </div>
    <ol class="modulesort sort-<?php echo $app; ?> nestable-list padded-top" data-appname="<?php echo $app; ?>">
    <?php
    foreach (c('Modules.'.$app.'.Panel', []) as $module) {
        echo sprintf($item, $module);
    }
    ?>
    </ol>
    <?php
}

echo '<div class="hidden modulesort-dummy">'.sprintf($item, '').'</div>';
