<?php

declare(strict_types=1);

namespace learn\web\shop_shop\misc\music_app\views\components;

use learn\web\shop_shop\models\View;
use learn\web\shop_shop\models\Controller;  
use learn\web\shop_shop\utils\BaseDir;


/**
 * 
 * @extends View<Controller>
 */
class PlaylistComponent extends View
{
    public function __construct(
        Controller $ctrl
    ) {

        parent::__construct($ctrl);
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function init(): void {

        $this->controller->layout->cssManager->add(
            "js-playlist-component",
            BaseDir::getResource("/public/resources/css/misc/music_app/views/components/playlist_component.css")
        );
    }


    /**
     * 
     * {@inheritdoc}
     */
    public function render(): View|string|false
    {


        ob_start();

?>

        <section id="el-id-playlist-container">
            <h1 class="lbl-title-container">Sample Playlist</h1>
            <ul class="el-playlist">
                <li>
                    <h1>Sample I (MP3)</h1>
                    <audio controls preload="auto">
                        <source type="audio/mpeg" src="/public/resources/audio/.misc/output.mp3">
                        Your browser does not support the audio element.
                    </audio>
                </li>
                <li>
                    <h1>Sample II (OGG | WAV)</h1>
                    <audio controls preload="auto">
                        <source type="audio/ogg" src="/public/resources/audio/.misc/audio_000.ogg">
                        <source type="audio/wav" src="/public/resources/audio/.misc/audio_000.wav">
                    </audio>
                </li>
            </ul>
        </section>
<?php

        return ob_get_clean();
    }
}
