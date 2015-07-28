<?php

$PluginInfo['modulesort'] = array(
    'Name' => 'Module Sort',
    'Description' => 'Allows changing the order of modules in the panel.',
    'Version' => '0.1',
    'SettingsUrl' => 'settings/modulesort',
    'SettingsPermission' => 'Garden.Settings.Manage',
    'Author' => 'Bleistivt',
    'AuthorUrl' => 'http://bleistivt.net',
    'License' => 'GNU GPL2'
);

class ModuleSortPlugin extends Gdn_Plugin {

    public function settingsController_moduleSort_create($sender, $reset = false) {
        $sender->permission('Garden.Settings.Manage');
        $sender->addSideMenu('settings/modulesort');

        $sender->addJsFile('html.sortable.min.js', 'plugins/modulesort');
        $sender->addJsFile('modulesort.js', 'plugins/modulesort');

        if (Gdn::request()->isAuthenticatedPostBack()) {
            if ($reset) {
                removeFromConfig('Modules');
                $sender->jsonTarget('', '', 'Refresh');
            } elseif ($sort = json_decode(Gdn::request()->post('Modules'), true)) {
                saveToConfig('Modules', $sort);
            }
        }

        $sender->title(t('Module Sort Order'));
        $sender->render('modulesort', '', 'plugins/modulesort');
    }

    public function base_getAppSettingsMenuItems_handler($sender, &$args) {
        $args['SideMenu']->addLink(
            'Appearance',
            t('Module Sort Order'),
            'settings/modulesort',
            'Garden.Settings.Manage'
        );
    }

}
