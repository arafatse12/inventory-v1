<template>
    <button class="btn eye_button p-3" type="button">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>
    </button>
</template>

<script>
export default {
    name: "deleteButton"
}
</script>

<style lang="scss" scoped>
.eye_button {
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
    //color: #1F93EF00;
}
</style>
