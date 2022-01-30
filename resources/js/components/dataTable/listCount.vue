<template>
    <div class="col-md-12">
        Showing {{ dataList.from ? dataList.from : 0 }} To {{ dataList.to ? dataList.to : 0 }} of {{ dataList.total }} entries
    </div>
</template>

<script>
export default {
    name: "listCount",

    props: {
        dataListCount: {
            type: [Object, Array],
            require: false,
            default: null
        }
    }
}
</script>
