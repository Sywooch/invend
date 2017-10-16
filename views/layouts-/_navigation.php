<?php
use xutl\inspinia\Nav;
use xutl\inspinia\SideBar;
use mdm\admin\components\Helper;
use yuncms\admin\helpers\MenuHelper;
use yii\helpers\Html;

// $menus = MenuHelper::getAssignedMenu(Yii::$app->user->id);
?>
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
    	<?php

            $menuItems = [
                ['label' => 'Agreement', 'url' => ['/agreement/create']],
                ['label' => 'Payment', 'url' => ['/payment/create']],
                ['label' => 'Property', 'url' => ['/property/create']],
                [
                    'label' => 'Report', 'url' => ['/'],
                    'items' => [
                        ['label' => 'Payment Report', 'url' => ['/report/index']],
                        ['label' => 'Payment Plan Report', 'url' => ['/report/payment-plan']],
                        ['label' => 'Defaulters Report', 'url' => ['/report/defaulters']],
                        ['label' => 'Payment Plan', 'url' => ['/payment-plan/index']],
                        ['label' => 'Documents', 'url' => ['/document/index']],
                    ]
                ]
            ];

            echo Nav::widget([
	            'top' => $this->render(
	                '_navigation_header.php'
	            ),
	            'items' => $menuItems
	        ]);

        ?>
        
    </div>
</nav>