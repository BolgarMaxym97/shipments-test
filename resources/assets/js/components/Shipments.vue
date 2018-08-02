<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header ">
                        <h3 class="box-title pull-left">Shipments</h3>
                        <preloader :display="preLoader"></preloader>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-condensed">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Created</th>
                                <th>Is sended</th>
                                <th>Items</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(shipment, index) in shipments">
                                <td>{{shipment.name}}</td>
                                <td>{{shipment.created_at}}</td>
                                <td>
                                    <span class="btn-xs"
                                          :class="sendClass(shipment.is_send)"></span>
                                </td>
                                <td>
                                    <span class="btn-xs btn-primary">{{shipment.items.length}}</span>
                                    <button class="btn btn-success btn-xs">
                                        <span class="fa fa-arrow-down"></span>
                                    </button>
                                </td>
                                <td>
                                    <button @click="send(shipment.id, index)"
                                            :disabled="shipment.is_send === SENDED_STATUSES.SENDED"
                                            class="btn btn-primary btn-xs">
                                        <span class="fa fa-truck"></span></button>
                                    <button class="btn btn-danger btn-xs"
                                            @click="remove(shipment.id, index)">
                                        <span class="fa fa-trash"></span>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
        <notifications group="foo"/>
    </div>
</template>

<script>
    import preloader from './PreLoader.vue';


    export default {
        components: {
            preloader
        },
        data: function () {
            return {
                shipments: [],
                preLoader: false,
                SENDED_STATUSES: {
                    SENDED: 1,
                    NOT_SENDED: 0,
                }
            }
        },
        mounted() {
            this.update();
        },

        methods: {
            sendClass: function (sended) {
                return sended === 1 ? 'btn-success fa fa-check' : 'btn-danger fa fa-remove'
            },
            update: function () {
                this.preLoader = true;
                axios.get('/get-shipments').then((response) => {
                    this.shipments = response.data;
                }).then(() => {
                    this.preLoader = false;
                });
            },
            remove: function (id, index) {
                this.preLoader = true;
                axios.post('/remove-shipment', {id}).then((response) => {
                    response.data.success && this.shipments.splice(index, 1);
                    this.noty(response);
                }).then(() => {
                    this.preLoader = false;
                });
            },
            send: function (id, index) {
                this.preLoader = true;
                axios.post('/send-shipment', {id}).then((response) => {
                    response.data.success && Vue.set(this.shipments[index], 'is_send', this.SENDED_STATUSES.SENDED);
                    this.noty(response);
                }).then(() => {
                    this.preLoader = false;
                });
            },
            noty: function (response) {
                Vue.notify({
                    group: 'foo',
                    type: response.data.success ? 'success' : 'error',
                    text: response.data.message
                });
            }
        }
    }
</script>


