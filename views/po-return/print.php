<?php

use yii\helpers\Html;
use yii\grid\GridView;
?>
<div class="wrapper wrapper-content p-xl">
    <div class="ibox-content p-xl">
        <div class="row">
            <div class="col-sm-6">
                <h5>From:</h5>
                <address>
                    <strong>Spring Water Falls, Inc.</strong><br>
                    Sepe Timpom, Opposite ..<br>
                    Kumasi, Ghana<br>
                    <abbr title="Phone">P:</abbr> (0244) 000-0000
                </address>
            </div>

            <div class="col-sm-6 text-right">
                <h4>Order No.</h4>
                <h4 class="text-navy">ORD-000567F7-<?= $model->number ?></h4>
                <span>To:</span>
                <address>
                    <strong>Corporate, Inc.</strong><br>
                    Awunju Daaban Avenu, 1080<br>
                    Kumasi, Ghana<br>
                    <abbr title="Phone">P:</abbr> (024) 0000-4321
                </address>
                <p>
                    <span><strong>Order Date:</strong> <?= $model->date ?></span><br/>
                    <span><strong>Due Date:</strong> <?= $model->due_date ?></span>
                </p>
            </div>
        </div>

        <div class="table-responsive m-t">
            <div class="table-responsive m-t">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => '{items}{pager}',
                    'columns' => [
                        [
                            'label' => 'Item Name',
                            'value' => 'item_name'
                        ],
                        [
                            'label' => 'Quantity',
                            'value' => 'quantity'
                        ],
                        [
                            'label' => 'Unit Price',
                            'value' => 'unit_price'
                        ],
                        [
                            'label' => 'Discount',
                            'value' => 'discount'
                        ],
                        [
                            'label' => 'Total',
                            'value' => 'sub_total'
                        ],
                   ],
               ]); ?>
            </div><!-- /table-responsive -->
        </div><!-- /table-responsive -->

        <table class="table invoice-total">
            <tbody>
            <tr>
                <td><strong>Total :</strong></td>
                <td>GH₵<?= $model->total ?></td>
            </tr>
            <tr>
                <td><strong>Paid :</strong></td>
                <td>GH₵<?= $model->paid ?></td>
            </tr>
            <tr>
                <td><strong>Balance :</strong></td>
                <td>GH₵<?= $model->balance ?></td>
            </tr>
            </tbody>
        </table>
        <div class="well m-t"><strong>Comments</strong>
            Spring Water Falls. The water that gives life
        </div>
    </div>

</div>


<!-- Mainly scripts -->
<script type="text/javascript">
    window.print();
</script>
