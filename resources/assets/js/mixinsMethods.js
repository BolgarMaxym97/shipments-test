export default {
    methods: {
        noty: function (response) {
            Vue.notify({
                group: 'shipments',
                type: response.data.success ? 'success' : 'error',
                text: response.data.message
            });
        }
    }
}