<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // add the rule
        $rule = new \app\rbac\ResidentRule;
        $auth->add($rule);

        // add "createUser" permission
        $createUser = $auth->createPermission('createUser');
        $createUser->description = 'Create a user';
        $auth->add($createUser);

        // add "updateUser" permission
        $updateUser = $auth->createPermission('updateUser');
        $updateUser->description = 'Update user';
        $auth->add($updateUser);

        // add "viewUser" permission
        $viewUser = $auth->createPermission('viewUser');
        $viewUser->description = 'View user';
        $auth->add($viewUser);

        // add "indexUser" permission
        $indexUser = $auth->createPermission('indexUser');
        $indexUser->description = 'Manage users list';
        $auth->add($indexUser);

        // add "deleteUser" permission
        $deleteUser = $auth->createPermission('deleteUser');
        $deleteUser->description = 'Delete user';
        $auth->add($deleteUser);

        // add "createVendor" permission
        $createVendor = $auth->createPermission('createVendor');
        $createVendor->description = 'Create a vendor';
        $auth->add($createVendor);

        // add "updateVendor" permission
        $updateVendor = $auth->createPermission('updateVendor');
        $updateVendor->description = 'Update vendor';
        $auth->add($updateVendor);

        // add "viewVendor" permission
        $viewVendor = $auth->createPermission('viewVendor');
        $viewVendor->description = 'View vendor';
        $auth->add($viewVendor);

        // add "indexVendor" permission
        $indexVendor = $auth->createPermission('indexVendor');
        $indexVendor->description = 'Manage vendors list';
        $auth->add($indexVendor);

        // add "deleteVendor" permission
        $deleteVendor = $auth->createPermission('deleteVendor');
        $deleteVendor->description = 'Delete vendor';
        $auth->add($deleteVendor);


        // add "createProduct" permission
        $createProduct = $auth->createPermission('createProduct');
        $createProduct->description = 'Create a product';
        $auth->add($createProduct);

        // add "viewProduct" permission
        $viewProduct = $auth->createPermission('viewProduct');
        $viewProduct->description = 'View product';
        $auth->add($viewProduct);

        // add "updateProduct" permission
        $updateProduct = $auth->createPermission('updateProduct');
        $updateProduct->description = 'Update product';
        $auth->add($updateProduct);

        // add the "updateOwnProduct" permission and associate the rule with it.
        $updateOwnProduct = $auth->createPermission('updateOwnProduct');
        $updateOwnProduct->description = 'Update own product';
        $updateOwnProduct->ruleName = $rule->name;
        $auth->add($updateOwnProduct);

        // "updateOwnProduct" will be used from "updateProduct"
        $auth->addChild($updateOwnProduct, $updateProduct);

        // add "deleteProduct" permission
        $deleteProduct = $auth->createPermission('deleteProduct');
        $deleteProduct->description = 'Delete product';
        $auth->add($deleteProduct);

        // add "indexProduct" permission
        $indexProduct = $auth->createPermission('indexProduct');
        $indexProduct->description = 'Manage products list';
        $auth->add($indexProduct);

        // add "resident" role and give this role the "createProduct, viewProduct and updateOwnProduct" permission
        $resident = $auth->createRole('resident');
        $auth->add($resident);
        $auth->addChild($resident, $createProduct);
        $auth->addChild($resident, $viewProduct);
        // allow "resident" to update their own products
        $auth->addChild($resident, $updateOwnProduct);
        
        // add "manager" role and give this role the "createUser and updateUser" permission and all permissions of the resident
        $manager = $auth->createRole('manager');
        $auth->add($manager);

        $auth->addChild($manager, $updateProduct);
        $auth->addChild($manager, $deleteProduct);
        $auth->addChild($manager, $indexProduct);
        $auth->addChild($manager, $createUser);
        $auth->addChild($manager, $updateUser);
        $auth->addChild($manager, $resident);

        // add "admin" role and give this role the "all" permission
        // as well as the permissions of the "resident and manager" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $manager);
        $auth->addChild($admin, $resident);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($admin, 1);
    }
}