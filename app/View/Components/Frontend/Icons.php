<?php

namespace App\View\Components\Frontend;

use Illuminate\View\Component;

class Icons extends Component
{

    public $imageIcon;
    public $title;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($imageIcon,$title)
    {
        $this->imageIcon = $imageIcon;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.frontend.icons');
    }
}
