<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header ">
                        <h3 class="box-title">Shipments</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-condensed">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Created</th>
                                <th>Sended</th>
                                <th>Items</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="shipment in shipments">
                                <td>{{shipment.name}}</td>
                                <td>{{shipment.created_at}}</td>
                                <td>{{shipment.is_send}}</td>
                                <td>{{shipment.items.length}}</td>
                                <td>
                                    <button class="btn btn-success btn-xs"><span class="fa fa-arrow-down"></span>
                                    </button>
                                    <button class="btn btn-primary btn-xs"><span class="fa fa-truck"></span></button>
                                    <button class="btn btn-danger btn-xs"><span class="fa fa-trash"></span></button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'shipments'
        ],
        mounted() {
            console.log(this.shipments);
        }
    }
</script>
