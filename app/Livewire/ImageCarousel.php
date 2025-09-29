<?php

namespace App\Livewire;

use Livewire\Component;

class ImageCarousel extends Component
{
    public $images = [];
    public $currentSlide = 0;

    public function mount($images = [])
    {
        $this->images = $images;
    }

    public function goToSlide($index)
    {
        $this->currentSlide = $index;
    }

    public function nextSlide()
    {
        $this->currentSlide = ($this->currentSlide + 1) % count($this->images);
    }

    public function prevSlide()
    {
        $this->currentSlide = ($this->currentSlide - 1 + count($this->images)) % count($this->images);
    }
    
    public function render()
    {
        return view('livewire.image-carousel');
    }
}
