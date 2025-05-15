<?php

declare(strict_types=1);

namespace learn\web\shop_shop\misc\music_app\views;

use learn\web\shop_shop\models\View;
use learn\web\shop_shop\misc\music_app\controllers\MusicController;
use learn\web\shop_shop\misc\music_app\views\components\PlaylistComponent;
use learn\web\shop_shop\models\Status;
use learn\web\shop_shop\utils\BaseDir;

/**
 * 
 * @extends View<MusicController>
 */
class LandingPage extends View
{

    private readonly PlaylistComponent $playlist;


    public function __construct(
        MusicController $musicCtrl
    ) {
        parent::__construct($musicCtrl);
        
        $this->playlist = new PlaylistComponent($this->controller);
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function init(): void
    {

        $this->controller->layout->title .= " ~ MUSIC_APP";

        $this->controller->layout->cssManager->add(
            "css-music-app-view",
            BaseDir::getResource("/public/resources/css/misc/music_app/views/music_app_view.css")
        );

        $this->controller->layout->jsManager->add(
            "js-music-app-view",
            BaseDir::getResource("/public/resources/js/misc/music_app/views/music_app_view.js")
        );

    }

    /**
     * 
     * {@inheritdoc}
     */
    public function render(): View|string|false
    {

        $paramPathVerb = $this->controller->layout->routeData->param->paramPath->what->getOrElse(Status::UNKNOWN->value);


        ob_start();

?>

        <div id="html-music-app-view">

            <header class="hero">
                <div class="hero-content">
                    <h1>Listen to your favorite <span>'<?=$paramPathVerb?>'</span> <span class="highlight">music</span><br>anytime, anywhere</h1>
                    <button href="#" type="button" class="cta-button">Start Listening</button>
                </div>
                <div class="hero-image">
                    <!--REM: https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=800&q=80 -->
                    <img src="/public/resources/img/music_app/hero/hero_000_w=800&q=80.jpg" alt="Concert crowd">
                </div>
            </header>

            <section class="trending">
                <div class="scroll-container">
                    <div class="scroll-content">
                        <span>Trending Music</span>
                        <span>Trending Music</span>
                        <span>Trending Music</span>
                        <span>Trending Music</span>
                    </div>
                </div>
            </section>

            <section class="artists">
                <div class="section-header">
                    <h2>Some of The Most<br>Famous <span class="highlight">Artists</span> Of All<br>Time in the world</h2>
                    <div class="stats">
                        <div class="stat">
                            <h3>1.2 M</h3>
                            <p>People enjoy the events</p>
                        </div>
                        <div class="stat">
                            <h3>1 K</h3>
                            <p>Events in all channels</p>
                        </div>
                    </div>
                </div>
                <div class="artist-grid">
                    <div class="artist-card">
                        <!--REM: https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=800&q=80 -->
                        <img src="/public/resources/img/music_app/artist/card_000_w=500&q=80.jpg" alt="Artist 1">
                    </div>
                    <div class="artist-card">
                        <img src="/public/resources/img/music_app/artist/card_001_w=500&q=80.jpg" alt="Artist 2">
                    </div>
                    <div class="artist-card">
                        <img src="/public/resources/img/music_app/artist/card_002_w=500&q=80.jpg" alt="Artist 3">
                    </div>
                    <div class="artist-card">
                        <img src="/public/resources/img/music_app/artist/card_003_w=500&q=80.jpg" alt="Artist 4">
                    </div>
                </div>
                <button class="explore-btn">Explore More</button>
            </section>

            <section class="connect">
                <div class="connect-content">
                    <h2>Get on Up Souly to connect with fans, share your sounds, and grow your audience. What are you waiting for?</h2>
                    <div class="wave-animation">
                        <div class="wave"></div>
                        <div class="wave"></div>
                        <div class="wave"></div>
                    </div>
                </div>
            </section>

            <section class="genres">
                <div class="genre-tags">
                    <span>ROCK</span>
                    <span>BEATS</span>
                    <span>CHILLOUT</span>
                    <span>AMBIENT</span>
                    <span>POP</span>
                    <span>HIP-HOP</span>
                </div>
            </section>

            <?= $this->playlist->render() ?>

            <section class="download">
                <div class="download-content">
                    <h2>Never stop listening</h2>
                    <p>Available on iOS, Android & Desktop. Download now!</p>
                    <div class="store-buttons">
                        <button class="store-btn"><i class="fab fa-apple"></i> App Store</button>
                        <button class="store-btn"><i class="fab fa-google-play"></i> Play Store</button>
                    </div>
                </div>
            </section>
        </div>


<?php

        return ob_get_clean();
    }
}
