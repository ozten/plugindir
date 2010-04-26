<?php
/**
 * Local base controller for application
 *
 * @package    PluginDir
 * @subpackage controllers
 * @author     l.m.orchard <lorchard@mozilla.com>
 */
class Local_Controller extends TwigRender_Controller {

    /**
     * Local controller constructor, set up some common view global vars.
     */
    public function __construct() 
    {
        parent::__construct();

        Event::add('system.403', array($this, 'show_forbidden'));
        Event::add('system.forbidden', array($this, 'show_forbidden'));
    }

    /**
     * In reaction to a 403 Forbidden event, throw up a forbidden view.
     */
    public function show_forbidden()
    {
        header('403 Forbidden');
        $this->view->set_filename('forbidden');
        $this->render();

        cef_logging::log(
            cef_logging::ACCESS_CONTROL_VIOLATION, 
            'Access Control Violation', 5
        );

        exit();
    }

    public function render() {

        View::set_global(array(
            'media_url'         => url::base(),
            'base_url'          => url::site().'/',
            'router_controller' => Router::$controller,
            'router_method'     => Router::$method,

            'flash_message'     => Session::instance()->get_once('message'),

            'is_logged_in'      => authprofiles::is_logged_in(),
            'authprofile'       => authprofiles::get_profile(),

            'l10n_language'     => Gettext_Main::$current_language,
            'l10n_locale'       => Gettext_Main::$current_locale,
            'l10n_dir'          => Gettext_Main::$current_dir,

            // Dirty, but occasionally useful:
            '_POST' => $_POST,
            '_GET'  => $_GET,
        ));

        parent::render();
    }
    
}
