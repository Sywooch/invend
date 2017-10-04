<?php

use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use app\models\Uom;
?>
<?php DynamicFormWidget::begin([
                                    'widgetContainer' => 'dynamicform_inner', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                    'widgetBody' => '.container-components', // required: css class selector
                                    'widgetItem' => '.component-item', // required: css class
                                    'insertButton' => '.add-component', // css class
                                    'deleteButton' => '.del-component', // css class
                                    'model' => $modelsComponents[$i][0],
                                    'formId' => 'bom-form',
                                    'formFields' => [
                                        'name',
                                        'description',
                                        'quantity_type',
                                        'quantity',
                                        'last_cost',
                                        'uom_id',
                                        'total_line_cost',
                                        'remark',
                                    ],
                                ]);

                                ?>

                                <div class="table-responsive tab-content">

                                <table class="table table-striped table-bordered tab-pane active" id="tab-1">
                                    <thead>
                                        <tr class="active">
                                            <th></th>
                                            <th class="col-xs-2"><?= Html::activeLabel($modelsComponents[$i][0], 'name'); ?></th>
                                            <th class="col-xs-2"><?= Html::activeLabel($modelsComponents[$i][0], 'description'); ?></th>
                                            <th class="col-xs-2"><?= Html::activeLabel($modelsComponents[$i][0], 'quantity_type'); ?></th>
                                            <th class="col-xs-1"><?= Html::activeLabel($modelsComponents[$i][0], 'quantity'); ?></th>
                                            <th class="col-xs-1"><?= Html::activeLabel($modelsComponents[$i][0], 'last_cost'); ?></th>
                                            <th class="col-xs-2"><?= Html::activeLabel($modelsComponents[$i][0], 'uom_id'); ?></th>
                                            <th class="col-xs-1"><?= Html::activeLabel($modelsComponents[$i][0], 'total_line_cost'); ?></th>
                                            <th class="col-xs-1"><?= Html::activeLabel($modelsComponents[$i][0], 'remarks'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody class="container-components"><!-- widgetContainer -->
                                    <?php foreach ($modelsComponents[$i] as $ix => $modelComponent): ?>
                                        <tr class="component-item"><!-- widgetBody -->
                                            <td>
                                                <button type="button" class="del-component btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                                <?php
                                                // necessary for update action.
                                                if (! $modelComponent->isNewRecord) {
                                                    echo Html::activeHiddenInput($modelComponent, "[{$i}][{$ix}]id");
                                                }
                                                ?>
                                            </td>

                                            <td>
                                                <?php
                                                    echo $form->field($modelComponent, "[{$i}][{$ix}]name")->begin();
                                                    echo Html::activeTextInput($modelComponent, "[{$i}][{$ix}]name", ['maxlength' => true, 'class' => 'form-control']); //Field
                                                    echo Html::error($modelComponent,"[{$i}][{$ix}]name", ['class' => 'help-block']); //error
                                                    echo $form->field($modelComponent, "[{$i}][{$ix}]name")->end();
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    echo $form->field($modelComponent, "[{$i}][{$ix}]description")->begin();
                                                    echo Html::activeTextInput($modelComponent, "[{$i}][{$ix}]description", ['maxlength' => true, 'class' => 'form-control']); //Field
                                                    echo Html::error($modelComponent,"[{$i}][{$ix}]description", ['class' => 'help-block']); //error
                                                    echo $form->field($modelComponent, "[{$i}][{$ix}]description")->end();
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    echo $form->field($modelComponent, "[{$i}][{$ix}]quantity_type")->begin();
                                                    echo Html::activeDropDownList($modelComponent, "[{$i}][{$ix}]quantity_type", ['1'=>'Ratio','2'=>'Fixed'],['maxlength' => true, 'class' => 'form-control']); //Field
                                                    echo Html::error($modelComponent,"[{$i}][{$ix}]quantity_type", ['class' => 'help-block']); //error
                                                    echo $form->field($modelComponent, "[{$i}][{$ix}]quantity_type")->end();
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    echo $form->field($modelComponent, "[{$i}][{$ix}]quantity")->begin();
                                                    echo Html::activeTextInput($modelComponent, "[{$i}][{$ix}]quantity", ['maxlength' => true, 'class' => 'form-control']); //Field
                                                    echo Html::error($modelComponent,"[{$i}][{$ix}]quantity", ['class' => 'help-block']); //error
                                                    echo $form->field($modelComponent, "[{$i}][{$ix}]quantity")->end();
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    echo $form->field($modelComponent, "[{$i}][{$ix}]last_cost")->begin();
                                                    echo Html::activeTextInput($modelComponent, "[{$i}][{$ix}]last_cost", ['maxlength' => true, 'class' => 'form-control']); //Field
                                                    echo Html::error($modelComponent,"[{$i}][{$ix}]last_cost", ['class' => 'help-block']); //error
                                                    echo $form->field($modelComponent, "[{$i}][{$ix}]last_cost")->end();
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    echo $form->field($modelComponent, "[{$i}][{$ix}]uom_id")->begin();
                                                    echo Html::activeDropDownList($modelComponent, "[{$i}][{$ix}]uom_id", ArrayHelper::map(Uom::find()->all(), 'id', 'name'), ['maxlength' => true, 'class' => 'form-control']); //Field
                                                    echo Html::error($modelComponent,"[{$i}][{$ix}]uom_id", ['class' => 'help-block']); //error
                                                    echo $form->field($modelComponent, "[{$i}][{$ix}]uom_id")->end();
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    echo $form->field($modelComponent, "[{$i}][{$ix}]total_line_cost")->begin();
                                                    echo Html::activeTextInput($modelComponent, "[{$i}][{$ix}]total_line_cost", ['maxlength' => true, 'class' => 'form-control']); //Field
                                                    echo Html::error($modelComponent,"[{$i}][{$ix}]total_line_cost", ['class' => 'help-block']); //error
                                                    echo $form->field($modelComponent, "[{$i}][{$ix}]total_line_cost")->end();
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    echo $form->field($modelComponent, "[{$i}][{$ix}]remarks")->begin();
                                                    echo Html::activeTextInput($modelComponent, "[{$i}][{$ix}]remarks", ['maxlength' => true, 'class' => 'form-control']); //Field
                                                    echo Html::error($modelComponent,"[{$i}][{$ix}]remarks", ['class' => 'help-block']); //error
                                                    echo $form->field($modelComponent, "[{$i}][{$ix}]remarks")->end();
                                                ?>
                                            </td>

                                        </tr>
                                    <?php endforeach; // end of loads loop ?>
                                    </tbody>
                                    <tfoot>
                                        <td colspan="5" class="active"><button type="button" class="add-component btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button></td>
                                    </tfoot>
                                </table>
                                </div>
                                <?php DynamicFormWidget::end(); // end of loads widget ?>