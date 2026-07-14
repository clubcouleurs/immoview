<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ApplicationMenu extends Component
{
    /**
     * The alert message.
     *
     * @var string
     */
    //public $projets;
 
    /**
     * Create the component instance.
     *
     * @param  string  $projets
     * @return void
     */
    // public function __construct( $projets)
    // {

    //     $this->projets = $projets;
    // }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.application-menu');
    }
}
