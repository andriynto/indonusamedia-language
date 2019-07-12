<?php namespace Indonusamedia\Language\Middleware;

/*
 * This file is part of the Andriyanto Indonusa Britax
 *
 * (c) Andriyanto <andriynto.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App;
use Auth;
use Carbon\Carbon;
use Closure;
use Unicodeveloper\Identify\Facades\IdentityFacade as Identity;

class SetLocale
{
    /**
     * This function checks if language to set is an allowed lang of config
     * 
     *  @param string $locale
     */
    private function setLocale($locale)
    {
        // Check if is allowed and set default locale if not
        if(!language()->allowed($locale)) {
            $locale = config('app.locale');
        }

        // Set app language
        App::setLocale($locale);
        
        // Set carbon language
        if(config('language.carbon')) {
            // Carbon use only language code
            if(config('language.mode.code') == 'long')
            {
                $locale = explode('-', $locale)[0];
            }

            Carbon::setLocale($locale);
        }

        // Set date language
        if(config('language.date')) {
            // Date ises only language code
            if(config('language.mode.code') == 'long') {
                $locale = explode('-', $locale)[0];
            }

            \Date::setLocale($locale);
        }
    }

    public function setDefaultLocale()
    {
        if(config('language.auto')) {
            $this->setLocale(Identity::lang()->getLanguage());
        } else {
            $this->setLocale(config('app.locale'));
        }
    }

    public function setUserLocale()
    {
        $user = Auth::user();

        if($user->locale) {
            $this->setLocale($user->locale);
        } else {
            $this->setDefaultLocale();
        }
    }

    public function setSystemLocale($request)
    {
        if ($request->session()->has('locale')) {
            $this->setLocale(session('locale'));
        } else {
            $this->setDefaultLocale();
        }
    }

    /**
     * Handle an incoming request
     * 
     * @param \Illuminate\Http\Request $request
     * @param \Closure
     * 
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //dd($this->setSystemLocale($request));
        if(Auth::check()) {
            $this->setUserLocale();
        }else {
            $this->setSystemLocale($request);
        }
        
        return $next($request);
    }
}