<template>
    <button  @click="modalOpen()" class="btn btn-primary create__button px-4">
          <span class="pr-2">
              <i class="ti-plus icon"></i>
          </span>
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: {
            pageHeading: {
                type: String,
                default: "Dashboard",
            },
            modalId: {
                type: String,
                default: "formModal",
            },
            modalHeader: {
                type: String,
                default: "Add New",
            },
            buttonText: {
                type: String,
                default: "Add New",
            },
            PermissionName: {
                type: String,
            },
        },
        methods: {
            modalOpen() {
                let _this = this;
                _this.$emit("resetForm");
                _this.openModal(_this.modalId, _this.modalHeader);
            },
        },
        mounted() {},
    };
</script>

<style lang="scss" scoped>
    .icon {
        font-size: 10px;
    }
</style>
