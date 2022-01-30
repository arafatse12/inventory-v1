<template>
    <div class="modal fade" :id="modalId">
        <div :class="`modal-dialog ${modalSize}`">
            <div class="modal-content">
                <form @submit.prevent="submit()">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ modalTitle }}</h4>
                        <button type="button" @click="closeModal(modalId)" class="btn cur-p btn-outline-info">&times;
                        </button>

                    </div>
                    <div class="modal-body clearfix">
                        <slot></slot>
                    </div>
                    <div class="modal-footer">

                        <button type="button" @click="closeModal(modalId)" class="btn cur-p btn-outline-danger">Close
                        </button>

                        <button type="submit" class="btn cur-p btn-outline-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "formModal",
        props: {
            modalId: {
                type: [String],
                default: "formModal",
            },
            modalSize: {
                type: [String],
                default: "modal-xl",
            }
        },
        methods: {
            submit: function () {
                this.$emit("submit");
            },
        },
    };
</script>

