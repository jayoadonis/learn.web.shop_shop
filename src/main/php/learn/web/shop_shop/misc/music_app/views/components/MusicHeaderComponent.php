<?php

declare(strict_types=1);

namespace learn\web\shop_shop\misc\music_app\views\components;

use learn\web\shop_shop\models\Component;
use learn\web\shop_shop\models\View;
use learn\web\shop_shop\utils\BaseDir;
use learn\web\shop_shop\views\components\ToggleComponent;

class MusicHeaderComponent extends Component
{

    /**
     * 
     * {@inheritdoc}
     */
    protected function init(): void {

        $this->controller->layout->cssManager->add(
            "css-music-header-component",
            BaseDir::getResource("/public/resources/css/misc/music_app/views/components/music_header_component.css")
        );
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function render(): View|string|false
    {
        
        $toggleThemeComponent = new ToggleComponent($this->controller);

        ob_start();
?>
        <nav class="navbar">
            <div class="logo">
                <!-- <i class="fa-solid fa-music"></i> -->
                <a id="link-go-back" href="/">Go Back</a>
                <span>Dive</span>
            </div>
            <div class="nav-links">
                <a href="#" class="active">Home</a>
                <a href="#">Music</a>
                <a href="#">Events</a>
                <a href="#">Artists</a>
                <a href="#">Contact</a>
            </div>

            <div class="btn-left">
                <button class="login-btn">Login</button>
                <?= $toggleThemeComponent->render() ?>
            </div>
            
        </nav>

<?php
        return ob_get_clean();
    }
}
