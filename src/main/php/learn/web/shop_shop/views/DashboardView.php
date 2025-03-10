<?php
declare(strict_types=1);

namespace learn\web\shop_shop\views;

use learn\web\shop_shop\models\Controller;
use learn\web\shop_shop\models\View;
use learn\web\shop_shop\controllers\DashboardController;

/**
 * 
 * @extends View<DashboardController>
 */
class DashboardView extends View {


    public function __construct(
        DashboardController $ctrl
    ) {
        parent::__construct( $ctrl );
    }
    
    /**
     * 
     * {@inheritdoc}
     */
    protected function init(): void {
        
    }

    /**
     * 
     * @inheritDoc View::render()
     */
    public function render(): View|string|false {

        ob_start();
        ?>
            <div id="html-dashboard-view">
                
            </div>
        <?php
        return ob_get_clean();
    }
}
