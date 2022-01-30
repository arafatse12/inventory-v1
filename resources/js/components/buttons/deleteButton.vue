<template>
    <button class="btn delete__button p-2" type="button">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>
    </button>
</template>

<script>
export default {
    name: "deleteButton"
}
</script>

<style lang="scss" scoped>
.delete__button {
    width: 35px;
    height: 35px;
    border-radius: 50rem;
    background-color: #80808047;
    opacity: 0.6;
    display: flex;
    align-items: center;
    justify-content: center;
}
.delete__button:hover {
    opacity: 1;
    background-color: rgba(128, 128, 128, 0.29);
}

.icon {
    width: 20px;
    height: 20px;
    color: #e80303;
}
</style>
