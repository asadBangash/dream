<?php

namespace App\View\Composers;

use App\Interfaces\LanguageInterface;
use Illuminate\View\View;
use App\Models\Language;

class LanguageComposer
{
    /**
     * The user Interface implementation.
     *
     * @var \App\Interfaces\LanguageInterface
     */
    protected $language;

    /**
     * Create a new profile composer.
     *
     * @param  \App\Repositories\LanguageInterface  $language
     * @return void
     */
    public function __construct(LanguageInterface $language)
    {
        $this->language = $language;
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $language['languages'] = $this->language->all();
        $locale = \Session::get('locale', enabledLanguageCodes()[0] ?? 'en');
        $language['language'] = $language['languages']->firstWhere('code', $locale)
            ?? Language::where('code', 'en')->first()
            ?? $language['languages']->first();
        $view->with('language', $language);
    }
}
