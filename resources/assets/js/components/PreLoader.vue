<template>
    <div class="loader">
        <span v-if="display" class="fa fa-spinner"></span>
    </div>
</template>

<script>
    export default {
        props: [
            'display'
        ]
    }
</script>

<style scoped>
    .loader span {
        margin-left: 10px;
    }
    span {
        -webkit-animation: spin 1s infinite linear;
    }

    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
        }
    }
</style>
