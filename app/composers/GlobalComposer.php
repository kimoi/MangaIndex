<?php

class GlobalComposer {

    // flag so this composer will only run once per page load
    protected static $done = false;

    public function compose($view) {
        if(self::$done) {
            return;
        }

        self::$done = true;

        $user = Auth::user();
        $view->with('user', $user);

        // notifications
        if($user) {
            $notifyCount = $user->notifications()->unseen()->count();
            $view->with('notifyCount', $notifyCount);
        }

        // google analytics id
        $gaId = Config::get('app.ga_id');
        $view->with('gaId', $gaId);

        $this->setupAssets($view);
        $this->setupStats($view);
        $this->setupReports($view);
    }

    // css and js files to include
    protected function setupAssets($view) {
        $stylesheets = array(
            '/css/normalize.css',
            '/css/jquery-ui.structure.css',
            '/css/fonts.css',
            '/css/manga.css'
        );

        $view->with('stylesheets', $stylesheets);

        $javascripts = array(
            '/js/jquery.js',
            '/js/jquery-ui.js',
            '/js/manga.js'
        );

        $view->with('javascripts', $javascripts);

        // additional assets that can be added on a per-route basis
        if(!$view->offsetExists('additionalStylesheets')) {
            $view->with('additionalStylesheets', array());
        }

        if(!$view->offsetExists('additionalJavascripts')) {
            $view->with('additionalJavascripts', array());
        }
    }

    // total size used in footer
    protected function setupStats($view) {
        $size = Cache::remember('statTotalSize', 60, function() {
            return DB::table('path_records')->sum('size');
        });

        $formatted = DisplaySize::format($size, 2);
        $view->with('statTotalSize', $formatted);
    }

    // report counts
    protected function setupReports($view) {
        $reportsCount = Cache::rememberForever('reportsCount', function() {
            return Report::count();
        });

        $view->with('reportsCount', $reportsCount);
    }

}