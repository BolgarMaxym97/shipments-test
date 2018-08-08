<template>
    <div class="row justify-content-center">
        <!-- This component is here because I don't use VueX and I don't want make one more response into counters component-->
        <counters :shipments="shipments"></counters>
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
                            <th>#ID</th>
                            <th>Name</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th>Is sended</th>
                            <th>Items</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(shipment, index) in shipments">
                            <td>{{shipment.id}}</td>
                            <td>
                                {{shipment.name}}<br>
                                <transition name="fade" mode="out-in">
                                    <div class="new-name" v-if="shipment.id === editId">
                                        <label for="">New name: </label><br>
                                        <input v-model="shipment.name" type="text" class="form-control pull-left"
                                               placeholder="New name">
                                        <button v-tooltip.top="'Save changes'" :disabled="preLoader"
                                                @click="edit(shipment)"
                                                class="btn btn-success btn-md">
                                            <span class="fa fa-save"></span>
                                        </button>
                                    </div>
                                </transition>
                            </td>
                            <td>{{shipment.created_at | moment("timezone", "Europe/Kiev") | moment("from", "now")}}</td>
                            <td>{{shipment.updated_at | moment("timezone", "Europe/Kiev") | moment("from", "now")}}</td>
                            <td>
                                    <span class="btn-xs"
                                          :class="sendClass(shipment.is_send)"></span>
                            </td>
                            <td>
                                <span class="btn-xs btn-primary">{{shipment.items.length}}</span>
                                <button v-tooltip.top="'View items for this shipment'" @click="view(shipment)"
                                        class="btn btn-success btn-xs">
                                    <span class="fa fa-eye"></span>
                                </button>
                            </td>
                            <td>
                                <button v-tooltip.top="'Edit shipment'" @click="setEditableField(shipment.id)"
                                        class="btn btn-warning btn-xs">
                                    <span class="fa fa-pencil"></span>
                                </button>
                                <button v-tooltip.top="'Send shipment to customer'" @click="send(shipment.id, index)"
                                        :disabled="shipment.is_send === SENDED_STATUSES.SENDED || preLoader"
                                        class="btn btn-primary btn-xs">
                                    <span class="fa fa-truck"></span></button>
                                <button v-tooltip.top="'Remove shipment'" :disabled="preLoader"
                                        class="btn btn-danger btn-xs"
                                        @click="remove(shipment.id, index)">
                                    <span class="fa fa-trash"></span>
                                </button>
                            </td>
                        </tr>
                        <div class="box-header ">
                            <h3 class="box-title pull-left">Create new shipment</h3>
                        </div>
                        <tr>
                            <td>
                                <input v-model="newShipment.id" type="number" class="form-control" placeholder="ID">
                            </td>
                            <td>
                                <input v-model="newShipment.name" type="text" class="form-control" placeholder="Name">
                            </td>
                            <td>
                                <button v-tooltip.top="'Create new shipment'" :disabled="preLoader" @click="create()"
                                        class="btn btn-success">
                                    <span class="fa fa-plus"> Create</span>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <notifications group="shipments"/>
        <modal name="shipment-items" :width="'70%'" :resizable="true" :adaptive="true" :height="'auto'"
               :scrollable="true">
            <items :shipment="viewedShipment"></items>
        </modal>
    </div>
</template>

<script>
    import preloader from './PreLoader.vue';
    import items from './ShipmentItems.vue';
    import counters from './Counters.vue';


    export default {
        components: {
            preloader,
            items,
            counters
        },
        data: function () {
            return {
                shipments: [],
                preLoader: false,
                SENDED_STATUSES: {
                    SENDED: 1,
                    NOT_SENDED: 0,
                },
                newShipment: {
                    id: null,
                    name: null,
                },
                editId: null,
                viewedShipment: null,
            }
        },
        mounted() {
            this.fetch();
        },

        methods: {
            fetch: function () {
                this.preLoader = true;
                axios.get('/get-shipments').then((response) => {
                    this.shipments = response.data;
                }).then(() => {
                    this.preLoader = false;
                });
            },
            sendClass: function (sended) {
                return sended === 1 ? 'btn-success fa fa-check' : 'btn-danger fa fa-remove'
            },

            create: function () {
                if (this.validate(this.newShipment)) {
                    this.preLoader = true;
                    axios.post('/create-shipment', this.newShipment).then((response) => {
                        let data = response.data;
                        if (data.success) {
                            this.shipments.push(data.shipment);
                            this.newShipment.id = null;
                            this.newShipment.name = null;
                        }
                        this.noty(response);
                    }).then(() => {
                        this.preLoader = false;
                    });
                } else {
                    this.noty({
                        data: {success: false, message: 'Not valid data or ID already exist'}
                    });
                }
            },
            view: function (shipment) {
                this.viewedShipment = shipment;
                this.$modal.show('shipment-items');
            },
            edit: function (shipment) {
                if (this.validate(shipment)) {
                    this.preLoader = true;
                    axios.post('/edit-shipment', {shipment}).then((response) => {
                        if (response.data.success) {
                            this.editId = null;
                        }
                        this.noty(response);
                    }).then(() => {
                        this.preLoader = false;
                    });
                } else {
                    this.noty({
                        data: {success: false, message: 'Not valid data or ID already exist'}
                    });
                }
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

            validate: function (model) {
                return Number.isInteger(+model.id) &&
                    +model.id > 0 &&
                    model.name !== null &&
                    model.name.length > 0;
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
            setEditableField: function (id) {
                this.editId = this.editId !== id ? id : null;
            },
        }
    }
</script>

<style scoped>
    .new-name input {
        width: 30%;
    }

    .fade-enter-active {
        transition: all .3s ease;
    }

    .fade-leave-active {
        transition: all .3s ease;
    }

    .fade-enter, .fade-leave-to
        /* .slide-fade-leave-active до версии 2.1.8 */
    {
        transform: translateY(-10px);
        opacity: 0;
    }
</style>

