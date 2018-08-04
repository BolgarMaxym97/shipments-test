<template>
    <div class="container">
        <div class="col-md-3 col-sm-6 col-xs-12"></div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total shipments</span>
                    <span class="info-box-number">{{shipments.length}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total items</span>
                    <span class="info-box-number">{{items.length}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'shipments',
        ],

        computed: {
            items: function () {
                let items = [];
                this.shipments.map(function (value, index) {
                    value['items'].map(function (valueItem, indexItem) {
                        items.push(valueItem);
                    })
                });
                return items;
            }
        }
    }
</script>

<style scoped>

</style>
