<?php

if (!function_exists('language')) {
    /**
     * Get the language instance.
     *
     * @return \Accounting\Language\Language
     */
    function language()
    {
        return app('language');
    }
}
