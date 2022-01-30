<template>
    <div>
        <h2 class="">{{this.$route.meta.pageTitle}}</h2>
    </div>

</template>

<script>
    export default {

        mounted() {
            document.title=this.$route.meta.pageTitle

        }
    }
</script>
