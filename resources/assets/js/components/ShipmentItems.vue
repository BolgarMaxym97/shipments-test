<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-header ">
                    <h3 class="box-title pull-left">Shipment items of {{shipment.name}}</h3>
                    <preloader :display="preLoader"></preloader>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <table class="table table-condensed">
                        <thead>
                        <tr>
                            <th>#ID</th>
                            <th width="25%">Name</th>
                            <th width="25%">Code</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in shipment.items">
                            <td>{{item.id}}</td>
                            <td>
                                {{item.name}}
                                <transition name="fade" mode="out-in">
                                    <div class="edit-item" v-if="item.id === editId">
                                        <input v-model="item.name" type="text" class="form-control pull-left"
                                               placeholder="New name">
                                    </div>
                                </transition>
                            </td>
                            <td>
                                {{item.code}}
                                <transition name="fade" mode="out-in">
                                    <div class="edit-item" v-if="item.id === editId">
                                        <input v-model="item.code" type="text" class="form-control pull-left"
                                               placeholder="New name">
                                        <button :disabled="preLoader" @click="edit(item)"
                                                class="btn btn-success btn-md">
                                            <span class="fa fa-save"></span>
                                        </button>
                                    </div>
                                </transition>
                            </td>
                            <td>{{item.created_at | moment("add", "3 hours") | moment("from", "now")}}</td>
                            <td>{{item.updated_at | moment("add", "3 hours") | moment("from", "now")}}</td>
                            <td>
                                <button v-tooltip.top="'Edit item'" @click="setEditable(item.id)" class="btn btn-warning btn-xs">
                                    <span class="fa fa-pencil"></span>
                                </button>
                                <button v-tooltip.top="'Remove item'" :disabled="preLoader" class="btn btn-danger btn-xs"
                                        @click="remove(item.id, index)">
                                    <span class="fa fa-trash"></span>
                                </button>
                            </td>
                        </tr>
                        <div class="box-header ">
                            <h3 class="box-title pull-left">Create new item</h3>
                        </div>
                        <tr>
                            <td>
                                <input v-model="newItem.id" type="number" class="form-control" placeholder="ID">
                            </td>
                            <td>
                                <input v-model="newItem.name" type="text" class="form-control" placeholder="Name">
                            </td>
                            <td>
                                <input v-model="newItem.code" type="text" class="form-control" placeholder="Code">
                            </td>
                            <td>
                                <button v-tooltip.top="'Create new item for shipment'" :disabled="preLoader" @click="create()" class="btn btn-success">
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
    </div>
</template>

<script>
    import preloader from './PreLoader.vue';


    export default {
        components: {
            preloader
        },
        props: [
            'shipment',
            'noty'
        ],
        data: function () {
            return {
                preLoader: false,
                editId: null,
                newItem: {
                    id: null,
                    name: null,
                    code: null,
                    shipment_id: this.shipment.id,
                },
            }
        },
        mounted() {
        },

        methods: {
            setEditable: function (id) {
                this.editId = this.editId !== id ? id : null;
            },

            create: function () {
                if (this.validate(this.newItem)) {
                    this.preLoader = true;
                    axios.post('/create-item', this.newItem).then((response) => {
                        let data = response.data;
                        if (data.success) {
                            this.shipment.items.push(data.item);
                            this.newItem.id = null;
                            this.newItem.name = null;
                            this.newItem.code = null;
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
                axios.post('/remove-item', {id}).then((response) => {
                    response.data.success && this.shipment.items.splice(index, 1);
                    this.noty(response);
                }).then(() => {
                    this.preLoader = false;
                });
            },
            edit: function (item) {
                if (this.validate(item)) {
                    this.preLoader = true;
                    axios.post('/edit-item', {item}).then((response) => {
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

            validate: function (model) {
                return Number.isInteger(+model.id) &&
                    +model.id > 0 &&
                    model.code !== null &&
                    model.code.length > 0 &&
                    model.name !== null &&
                    model.name.length > 0;
            },
        }
    }
</script>

<style scoped>
    .edit-item input {
        width: 70%;
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

